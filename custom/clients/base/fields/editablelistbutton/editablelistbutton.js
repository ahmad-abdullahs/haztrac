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
    initialize: function (options) {
        this._super("initialize", [options]);
    },

    cancelEdit: function () {
        if (this.isDisabled()) {
            this.setDisabled(false);
        }
        this.changed = false;

        // ++ Null condition is checked because of the Revenue Line Items subpanel
        // under sales and service record view.
        // Steps to reproduce: 
        // 1- Hit the refresh list button.
        // 2- Hit the record Edit button (All records in the Revenue Line Items subpanel will be in editable mode).
        // 3- Hit the cancel button. (All records were not reverting back to list mode, because the code breaks at model.
        // Model was null in that case that's why isNull check is added below at 3 different places)
        if (!_.isNull(this.model))
            this.model.revertAttributes();

        this.view.clearValidationErrors();

        if (!_.isNull(this.model))
            this.view.toggleRow(this.model.id, false);

        // trigger a cancel event across the parent context so listening components
        // know the changes made in this row are being reverted
        if (!_.isNull(this.context))
            if (this.context.parent) {
                this.context.parent.trigger('editablelist:cancel', this.model);
            }
    },
})
