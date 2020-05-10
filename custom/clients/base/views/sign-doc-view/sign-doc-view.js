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
({
    extendsFrom: 'BaseView',
    url: '',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        this.url = this.options.context.get('url');
    },

    _renderHtml: function () {
        this._super('_renderHtml');
        this.$el.attr('style', 'height:100% !important');
    },

})
