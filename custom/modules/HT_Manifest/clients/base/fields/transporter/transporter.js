({
    extendsFrom: 'RelateField',

    events: {
        'click .btn[name=add]': 'addItem',
        'click .btn[name=remove]': 'removeItem'
    },

    dateTag: 'input[data-type=date]',
    fieldPlaceholder: '',

    dateOptions: {
        hash: {
            dateOnly: true
        }
    },

    initialize: function (options) {
        this._super('initialize', [options]);
        Handlebars.registerHelper('add', function (leftopp, rightopp) {
            return Number(leftopp) + Number(rightopp);
        });
        this._initPlaceholderAttribute();
    },

    render: function () {
        this._super('render');

        var sortableItems;
        sortableItems = this.$('tbody');
        if (sortableItems.length) {
            _.each(sortableItems, function (sortableItem) {
                $(sortableItem).sortable({
                    // allow draggable items to be connected with other tbody elements
                    connectWith: 'tbody',
                    // allow drag to only go in Y axis direction
                    axis: 'y',
                    // the items to make sortable
                    items: 'tr.sortable',
                    // make the "helper" row (the row the user actually drags around) a clone of the original row
                    helper: 'clone',
                    // adds a slow animation when "dropping" a group, removing this causes the row
                    // to immediately snap into place wherever it's sorted
                    revert: true,
                    // the CSS class to apply to the placeholder underneath the helper clone the user is dragging
                    placeholder: 'ui-state-highlight',
                    // handler for when dragging starts
                    start: _.bind(this._onDragStart, this),
                    // handler for when dragging stops; the "drop" event
                    stop: _.bind(this._onDragStop, this),
                    // handler for when dragging an item into a group
                    over: _.bind(this._onGroupDragTriggerOver, this),
                    // handler for when dragging an item out of a group
                    out: _.bind(this._onGroupDragTriggerOut, this),
                    // the cursor to use when dragging
                    cursor: 'move'
                });
            }, this);
        }

    },
    _onDragStart: function (evt, ui) {
//        console.log('_onDragStart : ', this, evt, ui);
    },
    _onDragStop: function (evt, ui) {
//        console.log('_onDragStop : ', this, evt, ui);

        // This function will go over each row one by one, get the line_number value (This line_number value is the index
        // of that data object in this.value array), extract that object from the index and push it to the new array for
        // re-ordering the rows. 
        // Finally set the value and render the field.
        var newValue = [];

        _.each(this.$('tbody > tr.ui-sortable-handle'), function (ele) {
            var obj = this.value[$(ele).attr('line_number')];
            newValue.push(obj);
        }, this);

        this.model.set(this.name, newValue);
        this.render();
    },
    _onGroupDragTriggerOver: function (evt, ui) {
//        console.log('_onGroupDragTriggerOver : ', this, evt, ui);
    },
    _onGroupDragTriggerOut: function (evt, ui) {
//        console.log('_onGroupDragTriggerOut : ', this, evt, ui);
    },

    _initPlaceholderAttribute: function () {
        var placeholder = app.date.toDatepickerFormat(this.getUserDateFormat());

        this.fieldPlaceholder = this.def.placeholder && app.lang.get(
                this.def.placeholder,
                this.module,
                {format: placeholder}
        ) || placeholder;

        return this;
    },

    getUserDateFormat: function () {
        return app.user.getPreference('datepref');
    },

    /**
     * @inheritdoc
     */
    _render: function () {
        if (this._hasDatePicker) {
            this.$(this.dateTag).datepicker('hide');
        }

        this._super('_render');

//        this.$el.parents('[data-type=' + this.name + ']').css('background-color', 'whitesmoke');

        if (this.tplName !== 'edit' && this.tplName !== 'massupdate') {
            this._hasDatePicker = false;
            return;
        }

        var self = this;
        this.$(this.dateTag).each(function (index, el) {
            self._setupDatePicker(el);
        });

        this.$(this.fieldTag).each(function (index, el) {
            var plugin = $(el).data("select2");
            // If there is a plugin but no record index, set it
            if (!_.isUndefined(plugin) && _.isUndefined(plugin.setTransIndex)) {
                plugin.setTransIndex = function () {
                    self._currentIndex = $(this).data("index");
                };
                plugin.opts.element.on("select2-open", plugin.setTransIndex);
            }
        });
    },

    _onSelect2Change: function (e) {
        var $el = $(e.target);
        var plugin = $el.data('select2');
        var id = e.val;
        var _index = $(e.target).closest('tr').index();

        if (_.isUndefined(id)) {
            return;
        }

        // For multiselect fields, we update the data-rname attributes
        // so it stays in sync with the id list, and allows us to use
        // 'setValue' method. The use of 'setValue' method is required
        // to re-render the field.
        if (this.def.isMultiSelect) {
            var dataRname = plugin.opts.element.data('rname');
            dataRname = dataRname ? dataRname.split(this._separator) : [];
            var ids = $el.select2('val');

            if (e.added) {
                dataRname.push(e.added.text);
            } else if (e.removed) {
                dataRname = _.without(dataRname, e.removed.text);
            } else {
                return;
            }
            var models = _.map(ids, function (id, index) {
                return {id: id, value: dataRname[index]};
            });

            this.setValue(models);
            return;
        }

        var value = (id) ? plugin.selection.find('span').text() : $el.data('rname');
        var collection = plugin.context;
        var attributes = {};
        if (collection && !_.isEmpty(id)) {
            // if we have search results use that to set new values
            var model = collection.get(id);
            attributes.id = model.id;
            attributes.value = model.get(this.getRelatedModuleField());
            _.each(model.attributes, function (value, field) {
                if (app.acl.hasAccessToModel('view', model, field)) {
                    attributes[field] = attributes[field] || model.get(field);
                }
            });
        } else if (e.currentTarget.value && value) {
            // if we have previous values keep them
            attributes.id = value;
            attributes.value = e.currentTarget.value;
        } else {
            // default to empty
            attributes.id = '';
            attributes.value = '';
        }

        // _index is added to fix the bug, In edit mode when user hit the cross x icon on the relate field
        // despite of clearing the respective field, it clears the 0th index of field which was a bug
        // It is fixed through getting the index of div in the span.
        // <span>
        //      <div>Relate Field 1</div>
        //      <div>Relate Field 2</div>
        //      <div>Relate Field 3</div>
        // </span>
        this.setValue(attributes, _index);
    },

    /**
     * Called to update value when a selection is made from options view dialog
     * @param model New value for teamset
     */
    setValue: function (model, _index) {
        if (!model) {
            return;
        }

        var index = this._currentIndex, record = this.value;
        if (!_.isUndefined(_index) && !_.isNull(_index)) {
            index = _index;
        }

        record[index || 0].id = model.id;
        record[index || 0].name = model.value;

        this._updateAndTriggerChange(record);
    },

    /**
     * Forcing change event on value update since backbone isn't picking up on changes within an object within the array.
     * @param value New value for teamset field
     * @private
     */
    _updateAndTriggerChange: function (value) {
        // update dates in the value
        var self = this;
        this.$(this.dateTag).each(function (index, el) {
            var dateVal = app.date(
                    self.$(el).val(),
                    app.date.convertFormat(self.getUserDateFormat()),
                    true
                    );

            if (!_.isUndefined(value[index])) {
                if (dateVal.isValid()) {
                    value[index]['transfer_date'] = dateVal.formatServer(true);
                } else {
                    value[index]['transfer_date'] = '';
                }
            }
        });

        this.model.unset(this.name, {silent: true}).set(this.name, value);
        this.render();
    },

    /**
     * Return user date format.
     *
     * @return {String} User date format.
     */
    getUserDateFormat: function () {
        return app.user.getPreference('datepref');
    },

    /**
     * Patches our `dom_cal_*` metadata for use with date picker plugin since
     * they're very similar.
     *
     * @private
     */
    _patchPickerMeta: function () {
        var pickerMap = [], pickerMapKey, calMapIndex, mapLen, domCalKey,
                calProp, appListStrings, calendarPropsMap, i, filterIterator;

        appListStrings = app.metadata.getStrings('app_list_strings');

        filterIterator = function (v, k, l) {
            return v[1] !== "";
        };

        // Note that ordering here is used in following for loop
        calendarPropsMap = ['dom_cal_day_long', 'dom_cal_day_short', 'dom_cal_day_min', 'dom_cal_month_long', 'dom_cal_month_short'];

        for (calMapIndex = 0, mapLen = calendarPropsMap.length; calMapIndex < mapLen; calMapIndex++) {

            domCalKey = calendarPropsMap[calMapIndex];
            calProp = appListStrings[domCalKey];

            // Patches the metadata to work w/datepicker; initially, "calProp" will look like:
            // {0: "", 1: "Sunday", 2: "Monday", 3: "Tuesday", 4: "Wednesday", 5: "Thursday", 6: "Friday", 7: "Saturday"}
            // But we need:
            // ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]
            if (!_.isUndefined(calProp) && !_.isNull(calProp)) {
                // Reject the first 0: "" element and then map out the new language tuple
                // so it's back to an array of strings
                calProp = _.filter(calProp, filterIterator).map(function (prop) {
                    return prop[1];
                });
                //e.g. pushed the Sun in front to end (as required by datepicker)
                calProp.push(calProp);
            }
            switch (calMapIndex) {
                case 0:
                    pickerMapKey = 'day';
                    break;
                case 1:
                    pickerMapKey = 'daysShort';
                    break;
                case 2:
                    pickerMapKey = 'daysMin';
                    break;
                case 3:
                    pickerMapKey = 'months';
                    break;
                case 4:
                    pickerMapKey = 'monthsShort';
                    break;
            }
            pickerMap[pickerMapKey] = calProp;
        }
        return pickerMap;
    },

    /**
     * Set up date picker.
     *
     * We rely on the library to confirm that the date picker is only created
     * once.
     *
     * @protected
     */
    _setupDatePicker: function (el) {
        var self = this;
        var $field = this.$(el),
                userDateFormat = this.getUserDateFormat(),
                options = {
                    format: app.date.toDatepickerFormat(userDateFormat),
                    languageDictionary: this._patchPickerMeta(),
                    weekStart: parseInt(app.user.getPreference('first_day_of_week'), 10)
                };

        var appendToTarget = this._getAppendToTarget();
        if (appendToTarget) {
            options['appendTo'] = appendToTarget;
        }

        $field.datepicker(options).on('changeDate', function (ev) {
            self.$(this).change();
        });
        this._hasDatePicker = true;
    },

    /**
     * Retrieve an element against which the date picker should be appended to.
     *
     * @return {jQuery/undefined} Element against which the date picker should
     *   be appended to, `undefined` if none.
     * @private
     */
    _getAppendToTarget: function () {
        var component = this.closestComponent('main-pane') ||
                this.closestComponent('drawer') ||
                this.closestComponent('preview-pane');

        if (component) {
            return component.$el;
        }

        return;
    },

    /**
     * @inheritdoc
     */
    format: function (value) {
        if (_.isEmpty(value)) {
            value = [{}];
        }

        if (_.isArray(value) && !_.isEmpty(value)) {
            _.each(value, function (record, index, list) {
                delete record.remove_button;
                delete record.add_button;

                if (index === list.length - 1) {
                    record.add_button = true;
                }

                if (list.length !== 1) {
                    record.remove_button = true;
                }
            });
        }

        if (this.action !== 'edit' && !this.context.get('create')) {
            _.each(value, function (eachTransfer, index) {
                this.buildRoute(this.getSearchModule(), eachTransfer['id'], value, index);
            }, this);
        }

        return value;
    },

    buildRoute: function (module, id, value, index) {
        if (_.isUndefined(id)) {
            return;
        }

        var oldModule = module;
        // This is a workaround until bug 61478 is resolved to keep parity with 6.7
        if (module === 'Users' && this.context.get('module') !== 'Users') {
            module = 'Employees';
        }

        if (_.isEmpty(module)) {
            return;
        }

        var relatedRecord = this.model.get('ht_manifest_accounts_1');
        var action = this.viewDefs.route ? this.viewDefs.route.action : 'view';

        if (relatedRecord && app.acl.hasAccess(action, oldModule, {acls: relatedRecord._acl})) {
            this.href = '#' + app.router.buildRoute(module, id);
            //FIXME SC-6128 will remove this deprecated block.
        } else if (!relatedRecord) {
            value[index]['href'] = '#' + app.router.buildRoute(module, id);
            value[index]['iconVisibility'] = true;
        } else {
            // if no access to module, remove the href
            value[index]['href'] = undefined;
            value[index]['iconVisibility'] = false;
        }
    },

    /**
     * @inheritdoc
     */
    getSearchModule: function () {
        return 'Accounts';
    },

    /**
     * Adds a transporter to the list
     */
    addItem: _.debounce(function (evt) {
        var index = $(evt.currentTarget).data('index');
        //Only allow adding a Team when ones been selected (SP-534)
        if (!index || this.value[index].id) {
            this.value.push({});
            this._currentIndex++;
            this._updateAndTriggerChange(this.value);
        }
    }, 0),

    /**
     * Removes a transporter to the list
     */
    removeItem: _.debounce(function (evt) {
        var index = $(evt.currentTarget).data('index');
        if (_.isNumber(index)) {
            // Do not remove last team.
            if (index === 0 && this.value.length === 1) {
                return;
            }

            if (this._currentIndex === this.value.length - 1) {
                this._currentIndex--;
            }

            this.value.splice(index, 1);
            // this._updateAndTriggerChange(this.value);

            this.model.unset(this.name, {silent: true}).set(this.name, this.value);
            this.render();
        }
    }, 0),

    /**
     * @inheritdoc
     */
    bindDomChange: function () {
        var $el = this.$(this.dateTag);
        if ($el.length) {
            var self = this;
            $el.on('change', function () {
                self._updateAndTriggerChange(self.value);
            });
        }
        this._super('bindDomChange');
    },

    /**
     * @inheritdoc
     */
    unbindDom: function () {
        this.$(this.dateTag).off();
        this._super('unbindDom');
    },

    /**
     * @inheritdoc
     */
    _dispose: function () {
        if (this._hasDatePicker) {
            if (!_.isUndefined(this.$(this.fieldTag).data('datepicker')))
                $(window).off('resize', this.$(this.fieldTag).data('datepicker').place);
        }

        this._super('_dispose');
    },

    getFilterOptions: function (force) {
        this._filterOptions = new app.utils.FilterOptions()
                .config({
                    'initial_filter': 'filterByTransporterTag',
                    'initial_filter_label': 'LBL_FILTER_BY_TRANSPORTER_TAG',
                    'filter_populate': {
                        'tag': ['Transporter'],
                    }
                })
                .format();
        return this._filterOptions;
    },
})