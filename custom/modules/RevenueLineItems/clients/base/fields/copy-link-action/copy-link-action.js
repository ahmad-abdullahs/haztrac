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
 * "Link existing record" action used in Subpanels.
 *
 * It needs to be sticky so that we keep things lined up nicely.
 *
 * @class View.Fields.Base.LinkActionField
 * @alias SUGAR.App.view.fields.BaseLinkActionField
 * @extends View.Fields.Base.StickyRowactionField
 */
({
    extendsFrom: 'LinkActionField',
    events: {
        'click a[name=copy_select_button]': 'openSelectDrawer'
    },

    /**
     * Format drawer options used by {@link #openSelectDrawer}.
     *
     * By default it uses {@link View.Layouts.Base.SelectionListLayout} layout.
     * You can extend this method if you need to pass more or different options.
     *
     * @return {Object}
     * @return {string} return.module The module to select records from.
     * @return {Object} return.parent The parent context of the selection list
     *                                context to pass to the drawer.
     * @return {Data.Bean} return.recParentModel The current record to link to.
     * @return {string} return.recLink The relationship link.
     * @return {View.View} return.recView The view for the selection list.
     * @return {Backbone.Model} return.filterOptions The filter options object.
     * */
    getDrawerOptions: function () {
        var parentModel = this.context.get('parentModel');
        var linkModule = this.context.get('module');
        var link = this.context.get('link');

        var filterOptions = new app.utils.FilterOptions().config(this.def);
        filterOptions.setInitialFilter(this.def.initial_filter || '$relate');
        filterOptions.populateRelate(parentModel);

        return {
            layout: 'multi-selection-list-link',
            context: {
                module: linkModule,
                recParentModel: parentModel,
                recLink: link,
                recContext: this.context,
                recView: this.view,
                independentMassCollection: true,
                filterOptions: filterOptions.format(),
                copyLinkRecords: true,
            }
        };
    },
})
