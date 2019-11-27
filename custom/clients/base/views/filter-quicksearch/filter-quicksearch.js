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
 * View for doing a quick search.
 *
 * Part of {@link View.Layouts.Base.FilterLayout}.
 *
 * @class View.Views.Base.FilterQuicksearchView
 * @alias SUGAR.App.view.views.BaseFilterQuicksearchView
 * @extends View.View
 */
({
    extendsFrom: 'FilterQuicksearchView',

    /**
     * Update quick search placeholder to Search by Field1, Field2, Field3 when the module changes
     * @param string linkModuleName
     * @param string linkModule
     */
    updatePlaceholder: function (linkModuleName, linkModule) {
        var label;
        this.toggleInput();
        if (!this.$el.hasClass('hide') && linkModule !== 'all_modules') {
            var filtersBeanPrototype = app.data.getBeanClass('Filters').prototype,
                    fields = filtersBeanPrototype.getModuleQuickSearchMeta(linkModuleName).fieldNames,
                    fieldLabels = this.getFieldLabels(linkModuleName, fields);
            label = app.lang.get('LBL_SEARCH_BY') + ' ' + fieldLabels.join(', ') + '...';
        } else {
            label = app.lang.get('LBL_BASIC_QUICK_SEARCH');
        }

        var modules = [
            "Contacts",
            "Accounts",
            "Leads",
            "Prospects",
            "Opportunities",
            "sales_and_services",
            "HT_Assets_and_Objects",
            "LR_Lab_Reports",
            "HT_Manifest",
            "HT_PO",
//            "RevenueLineItems",
            "WPM_Waste_Profile_Module",
            "HRM_Employee_Training",
            "PNL_Permits_Licenses",
            "LR_Lab_Reports_Templates",
            "WT_Waste_Tracking",
        ];
        if (modules.indexOf(linkModuleName) != '-1') {
            label = app.lang.get('LBL_SEARCH_BY') + ' anything';
        }

        var input = this.$el.attr('placeholder', label);
        this.$el.attr('aria-label', label);
    },
})
