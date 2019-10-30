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
 * View for the filter dropdown.
 *
 * Part of {@link View.Layouts.Base.FilterLayout}.
 *
 * @class View.Views.Base.FilterFilterDropdownView
 * @alias SUGAR.App.view.views.BaseFilterFilterDropdownView
 * @extends View.View
 */
({
    extendsFrom: 'FilterFilterDropdownView',

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function (opts) {
        opts.layout.layout.on('change:filter:badge', this.formatSelection, this);
        this._super('initialize', [opts]);
    },

    /**
     * Render select2 dropdown
     *
     * This function may be called even when this.render() is not because of
     * the "filter:render:filter" event listener.
     *
     * @private
     */
    _renderDropdown: function (data) {
        var self = this;
        this.filterNode = this.$(".search-filter");

        this.filterNode.select2({
            data: data,
            multiple: false,
            minimumResultsForSearch: 7,
            formatSelection: _.bind(this.formatSelection, this),
            formatResult: _.bind(this.formatResult, this),
            formatResultCssClass: _.bind(this.formatResultCssClass, this),
            dropdownCss: {width: 'auto'},
            dropdownCssClass: 'search-filter-dropdown',
            initSelection: _.bind(this.initSelection, this),
            escapeMarkup: function (m) {
                return m;
            },
            shouldFocusInput: function () {
                // We return false here so that we do not refocus on the field once
                // it has been blurred. If we return true, blur needs to happen
                // twice before it is really blurred.
                return false;
            },
            width: 'off'
        });

        // the shortcut keys need to be registered anytime this function is
        // called, not just on render
        app.shortcuts.register({
            id: 'Filter:Create',
            keys: ['f c', 'mod+alt+8'],
            component: this,
            description: 'LBL_SHORTCUT_FILTER_CREATE',
            handler: function () {
                // trigger the change event to open the edit filter drawer
                this.filterNode.select2('val', 'create', true);
            }
        });
        app.shortcuts.register({
            id: 'Filter:Edit',
            keys: 'f e',
            component: this,
            description: 'LBL_SHORTCUT_FILTER_EDIT',
            handler: function () {
                this.$('.choice-filter.choice-filter-clickable').click();
            }
        });
        app.shortcuts.register({
            id: 'Filter:Show',
            keys: 'f m',
            component: this,
            description: 'LBL_SHORTCUT_FILTER_SHOW',
            handler: function () {
                this.filterNode.select2('open');
            }
        });

        if (!this.filterDropdownEnabled) {
            this.filterNode.select2("disable");
        }

        this.filterNode.off("change");
        this.filterNode.on("change", function (e) {
            self.layout.trigger('filter:change:filter', e.val);
            self.layout.layout.trigger('change:filter:tab', e.val);
        });
    },

})
