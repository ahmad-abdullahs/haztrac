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
        this._initPlaceholderAttribute();
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

        this.$el.parents('[data-type=' + this.name + ']').css('background-color', 'whitesmoke');

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

    /**
     * Called to update value when a selection is made from options view dialog
     * @param model New value for teamset
     */
    setValue: function (model) {
        if (!model) {
            return;
        }

        var index = this._currentIndex, record = this.value;
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
            if (_.isEmpty(value)) {
                value = [{}];
            }
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