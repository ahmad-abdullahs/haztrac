/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    extendsFrom: 'EnumField',
    duplicateItemsList: {},
    initialize: function (options) {
        this._super('initialize', [options]);
        Handlebars.registerHelper('setParentKey', function (value, objectToReference) {
            objectToReference.parentKey = value;
        });
        Handlebars.registerHelper('compare', function (lvalue, operator, rvalue, options) {
            var operators, result;

            if (arguments.length < 3) {
                throw new Error("Handlerbars Helper 'compare' needs 2 parameters");
            }

            if (options === undefined) {
                options = rvalue;
                rvalue = operator;
                operator = "===";
            }

            operators = {
                '==': function (l, r) {
                    return l == r;
                },
                '===': function (l, r) {
                    return l === r;
                },
                '!=': function (l, r) {
                    return l != r;
                },
                '!==': function (l, r) {
                    return l !== r;
                },
                '<': function (l, r) {
                    return l < r;
                },
                '>': function (l, r) {
                    return l > r;
                },
                '<=': function (l, r) {
                    return l <= r;
                },
                '>=': function (l, r) {
                    return l >= r;
                },
                'typeof': function (l, r) {
                    return typeof l == r;
                },
                '%': function (l, r) {
                    return l % r == 0;
                }
            };

            if (!operators[operator]) {
                throw new Error("Handlerbars Helper 'compare' doesn't know the operator " + operator);
            }

            result = operators[operator](lvalue, rvalue);

            if (result) {
                return options.fn(this);
            } else {
                return options.inverse(this);
            }
        });
    },
    render: function () {
        this._super('render');
    },
    format: function (value) {
        if (_.isArray(value) && _.indexOf(value, '') > -1) {
            value = _.clone(value);
            delete value[''];
        }
        if (_.isString(value)) {
            return this.convertMultiSelectDefaultString(value);
        }
        return value;
    },
    unformat: function (value) {
        var item = '';
        item = '^' + $("input." + this.name + ":checked").map(
                function () {
                    return $(this).attr('data-value');
                }
        ).get().join("^,^") + '^';
        return item;
    },
    bindDomChange: function () {
        var self = this;
        var $el = this.$('input[type=checkbox]');
        var $label_el = this.$('.checkbox-label');
        if ($el.length) {
            $el.on('change', _.bind(function () {
                this.view.notifyChange = true;
                this.model.set(this.name, this.unformat(this.model.get(this.name)));
            }, this));
        }
        if ($label_el.length) {
            $label_el.on('click', _.bind(function (e) {
                var identifier = $(e.currentTarget).data('identifier');
                self.$('input[type=checkbox][data-value="' + identifier + '"]').click();
            }));
        }
    },
    unbindDom: function () {
        var $el = this.$('input[type=checkbox]');
        var $label_el = this.$('.checkbox-label');
        $el.off('change click');
        $label_el.off('click');
        this._super('unbindDom');
    },
    getSelect2Options: function (optionsKeys) {
        var select2Options = {};
        var emptyIdx = _.indexOf(optionsKeys, "");
        if (emptyIdx !== -1) {
            select2Options.allowClear = true;
            // if the blank option isn't at the top of the list we have to add it manually
            if (emptyIdx > 1) {
                this.hasBlank = true;
            }
        }

        /* From http://ivaynberg.github.com/select2/#documentation:
         * Initial value that is selected if no other selection is made
         */
        if (!this.def.isMultiSelect) {
            select2Options.placeholder = app.lang.get("LBL_SEARCH_SELECT");
        }
        // Options are being loaded via app.api.enum
        if (_.isEmpty(optionsKeys)) {
//            select2Options.placeholder = app.lang.get("LBL_LOADING");
        }

        /* From http://ivaynberg.github.com/select2/#documentation:
         * "Calculate the width of the container div to the source element"
         */
        select2Options.width = this.def.enum_width ? this.def.enum_width : '100%';

        /* Because the select2 dropdown is appended to <body>, we need to be able
         * to pass a classname to the constructor to allow for custom styling
         */
        select2Options.dropdownCssClass = this.def.dropdown_class ? this.def.dropdown_class : '';

        /* To get the Select2 multi-select pills to have our styling, we need to be able
         * to either pass a classname to the constructor to allow for custom styling
         * or set the 'select2-choices-pills-close' if the isMultiSelect option is set in def
         */
        select2Options.containerCssClass = this.def.container_class ? this.def.container_class : (this.def.isMultiSelect ? 'select2-choices-pills-close' : '');

        /* Because the select2 dropdown is calculated at render to be as wide as container
         * to make it differ the dropdownCss.width must be set (i.e.,100%,auto)
         */
        if (this.def.dropdown_width) {
            select2Options.dropdownCss = {width: this.def.dropdown_width};
        }

        /* All select2 dropdowns should only show the search bar for fields with 7 or more values,
         * this adds the ability to specify that threshold in metadata.
         */
        select2Options.minimumResultsForSearch = this.def.searchBarThreshold ? this.def.searchBarThreshold : 7;

        /* If is multi-select, set multiple option on Select2 widget.
         */
        if (this.def.isMultiSelect) {
            select2Options.multiple = true;
        }

        /* If we need to define a custom value separator
         */
        select2Options.separator = this.def.separator || ',';
        if (this.def.separator) {
            select2Options.tokenSeparators = [this.def.separator];
        }

        select2Options.initSelection = _.bind(this._initSelection, this);
        select2Options.query = _.bind(this._query, this);
        select2Options.sortResults = _.bind(this._sortResults, this);

        return select2Options;
    },
    _render: function () {
        this._super('_render');

        // Show the multicheck box list in linear fashion...
        this.$el.css('display', 'flex');

        var optionsKeys = _.isObject(this.items) ? _.keys(this.items) : [];
        if (_.isEmpty(optionsKeys)) {
            this.$el.html('');
        }
        return this;
    },
})