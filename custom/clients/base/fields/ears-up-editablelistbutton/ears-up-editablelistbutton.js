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
        'click [name=inline-cancel]': 'cancelClicked'
    },
    initialize: function (options) {
        this._super("initialize", [options]);

        // Listen the cancel event call on the parent record view and cancel all the subpanel records edit mode.
        this.context.parent.on('cancel:full:subpanel:cstm', this.cancelClicked, this);
    },
    cancelClicked: function (evt) {
        this.cancelEdit();
    }
})