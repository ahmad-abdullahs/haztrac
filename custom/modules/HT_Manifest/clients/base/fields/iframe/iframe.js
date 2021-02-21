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
    showButton: false,
    document_id: '',
    elementId: '',

    events: {
        'click .signFile': 'signFile',
        'click .copyLinkToShare': 'copyLinkToShare',
        'click .lockAnnotation': 'lockAnnotation',
    },

    initialize: function (options) {
        this.showButton = false;
        this._super('initialize', [options]);
        // This is added to render the iframe when document is signed on the listview 
        app.events.on('reloadDashlet', this._render, this);
        app.events.on('lockAnnotationOnDrawerClose', this.lockAnnotationOnDrawerClose, this);
    },

    format: function (value) {
        if (this.model.attributes.popOutFullViewLink) {
            this.showButton = true;
        }
        if (this.context) {
            var model = this.context.get('model');
            // Only add these values to hbs if its not the record view, because 
            // if we add these attributes in the record view then in the signDoc/annotationeer/viewer.html
            // it will start pointing wrong element at parent.document.getElementById
            if (this.view.name != 'record') {
                this.document_id = model.get('document_id');
                this.elementId = 'signDocframeRecordPreview';
            }
        }
        return this._super('format', [value]);
    },

    /**
     * Listener function for signing clicked record.
     * @param {Object} e (current event)
     */
    signFile: function (e) {
        var self = this;
        var beanID = this.model.attributes.document_id;
        var flag = (this.model.attributes.is_locked) ? 1 : 0;

        app.drawer.open({
            layout: 'sign-doc',
            context: {
                url: 'signDoc/annotationeer/viewer.html?file=../../pdfs/' + beanID + '.pdf',
                document_id: beanID,
                is_locked: flag,
            }
        }, _.bind(function (context, model) {
            // comes here when its is closed
        }, self));
    },

    /**
     * Listener function for copying link to share with someone for external use.
     * @param {Object} e (current event)
     */
    copyLinkToShare: function (e) {
        var beanID = this.model.attributes.document_id;
        var flag = (this.model.attributes.is_locked) ? 1 : 0;
        var today = moment();
        var dateOfExpiry = today.add(1, 'day').utc().format();

        var url = app.config.signDocURL.url + 'annotationeer/viewer.html?file=../../pdfs/' + beanID + '.pdf' +
                '&token=' + window.btoa('&sugar_user_id=' + app.user.get('id') + '&full_name=' + app.user.get('full_name') +
                        '&document_id=' + beanID + '&hostUrl=' + app.config.signDocURL.url + '&is_locked=' + flag +
                        '&dateOfExpiry=' + dateOfExpiry);

        $('#copyLinkToShareInput').val(url);
        var copyText = document.getElementById("copyLinkToShareInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");

        // When user click the copy link button it should lock the document. 
        e.keptLock = true;
        this.lockAnnotation(e);
    },

    /**
     * Listener function for locking the document to edit.
     * @param {Object} e (current event)
     */
    lockAnnotation: function (e) {
        var beanID = this.model.attributes.document_id;
        var flag = (!this.model.attributes.is_locked) ? 1 : 0;
        if (beanID) {
            // Send and api call to lock/unlock the document
            var url = 'HT_Manifest/' + beanID + '/lockOrUnlockDoc';

            if (_.has(e, "keptLock")) {
                flag = flag || ((e.keptLock) ? 1 : 0);
            }

            // end lock/unlock call
            this.makeLockCall(url, flag);
        }
    },

    makeLockCall: function (url, flag) {
        var self = this;
        app.api.call('create', app.api.buildURL(url), {'flag': flag}, {
            success: _.bind(function (result) {
                // Fetch the respective model and render the field so that it should update the icon 
                if (!_.isNull(self.model) && !_.isUndefined(self.model)) {
                    self.model.fetch({
                        'success': _.bind(function (model) {
                            self.render();
                        }, this)
                    }, this);
                }
            }),
            error: _.bind(function (err) {
                console.log(err);
            }, this),
        });
    },

    /*
     * Automatically lock the document when drawer is closed
     */
    lockAnnotationOnDrawerClose: function (param) {
        var url = 'HT_Manifest/' + param.document_id + '/lockOrUnlockDoc';
        var flag = 1;
        if (!_.isUndefined(param.document_id) && !_.isEmpty(param.document_id)) {
            this.makeLockCall(url, flag);
        }
    },
})
