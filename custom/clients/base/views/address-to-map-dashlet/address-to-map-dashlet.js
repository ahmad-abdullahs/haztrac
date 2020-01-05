/**
 * @class View.Views.Base.DashablelistView
 * @alias SUGAR.App.view.views.BaseDashablelistView
 * @extends View.Views.Base.ListView
 */
({
    plugins: ['Dashlet'],
    bannedRelatedModules: ['Users', 'Teams'],
    relateFieldNameToID: {},

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    initDashlet: function (view) {
        this._super('initDashlet', [view]);
        if (this.meta.config) {
            this.settings.on('change:relate_field', function (model, value) {
                // On changing the relate field set the module in the settings so that
                // address fields are loaded on behalf of that.
                var relateFieldModule = app.data.getRelatedModule(this.layout.module, value) || value;
                if (_.isEmpty(relateFieldModule)) {
                    relateFieldModule = this.context.parent.get('module');
                }
                this.settings.set('module', relateFieldModule);

                this.settings.set('relate_field_id', this.relateFieldNameToID[value]);
                this.settings.set('address_field', '');

                // Set the address field on the basis of the relate field (module) selected.
                var selectedAddressName = this.updateAddressFieldsList(true);
                this.setLabel(relateFieldModule, selectedAddressName);
            }, this);

            // Set the label on change of Address field.
            this.settings.on('change:address_field', function (model, value) {
                if (this.getField('address_field')) {
                    value = this.getField('address_field').items[value];
                }
                this.setLabel(this.settings.get('module'), value);
            }, this);

            // Set the default module
            if (!this.settings._syncedAttributes.module) {
                this.settings.set('module', this.context.parent.get('module'));
            }

            // Set default options list 
            this._configureDashlet();
        }

        // Validation Part before save ...
        this.layout.before('dashletconfig:save', function () {
            if (!this.settings.get('address_field')) {
                if (!_.isEmpty(this.getAddressFieldsList(false))) {
                    app.alert.show('select-address-field-warning', {
                        level: 'warning',
                        messages: 'Please select the address field.',
                        closeable: true,
                        autoClose: true,
                        autoCloseDelay: 2000,
                    });
                } else {
                    app.alert.show('select-address-field-warning', {
                        level: 'error',
                        messages: 'There is no Address field in ' + this.getModuleName(this.settings.get('module'))
                                + ' module. Please add Address Field in '
                                + this.getModuleName(this.settings.get('module'))
                                + ' module to show on the Map.',
                        closeable: true,
                        autoClose: true,
                        autoCloseDelay: 5000,
                    });
                }
                // Don't save if validation fails ...
                return false;
            }
            return true;
        }, this);
    },

    _configureDashlet: function () {
        var addressFields = this.getAddressFieldsList(false),
                relateFields = this.getRelateFieldsList(this.context.parent.get('module'));
        _.each(this.getFieldMetaForView(this.meta), function (field) {
            switch (field.name) {
                case 'address_field':
                    field.options = addressFields;
                    break;
                case 'relate_field':
                    field.options = relateFields;
                    // Select the current selected module as a default option
                    this.updateRelateFieldsList(this.context.parent.get('module'));
                    break;
            }
        }, this);
    },

    render: function () {
        this._super('render');

        if (this.context.parent && this.closestComponent('records')) {
            if (!_.isUndefined(this.context.parent.get('collection')) && !_.isNull(this.context.parent.get('collection'))) {
                this.context.parent.get('collection').on('reset', _.bind(this.render, this), this);
            }
        }

        // loading maps api if not loaded
        if (typeof (google) == "undefined" && !this.mapsApiAdded) {
            var script = document.createElement('script');
            script.src = "//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAyAAyXJDGMIgFTJXsmdQdsnoS_XDQu62o";
            script.onload = _.bind(this.setupMap, this);
            document.body.appendChild(script);

            this.mapsApiAdded = true;

            return;
        }

        this.setupMap();
    },

    /**
     * loads the map and displays the markers
     */
    setupMap: function () {
        if (typeof (google) == "undefined") {
            return;
        }
        var self = this;
        // Display a map on the page
        var canvas = this.$el.find('#map_canvas').get(0);
        // set default center to NY, USA
        var latlng = new google.maps.LatLng(40.7128, -74.0060);
        var settings = {
            zoom: this.closestComponent('records') ? 3 : 8,
            tilt: 45,
            center: latlng,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
            navigationControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(canvas, settings);

        var addressFields = this.getMapAddressFields(this.settings.get('module'));
        addressFields = _.keys(addressFields);
        addressFields.push('id');
        addressFields.push('name');

        if (this.closestComponent('records')) {
            if (this.context.parent.get('collection').models.length > 0) {
                var idName = this.settings.get('relate_field_id')
                if (this.settings.get('relate_field') === this.context.parent.get('module')) {
                    idName = 'id';
                }

                var idsList = [];
                _.each(this.context.parent.get('collection').models, function (model) {
                    idsList.push(model.get(idName));
                }, this);

                var collection = app.data.createBeanCollection(this.settings.get('module'));
                collection.filterDef = [];
                collection.filterDef.push({
                    'id': {
                        '$in': idsList
                    }
                });

                collection.fetch({
                    'showAlerts': false,
                    'fields': addressFields,
                    'limit': -1,
                    'success': _.bind(function (data) {
                        _.each(data.models, function (model) {
                            this.loadMap(model);
                        }, this);
                    }, this)
                });
            }
        } else if (this.closestComponent('record')) {
            var model = this.context.parent.get('model');
            var id = model.get(this.settings.get('relate_field_id'));
            if (this.settings.get('relate_field') === this.context.parent.get('module')) {
                id = model.get('id');
            }
            var fetchModel = app.data.createBean(this.settings.get('module'), {
                id: id,
            });
            fetchModel.fetch({
                'fields': addressFields,
                success: function (fetchedBean) {
                    self.loadMap(fetchedBean);
                },
                error: function (err) {
                    app.logger.error('Failed to fetch model : ' + JSON.stringify(err));
                }
            });
        }
    },

    loadMap: function (fetchModel) {
        var retData = {};
        retData = this.getMapAddressString(fetchModel);
        var geocoder = new google.maps.Geocoder();
        if (geocoder && !_.isEmpty(retData.address)) {
            geocoder.geocode({
                'address': retData.address
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                        map.setCenter(results[0].geometry.location);

                        var _marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            title: retData.title,
                            recordID: fetchModel.get('id'),
                            moduleName: fetchModel.get('_module') || fetchModel.get('module'),
                            recordModel: fetchModel,
                        });

                        google.maps.event.addListener(_marker, 'click', function () {
                            var drawerModel = app.data.createBean(fetchModel.get('_module') || fetchModel.get('module'), {
                                id: fetchModel.get('id'),
                            });
                            drawerModel.fetch({
                                success: function (drawerBean) {
                                    app.drawer.open({
                                        layout: 'record',
                                        context: {
                                            module: fetchModel.get('_module') || fetchModel.get('module'),
                                            model: drawerBean,
                                            modelId: fetchModel.get('id'),
                                            initiatedByMapView: true,
                                            loadSpecifiedPanels: [
                                                'sales_and_services_revenuelineitems_1',
                                            ],
                                        }
                                    });
                                },
                                error: function (err) {
                                    app.logger.error('Failed to fetch drawerModel : ' + JSON.stringify(err));
                                }
                            });
                        });

                    } else {
                        console.log("No Geocode results found");
                    }
                } else {
                    console.log("Geocode was not successful for the following reason: " + status);
                }
            });
        }

    },

    getMapAddressFields: function (module) {
        var addressFields = {};
        _.each(app.metadata.getModule(module).fields, function (field) {
            if (!_.isUndefined(field.group)) {
                if (field.group == this.settings.get('address_field')) {
                    addressFields[field.name] = '';
                }
            }
        }, this);
        return addressFields;
    },

    getMapAddressString: function (fetchedBean) {
        var addressFields = {},
                module = this.settings.get('module');

        addressFields = this.getMapAddressFields(module);

        var street = '', city = '', postalcode = '', country = '', addressStr = '', title = '', addressArr = [];
        if (!_.isEmpty(addressFields)) {
            _.each(addressFields, function (val, field) {
                addressFields[field] = fetchedBean.get(field);
            }, this);

            _.each(addressFields, function (val, field) {
                if (field.includes('street') && _.isEmpty(street)) {
                    street = val;
                }
                if (field.includes('city') && _.isEmpty(city)) {
                    city = val;
                }
                if (field.includes('postalcode') && _.isEmpty(postalcode)) {
                    postalcode = val;
                }
                if (field.includes('country') && _.isEmpty(country)) {
                    country = val;
                }
            }, this);

            addressArr.push(street);
            addressArr.push(city);
            addressArr.push(postalcode);
            addressArr.push(country);
            addressArr = _.compact(addressArr);
            addressStr = addressArr.join(', ');
            title = fetchedBean.get('name') + "\n" + addressStr;
        }
        return {
            address: addressStr,
            title: title,
        };
    },
    /*
     * Get the Address fields on the basis of relate field (module) selected.
     */
    getAddressFieldsList: function (onChange) {
        var addressFields = {},
                module = this.settings.get('module');

        if (this.settings._syncedAttributes.hasOwnProperty('address_field') && onChange != true) {
            module = this.settings._syncedAttributes.module;
        }

        if (!module) {
            return addressFields;
        }

        _.each(app.metadata.getModule(module).fields, function (field) {
            if (!_.isUndefined(field.group) && !_.isUndefined(field.group_label)) {
                if (field.group.includes('address')) {
                    addressFields[field.group] = app.lang.get(field.group_label || field.vname || field.name, module);
                }
            }
        });

        return addressFields;
    },

    /*
     * Get the address fields list and set it to the field
     */
    updateAddressFieldsList: function (onChange) {
        var addressFields = this.getAddressFieldsList(onChange),
                fieldName = 'address_field',
                field = this.getField(fieldName);
        if (field) {
            field.items = addressFields;
        }

        if (!this.settings._syncedAttributes.hasOwnProperty('address_field')) {
            this.settings.set(fieldName, _.keys(addressFields)[0]);
        }

        if (field) {
            return field.items[_.keys(addressFields)[0]];
        }
        return '';
    },

    /*
     * Get the list of relate fields in the module, on top of that dashlet is beign configured
     */
    getRelateFieldsList: function (moduleName) {
        var fieldDefs = app.metadata.getModule(moduleName).fields;
        var relateFields = _.filter(fieldDefs, function (field) {
            if (!_.isUndefined(field.type) && (field.type === 'relate') && (!_.contains(this.bannedRelatedModules, field.module))) {
                this.relateFieldNameToID[field.name] = field.id_name;
                return true;
            }
            return false;
        }, this);

        // Add the module it self entry in the relate field list in onder to show 
        // the module own address field on the map
        var result = {
            [moduleName]: this.getModuleName(moduleName)
        };

        _.each(relateFields, function (field) {
            result[field.name] = app.lang.get(field.vname || field.name, [moduleName]);
        }, this);
        return result;
    },

    /*
     * Get the relate fields list and set it to the field 
     */
    updateRelateFieldsList: function (moduleName) {
        var relateFieldsList = this.getRelateFieldsList(moduleName),
                field = this.getField('relate_field');
        if (field) {
            field.items = relateFieldsList;
        }
        if (!this.settings._syncedAttributes.hasOwnProperty('relate_field')) {
            this.settings.set('relate_field', _.keys(relateFieldsList)[0]);
            this.settings.set('relate_field_id', this.relateFieldNameToID[_.keys(relateFieldsList)[0]]);
        }
    },

    /*
     * Return the meta of the dashlet
     */
    getFieldMetaForView: function (meta) {
        meta = _.isObject(meta) ? meta : {};
        return !_.isUndefined(meta.panels) ? _.flatten(_.pluck(meta.panels, 'fields')) : [];
    },

    /*
     * Return the module label from its name
     */
    getModuleName: function (module) {
        return  app.lang.getModuleName(module, {plural: true});
    },

    /*
     * Set the label for dashlet
     */
    setLabel: function (module, selectedAddressName) {
        if (_.isEmpty(module) || _.isEmpty(selectedAddressName)) {
            this.settings.set('label', '');
        } else {
            this.settings.set('label', this.getModuleName(module) + ' ' + selectedAddressName);
        }
    }
})