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

        // Greyed out the rows on the Sales and Service and Manifest List View which are completed
        // This will color the fields when they render on the list view
        this.collection.on('data:sync:complete', function () {
            this.highlightCompletedRecord();
        }, this);
        // This will color the rows when the column is added or removed from the list view.
        // If we dont add this code it will not color the rows when a new column is added or removed from the list.
        this.listenTo(this, 'render', function () {
            this.highlightCompletedRecord();
        }, this);
    },

    highlightCompletedRecord: function () {
        if (this.module == 'sales_and_services' || this.module == 'HT_Manifest') {
            _.each(this.fields, function (field) {
                if (field.name == 'status_c') {
                    if ((field.model.get(field.name) == 'Complete') || (field.model.get(field.name) == 'Completed')) {
                        field.$el.parents('tr').css("background-color", "#f6f6f6 !important");
                        // See the data-type must exist and should not be empty, this is added to avoid the 
                        // row checkbox, favorite star, eye ball and dropdown not the be transparent
                        field.$el.parents('tr').children('td[data-type!=""][data-type]').css("background-color", "transparent");
                    } else {
                        field.$el.parents('tr').css("background-color", "");
                        field.$el.parents('tr').children('td[data-type!=""][data-type]').css("background-color", "");
                    }
                }
            });
        }
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

    deleteModel: function () {
        var self = this,
                model = this._modelToDelete;

        model.destroy({
            //Show alerts for this request
            showAlerts: {
                'process': true,
                'success': {
                    messages: self.getDeleteMessages(self._modelToDelete).success
                }
            },
            success: function () {
                var redirect = self._targetUrl !== self._currentUrl;
                self._modelToDelete = null;
                self.collection.remove(model, {silent: redirect});
                if (redirect) {
                    self.unbindBeforeRouteDelete();
                    //Replace the url hash back to the current staying page
                    app.router.navigate(self._targetUrl, {trigger: true});
                    return;
                }
                app.events.trigger("preview:close");
                if (!self.disposed) {
                    self.render();
                }

                self.layout.trigger("list:record:deleted", model);

                // ++ This is added to reload the RLI subpanel, so that the child RLIs disappear from the panel  
                if (!_.isUndefined(self.context) && !_.isNull(self.context) && self.context.parent) {
                    if (self.module == 'RevenueLineItems' &&
                            self.context.parent.get('module') == 'sales_and_services' &&
                            model.attributes.is_bundle_product_c == 'parent') {
                        self.collection.fetch();
                    }
                }
            }
        });
    },
})
