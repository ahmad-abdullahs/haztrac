({
    extendsFrom: 'DashablelistView',

    mapsApiAdded: false,

    _defaultSettings: {
        limit: 5,
        intelligent: '0'
    },

    /**
     * @inheritdoc
     */
    initDashlet: function (view) {
        this._super('initDashlet', [view]);
        this.settings.on('change:filter', _.bind(this.reApplyFilter, this), this);
        if (this.context.parent) {
            if (!_.isUndefined(this.context.parent.get('collection')) && !_.isNull(this.context.parent.get('collection'))) {
                this.context.parent.get('collection').on('reset', _.bind(this.reApplyFilter, this), this);
            }
        }

        app.events.on('loadMapForSelectedRows', this.loadMapForSelectedRows, this);
    },

    loadMapForSelectedRows: function (ids) {
        this._displayDashlet([{
                'id': {
                    '$in': ids,
                }
            }], true);
    },

    /**
     * @Override
     */
    reApplyFilter: function () {
        if (this.disposed || this.meta.config) {
            return;
        }

        this._displayDashlet();
    },

    /**
     * @Override
     */
    _displayDashlet: function (filterDef, flag) {
        filterDef = filterDef || [];
        var listViewFilterDef = [];

        if (this.context.parent)
            if (!_.isUndefined(this.context.parent.get('collection')) && !_.isNull(this.context.parent.get('collection')))
                listViewFilterDef = this.context.parent.get('collection').filterDef;

        if (flag == true) {
            filterDef = _.union(filterDef, listViewFilterDef, [{
                    'on_date_c': {
                        '$dateRange': this.settings.get('filter')
                    }
                }]);
        } else {
            filterDef = _.union(listViewFilterDef, [{
                    'on_date_c': {
                        '$dateRange': this.settings.get('filter')
                    }
                }]);
        }

        this._super('_displayDashlet', [filterDef]);
    },

    /**
     * @Override
     */
    updateDashletFilterAndSave: function (filterModel) {
        var componentType = this.dashModel.get('componentType') || 'view';

        // Adding a new dashlet requires componentType to be set on the model.
        if (!this.dashModel.get('componentType')) {
            this.dashModel.set('componentType', componentType);
        }

        app.drawer.close(this.dashModel);
        app.events.trigger('dashlet:filter:save', this.dashModel.get('module'));
    },

    /**
     * @Override
     */
    _addFilterComponent: function () {},

    /**
     * @Override
     */
    render: function () {
        this._super('render');

        // loading maps api if not loaded
        if (typeof (google) == "undefined" && !this.mapsApiAdded) {
            var script = document.createElement('script');
            script.src = "//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAyAAyXJDGMIgFTJXsmdQdsnoS_XDQu62o";
            script.onload = _.bind(this.loadMap, this);
            document.body.appendChild(script);

            this.mapsApiAdded = true;

            return;
        }

        this.loadMap();
    },

    /**
     * loads the map and displays the markers
     */
    loadMap: function () {
        if (typeof (google) == "undefined") {
            return;
        }

        // Display a map on the page
        var canvas = this.$el.find('#map_canvas').get(0);
        var map = new google.maps.Map(canvas, {
            mapTypeId: 'roadmap'
        });
        map.setTilt(45);

        // set default center to NY, USA
        map.setCenter({lat: 40.7128, lng: -74.0060})
        map.setZoom(8);

        // if markers are available then show them
        if (this.collection.models.length > 0) {
            var bounds = new google.maps.LatLngBounds();

            _.each(this.collection.models, function (model) {
                var address = [], fieldsList = [];

                if (!_.isEmpty(model.get('service_site_address_name'))) {
                    fieldsList = ['service_site_address_street_c',
                        'service_site_address_city_c',
                        'service_site_address_state_c',
                        'service_site_address_postalcode_c',
                        'service_site_address_country_c'];
                } else {
                    fieldsList = ['shipping_address_street_c',
                        'shipping_address_city_c',
                        'shipping_address_state_c',
                        'shipping_address_postalcode_c',
                        'shipping_address_country_c'];
                }
                _.each(fieldsList, function (val, key) {
                    address.push(model.get(val));
                });

                address = _.compact(address);
                address = address.toString();

                var name = !_.isEmpty(model.get('name')) ? model.get('name') + "\n" : '';
                var accountName = !_.isEmpty(model.get('accounts_sales_and_services_1_name')) ? model.get('accounts_sales_and_services_1_name') + "\n" : '';
                var title = name + accountName + address;

                var position = new google.maps.LatLng(model.get('lat_c'), model.get('lon_c'));
                var _marker = new google.maps.Marker({
                    map: map,
                    position: position,
                    title: title,
                    recordID: model.get('id'),
                    moduleName: model.get('_module'),
                    recordModel: model,
                    // url: 'www.google.com',
                });

                bounds.extend(position);

                google.maps.event.addListener(_marker, 'click', function () {
                    // window.open(this.url, '_blank');
                    app.drawer.open({
                        layout: 'record',
                        context: {
                            module: this.moduleName,
                            model: this.recordModel,
                            modelId: this.recordID,
                            initiatedByMapView: true,
                            loadSpecifiedPanels: [
                                'sales_and_services_revenuelineitems_1',
                            ],
                        }
                    });
                });
            }, this);

            map.fitBounds(bounds);
            map.setZoom(14);
        }
    }
})
