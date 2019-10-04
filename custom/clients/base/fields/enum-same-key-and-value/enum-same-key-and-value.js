/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Fields.Base.EnumField
 * @alias SUGAR.App.view.fields.BaseEnumField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'EnumField',

    fieldTag: 'input.select2',

    appendValueTag: 'input[name=append_value]',

    isFetchingOptions: false,

    items: null,

    _keysOrder: null,

    /**
     * @override
     * @protected
     * @chainable
     */
    _render: function () {
        var self = this;
        if (!this.items || _.isEmpty(this.items)) {
            this.loadEnumOptions(false, function () {
                self.isFetchingOptions = false;
                //Re-render widget since we have fresh options list
                if (!this.disposed) {
                    this.render();
                }
            });
            if (this.isFetchingOptions) {
                // Set loading message in place of empty DIV while options are loaded via API
                this.$el.html('<div class="select2-loading">' + app.lang.get('LBL_LOADING') + '</div>');
                return this;
            }
        }
        //Use blank value label for blank values on multiselects
        if (this.def.isMultiSelect && !_.isUndefined(this.items['']) && this.items[''] === '') {
            var obj = {};
            _.each(this.items, function (value, key) {
                // Only work on key => value pairs that are not both blank
                if (key !== '' && value !== '') {
                    obj[key] = value;
                }
            }, this);
            this.items = obj;
        }
        this.items = this._filterOptions(this.items);

        // make key and value same.
        if (this.action === 'detail' && this.tplName === 'detail' && !_.isEmpty(this.items)) {
            var newItemList = _.clone(this.items);
            _.each(this.items, function (_val, _key) {
                newItemList[_key] = _key;
            });
            this.itemss = newItemList;
        }

        var optionsKeys = _.isObject(this.items) ? _.keys(this.items) : [],
                defaultValue = this._checkForDefaultValue(this.model.get(this.name), optionsKeys);

        app.view.Field.prototype._render.call(this);
        // if displaying the noaccess template, just exit the method
        if (this.tplName == 'noaccess') {
            return this;
        }
        var select2Options = this.getSelect2Options(optionsKeys);
        var $el = this.$(this.fieldTag);
        //FIXME remove check for tplName SC-2608
        if (this.tplName === 'edit' || this.tplName === 'list-edit' || this.tplName === 'massupdate') {
            $el.select2(select2Options);
            var plugin = $el.data('select2');

            if (plugin && this.dir) {
                plugin.container.attr('dir', this.dir);
                plugin.results.attr('dir', this.dir);
            }

            if (plugin && plugin.focusser) {
                plugin.focusser.on('select2-focus', _.bind(_.debounce(this.handleFocus, 0), this));
            }
            $el.on('change', function (ev) {
                var value = ev.val;
                if (_.isUndefined(value)) {
                    return;
                }
                if (self.model) {
                    self.model.set(self.name, self.unformat(value));
                }
            });
            if (this.def.isMultiSelect && this.def.ordered) {
                $el.select2('container').find('ul.select2-choices').sortable({
                    containment: 'parent',
                    start: function () {
                        $el.select2('onSortStart');
                    },
                    update: function () {
                        $el.select2('onSortEnd');
                    }
                });
            }
        } else if (this.tplName === 'disabled') {
            $el.select2(select2Options);
            $el.select2('disable');
        }
        //Setup selected value in Select2 widget
        if (!_.isUndefined(this.value)) {
            // To make pills load properly when autoselecting a string val
            // from a list val needs to be an array
            if (!_.isArray(this.value)) {
                this.value = [this.value];
            }
            // Trigger the `change` event only if we automatically set the
            // default value.
            $el.select2('val', this.value, !!defaultValue);
        }

        if (this.tplName === 'detail') {
            $('.select2-drop').select2('close');
        }

        return this;
    },
})
