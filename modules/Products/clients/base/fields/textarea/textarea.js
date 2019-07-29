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
 * @class View.Fields.Base.Products.TextareaField
 * @alias SUGAR.App.view.fields.BaseProductsTextareaField
 * @extends View.Fields.Base.BaseTextareaField
 */
({
    extendsFrom: 'BaseTextareaField',
    /**
     * Making the textarea editable for the Quotes Line items
     * @inheritdoc
     */
    setMode: function(name) {
        if (this.view.name === 'quote-data-group-list' && this.tplName === 'list') {
            app.view.Field.prototype.setMode.call(this, name);
        } else {
            this._super('setMode', [name]);
        }
    }
})
