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
 * @class View.Fields.Base.EditablelistbuttonField
 * @alias SUGAR.App.view.fields.BaseEditablelistbuttonField
 * @extends View.Fields.Base.ButtonField
 */
({
    extendsFrom: 'EditablelistbuttonField',
    events: {
        'click [name=inline-save]': 'saveClicked',
    },
    initialize: function (options) {
        this._super("initialize", [options]);

        // Not really sure about this piece of code how it fixes the issue.
        // If we remove this code and click the refresh list button on the subpanel, it fetch the
        // Revenue line item subpanel and does not assign its appropriate model with the save button.
        // And when user hit the mass save button it produces the null model issue.
        // This code has fixed the issue but it stops loading the subpanel on refresh list button.
        // Need to figure this out in future, how this piece of code is stoping it to fetch the subpanel on 
        // refresh list button click.
        options.context.set('modelId', this.model.get('id'));

        // Listen the Cancel/Save event call on the parent record view and Cancel/Save all the subpanel 
        // records in edit mode.
        this.context.parent.on('save:full:subpanel:cstm', this.saveModel, this);
    },
    saveModel: function () {
        this._super("saveModel");
    },
})