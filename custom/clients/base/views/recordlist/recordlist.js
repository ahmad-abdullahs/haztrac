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
 * @class View.Views.Base.RecordlistView
 * @alias SUGAR.App.view.views.BaseRecordlistView
 * @extends View.Views.Base.FlexListView
 */
({
    extendsFrom: 'RecordlistView',

    /**
     * @override
     * @param {Object} options
     */
    initialize: function (options) {
        this._super("initialize", [options]);
    },

    /**
     * Toggle the selected model's fields when edit is clicked.
     *
     * @param {Backbone.Model} model Selected row's model.
     */
    editClicked: function (model, field) {
        // If a field is locked, we don't allow inline editing. Instead show an alert that links
        // to the record view or editview to make changes there.
        if (!_.isEmpty(model.get('locked_fields'))) {
            this._showLockedFieldWarning(model);
            return;
        }
        if (field.def.full_form) {
            var parentModel = this.context.parent.get('model');
            var link = this.context.get('link');

            // `app.bwc.createRelatedRecord` navigates to the BWC EditView if an
            // id is passed to it.
            app.bwc.createRelatedRecord(this.module, parentModel, link, model.id);
        } else {
            if (model.get('is_bundle_product_c') == 'parent') {
                this.__toggleRow(model.id, true);
            } else {
                this.toggleRow(model.id, true);
            }
            //check to see if horizontal scrolling needs to be enabled
            this.resize();
        }
        if (!_.isEqual(model.attributes, model._syncedAttributes)) {
            model.setSyncedAttributes(model.attributes);
        }
    },

    /**
     * Toggle editable selected row's model fields.
     *
     * @param {String} modelId Model Id.
     * @param {Boolean} isEdit True for edit mode, otherwise toggle back to list mode.
     */
    toggleRow: function (modelId, isEdit) {
        if (isEdit) {
            this.toggledModels[modelId] = this.collection.get(modelId);
        } else {
            delete this.toggledModels[modelId];
        }
        this.$('tr[name=' + this.module + '_' + modelId + ']').toggleClass('tr-inline-edit', isEdit);
        this.toggleFields(this.rowFields[modelId], isEdit);
    },

    // If this is the parent row don't make it ediatbale, keep that in non-editable form to show as a header.
    __toggleRow: function (modelId, isEdit) {
        if (isEdit) {
            this.toggledModels[modelId] = this.collection.get(modelId);
        } else {
            delete this.toggledModels[modelId];
        }
        this.toggleFields(this.rowFields[modelId], isEdit);
    },
})
