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
 * @class View.Views.Base.RecordView
 * @alias SUGAR.App.view.views.BaseRecordView
 * @extends View.View
 */
({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
        // Add listener for custom button
        this.context.on('button:close_drawer_button:click', this.closeDrawer, this);
    },

    _buildGridsFromPanelsMetadata: function (panels) {
        this._super('_buildGridsFromPanelsMetadata', [panels]);

        // Only Add the Close button if this is initiated from the RevenueLineItems (open in drawer) or Maps View.
        var openInDrawer = this.context.get('openInDrawer') || false;
        if (!openInDrawer) {
            this.options.meta.buttons = _.reject(this.options.meta.buttons, function (btn) {
                return _.contains(["close_drawer_button"], btn.name);
            }, this);
        }
    },

    editClicked: function () {
        this.setButtonStates(this.STATE.EDIT);
        this.action = 'edit';
        this.toggleEdit(true);
        // Only set the route if its the real record view, not the record view opened in the
        // drawer, like we are opening the record view in drawer for RevenueLineItems or Maps.
        var openInDrawer = this.context.get('openInDrawer') || false;
        if (!openInDrawer) {
            this.setRoute('edit');
        }
    },

    cancelClicked: function () {
        this.setButtonStates(this.STATE.VIEW);
        this.action = 'detail';
        this.handleCancel();
        this.clearValidationErrors(this.editableFields);
        // Only set the route if its the real record view, not the record view opened in the
        // drawer, like we are opening the record view in drawer for RevenueLineItems or Maps.
        var openInDrawer = this.context.get('openInDrawer') || false;
        if (!openInDrawer) {
            this.setRoute();
        }
        this.unsetContextAction();
    },

    handleSave: function () {
        if (this.disposed) {
            return;
        }
        this._saveModel();
        this.$('.record-save-prompt').hide();

        if (!this.disposed) {
            this.setButtonStates(this.STATE.VIEW);
            this.action = 'detail';
            // Only set the route if its the real record view, not the record view opened in the
            // drawer, like we are opening the record view in drawer for RevenueLineItems or Maps.
            var openInDrawer = this.context.get('openInDrawer') || false;
            if (!openInDrawer) {
                this.setRoute();
            }
            this.unsetContextAction();
            this.toggleEdit(false);
            this.inlineEditMode = false;
        }
    },

    closeDrawer: function () {
        app.drawer.close();
    },
})
