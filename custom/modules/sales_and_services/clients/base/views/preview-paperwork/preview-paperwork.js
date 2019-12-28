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

    plugins: ['Stage2CssLoader'],
    css: ['hint-help'],
    fileURL: '',
    isNotReady: true,
    isRenderedBefore: false,
    initialize: function (options) {
        this._super('initialize', [options]);
        var href = window.location.href;
        href = href.split("#");
        this.fileURL = href[0] + 'pdfs/';
        this.fileURL = this.fileURL + this.model.get('id') + '.pdf';
        this.isNotReady = true;
        this.isRenderedBefore = false;
        this.isPdfReady();
    },
    isPdfReady: function () {
        var self = this;
        if (self.isNotReady == true) {
            var request = new XMLHttpRequest();
            request.open('GET', self.fileURL, true);
            request.onreadystatechange = function () {
                if (request.readyState === 4) {
                    if (request.status === 404) {
                        self.isNotReady = true;
                        window.setTimeout(_.bind(self.isPdfReady, self), 1000);
                    }
                } else if (request.status === 200) {
                    self.isNotReady = false;
                    if (!this.isRenderedBefore) {
                        self.render();
                        this.isRenderedBefore = true;
                    }
                }
            };
            try {
                request.send();
            } catch (e) {
            }
        }
    },
    render: function () {
        this._super('render');
    },
    _renderHtml: function () {
        this._super('_renderHtml');
        this.$el.attr('style', 'height:100% !important');
        this.$el.parent().attr('style', 'height:85% !important');
    },
})
