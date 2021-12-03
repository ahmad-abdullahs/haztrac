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
 * @class View.Fields.Base.Emails.Htmleditable_tinymceField
 * @alias SUGAR.App.view.fields.BaseEmailsHtmleditable_tinymceField
 * @extends View.Fields.Base.Htmleditable_tinymceField
 */
({
    extendsFrom: 'EmailsHtmleditable_tinymceField',

//    bindDataChange: function () {
//        this._super('bindDataChange');
//
//        var self = this;
//
//        if (this.model) {
//            this.model.on('change:outbound_email_id', function (model, value) {
//                console.log("bindDataChange : ", value);
//                // Fetch the signature 
//                // Set it to current_signature 
//                // Then insert it
//            }, this);
//        }
//    },
    
    /*
var fromList = this.context.get('cache:Emails:outbound_email_id:items');
var ids = Object.keys(fromList);

if(!_.isEmpty(ids)){
    var fromEmailId = ids[0];
    console.log('fromEmailId', fromEmailId, fromList[fromEmailId]);
    var outboundEmailBean = App.data.createBean('OutboundEmail', {id: fromEmailId});
    outboundEmailBean.fetch();
//     outboundEmailBean.fetch({fields: ['id','user_signature_id']});
}
*/

    /**
     * Inserts the template into the editor.
     *
     * The template's subject does not overwrite the existing subject if:
     *
     * 1. The email is a forward or reply.
     * 2. The template does not have a subject.
     *
     * @private
     * @fires email_attachments:template on the view with the selected template
     * as a parameter. {@link View.Fields.Base.Emails.EmailAttachmentsField}
     * adds the template's attachments to the email.
     * @param {Data.Bean} template
     */
    _applyTemplate: function (template) {
        var body_html = template.get('body_html');
        body_html = body_html.replace('[$names]', this.context.get('names'));
        body_html = body_html.replace('[$document_links]', this.context.get('document_links'));
        template.set('body_html', body_html);

        this._super('_applyTemplate', [template]);
    },

})
