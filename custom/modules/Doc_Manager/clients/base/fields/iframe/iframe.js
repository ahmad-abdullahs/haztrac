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
 * @class View.Fields.Base.IframeField
 * @alias SUGAR.App.view.fields.BaseIframeField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'IframeField',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    render: function () {
        this._super("render");

        var self = this;
        var notifyCounter = 1;

        var notifyOnlyOfficeToSetModule = setInterval(function () {
            if (self.$) {
                var ele = self.$('#onlyOfficeFrame');
                if (ele.length) {
                    var iframe = ele[0];
                    if (iframe) {
                        var doc = iframe.contentDocument || iframe.contentWindow.document;
                        var form = doc.getElementById('form1');
                        if (form) {
                            var internalIframe = form.getElementsByTagName('IFRAME');
                            if (internalIframe[0]) {
                                internalIframe[0].contentWindow.postMessage({
                                    base_module: self.model.get('base_module'),
                                    initiator: self.view.name,
                                }, "*");
                                if (notifyCounter > 9) {
                                    clearInterval(notifyOnlyOfficeToSetModule);
                                }
                                notifyCounter++;
                            }
                        }
                    }
                }
            }
        }, 1000);
    },

    _render: function () {
        this._super("_render");
    },

    format: function (value) {
        // Reason why sugar=true flag is added
        // It avoids generating files with name xyz.docx,xyz(1).docx,xyz(2).docx etc.
        if (this.model && !value && this.model.isNew()) {
            var guid = app.utils.generateUUID();
            var iframeURL = app.config.docManagerURL.url + "doceditor.php?sugar=true&fileExt=docx&userFileName=" + guid + ".docx";

            this.model.set('potential_id', guid, {silent: true});
            this.model.set('doc_template', iframeURL, {silent: true});
            this.value = iframeURL;
        } else if (!this.model.isNew()) {
            if (this.action == "edit") {
                var iframeURL = app.config.docManagerURL.url + "doceditor.php?fileID=" + this.model.get("id") + ".docx";
            } else {
                var iframeURL = app.config.docManagerURL.url + "doceditor.php?fileID=" + this.model.get("id") + ".docx&action=view";
            }

            this.value = iframeURL;
            this.model.set('doc_template', iframeURL, {silent: true});
        }

        return this.value;
    },
})
