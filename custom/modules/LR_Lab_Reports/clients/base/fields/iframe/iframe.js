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

    initialize: function (options) {
        this.showButton = false;
        this._super('initialize', [options]);
        // This is added to render the iframe when document is signed on the listview 
        app.events.on('reloadDashlet', this._render, this);
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
})
