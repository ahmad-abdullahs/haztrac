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
 * @class View.Views.Base.ListBottomView
 * @alias SUGAR.App.view.views.BaseListBottomView
 * @extends View.View
 */
({
    extendsFrom: 'ListBottomView',
    showRange: false,

    events: {
        'click [data-action="show-more"]': 'showMoreRecords',
        'click [data-action="show-more-50"]': 'showMoreRecords50',
        'click [data-action="show-more-100"]': 'showMoreRecords100',
        'click [data-action="show-more-200"]': 'showMoreRecords200',
//        'click [data-action="show-more-all"]': 'showMoreRecordsAll',
    },

    initialize: function (options) {
        if (options) {
            if (options.layout.type == 'list') {
                this.showRange = true;
            }
        }
        this._super('initialize', [options]);
    },

    /**
     * Retrieving the next page records by pagination plugin.
     * This function is added to achieve limit of 50, 100, 200, all
     * Please see the {@link app.plugins.Pagination#getNextPagination}
     * for detail.
     */

    _showMoreRecords: function (queryLimit) {
        if (!this.paginationComponent) {
            return;
        }

        var options = {};
        options.success = _.bind(function () {
            this.layout.trigger('list:paginate:success');
            // FIXME: This should trigger on `this.collection` instead of
            // `this.context`. Will be fixed as part of SC-2605.
            this.context.trigger('paginate');
            this.render();
        }, this);

        options.limit = queryLimit;
        this.paginationComponent.getNextPagination(options);
        this.render();
    },

    showMoreRecords50: function () {
        this._showMoreRecords(50);
    },

    showMoreRecords100: function () {
        this._showMoreRecords(100);
    },

    showMoreRecords200: function () {
        this._showMoreRecords(200);
    },

//    showMoreRecordsAll: function () {
//        this._showMoreRecords(-1);
//    },
})
