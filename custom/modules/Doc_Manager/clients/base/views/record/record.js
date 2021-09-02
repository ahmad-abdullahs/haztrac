({
    extendsFrom: 'RecordView',

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
