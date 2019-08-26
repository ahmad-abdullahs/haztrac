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
 * @class View.Views.Base.FlexListView
 * @alias SUGAR.App.view.views.BaseFlexListView
 * @extends View.Views.Base.ListView
 */
({
    extendsFrom: 'FlexListView',
    className: 'flex-list-view',
    // Model being previewed (if any)
    _previewed: null,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },
})
