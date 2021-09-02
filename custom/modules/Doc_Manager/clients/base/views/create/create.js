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
 * @class View.Views.Base.Calls.CreateView
 * @alias SUGAR.App.view.views.CallsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    bindDataChange: function () {
        this.model.on('change:base_module', this.postMessageToOnlyOfficeFrame, this);
        this._super('bindDataChange');
    },

    postMessageToOnlyOfficeFrame: function (model, value) {
        var ele = this.$('#onlyOfficeFrame');
        if (ele.length) {
            var iframe = ele[0];
            if (iframe) {
                var doc = iframe.contentDocument || iframe.contentWindow.document;
                var form = doc.getElementById('form1');
                if (form) {
                    var internalIframe = form.getElementsByTagName('IFRAME');

                    if (internalIframe[0]) {
                        internalIframe[0].contentWindow.postMessage({
                            base_module: value,
                            initiator: 'change',
                        }, "*");
                    }
                }
            }
        }

    },
})
