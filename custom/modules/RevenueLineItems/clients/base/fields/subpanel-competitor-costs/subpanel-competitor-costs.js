/**
 * Controller File
 * Custom subpanel_field Type Field
 */
({
    extendsFrom: 'BaseField',

    /*
     * Events for subpanel buttons
     */
    events: {
        'click .trigger_preview': 'openPreview',
        'click .trigger_select': 'linkExistingRecord',
        'click .trigger_delete': 'deleteRecord',
        'click .trigger_create': 'createRecord',
        'click .trigger_edit': 'editRecord',
        'click .trigger_inline_edit': 'inlineEditRecord',
        'click .remove_inline_edit': 'removeInlineEditRecord',
        'click .trigger_inline_save': 'saveInlineRecord',
        'click .sortable': 'sortByColumn',
        'click .dropdown-toggle': 'toggleRowActionDropdown',
    },

    filteredCollection: null,
    columns: null,
    columnsMeta: null,
    rowViews: {},
    orderBy: {},
    mappingFieldsValues: {},
    relatedFields: null,
    subpanelModule: null,
    subpanelModel: null,
    fieldMapping: null,
    primary_field: null,
    primary_field_label: null,
    name_field: null,
    div_id: null,
    subpanelCreateView: 'subpanel-create',
    isSubpanelField: true,

    /**
     * calling parent initialize
     * @param {Function} initialize
     * @param {Object} options
     */
    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['ListControlPagination']);
        this._super('initialize', [options]);

        this.columns = this.def.columns;
        for (var i in this.columns) {
            this.columns[i]['sorting_class'] = "sorting";
        }

        this.relatedFields = this.def.relatedFields;
        this.subpanelModule = this.def.relatedModule;
        this.fieldMapping = this.def.fieldMapping;
        this.primary_field = this.def.primary_field;
        this.subpanelCreateView = this.def.subpanelCreateView || 'subpanel-create';
        this.name_field = this.def.name_field;
        this.filteredCollection = new Backbone.Collection();
        this.columnsMeta = this.getColumnsMeta();
        this.createWrapper = "action_wrapper" + this.def.linkField + this.sfId;
        this.createDiv = "createNewRecord" + this.def.linkField + this.sfId;
        this.div_id = this.subpanelModule + "_" + this.def.linkField + "_so";
        this.on('field:model_saved:fire', this.reRenderView, this);
        this.on('create:btn:enable', this.handleCreateButton, this);

        this.model.on('data:sync:complete', _.bind(this.getMappingValues, this));
    },

    render: function () {},

    handleCreateButton: function (disable) {
        if (disable) {
            this.$('.trigger_create').addClass('disabled');
        } else {
            this.$('.trigger_create').removeClass('disabled');
        }
    },

    updateCollection: function () {
        var self = this;
        var filteredCollection = app.data.createRelatedCollection(this.model, this.def.linkField);
        var data = this.view.subpanelData['competitor_cost_revenuelineitems'];

        if (_.isUndefined(data.records))
            return;

        _.each(data.records, function (obj) {
            var model = app.data.createBean(self.subpanelModule, obj);
            model.template = "detail";
            self.filteredCollection.add(model);
        });
    },

    _checkAccessToAction: function (action) {
        return true;
    },

    /**
     * Remove validation errors and marks
     */
    removeValidationErrors: function () {
        $('.error').removeClass('error');
        $('.error-tooltip').remove();
        $('[data-toggle="tab"] .icon-exclamation-sign').remove();
    },

    /**
     * Get each field meta from model vardefs
     */
    getColumnsMeta: function () {
        var meta = new Array;
        this.subpanelModel = app.data.createBean(this.subpanelModule);
        for (var index in this.columns) {
            var field = this.columns[index]['name'];
            var type = this.columns[index]['type'] || false;
            var span = this.columns[index]['span'] || 1;
            var options = this.columns[index]['options'] || false;
            var readonly = this.columns[index]['readonly'] || false;
            var link = this.columns[index]['link'] || false;
            if (this.primary_field && field == this.primary_field) {
                this.primary_field_label = app.lang.get(this.columns[index]['label'], this.subpanelModule);
            }
            var fmeta = this.subpanelModel.fields[field] || {};
            if (type) {
                fmeta['type'] = type;
            }
            if (span) {
                fmeta['span'] = span;
            }
            if (options) {
                fmeta['options'] = options;
            }
            if (readonly) {
                fmeta['readonly'] = readonly;
            }
            if (link) {
                fmeta['link'] = link;
            }
            meta.push(fmeta);
        }
        return meta;
    },

    /**
     * Hide/Show row drop down (Edit / Delete) according to positioning relative to parent div
     */
    toggleRowActionDropdown: function (e) {
        var div_id = this.div_id;
        var relativeY = ($(e.currentTarget).offset().top + $(e.currentTarget).height()) - $('#' + div_id).offset().top;
        var dropdown = $(e.currentTarget).next()[0];
        var display = $(dropdown).css('display');
        var dropDownHeight = $(dropdown).height();
        var bottomOfDiv = $('#' + div_id).position().top + $('#' + div_id).outerHeight(true);
        var calculated = bottomOfDiv - (dropDownHeight + relativeY);
        if (calculated < 25 && display == "none") {
            $(dropdown).addClass('dropdown_upside');
        } else {
            $(dropdown).removeClass('dropdown_upside');
        }
    },

    /**
     * Get mapped fields from metadata and retrieve their values
     */
    getMappingValues: function () {
        var fieldValues = {};
        for (var field in this.fieldMapping) {
            fieldValues[field] = this.model.get(this.fieldMapping[field]);
        }

        this.mappingFieldsValues = fieldValues;
    },

    /**
     * Refetch subpanel data and render view.
     */
    reRenderView: function () {
        this.showAll = false;
        this.filteredCollection = new Backbone.Collection();
        this.fetchRecords(true);
    },

    /**
     * Render subpanel view and its inner fields.
     */
    _render: function () {
        if (_.isNull(this.el)) {
            return;
        }

        if (_.isUndefined(!this.view.subpanelData['competitor_cost_revenuelineitems'].records)) {
            return;
        }
        this.updateCollection();
        this.prepareCollectionForView();
        this.removeValidationErrors();
        this._super('_render');
        this.renderSubpanelFields();
    },

    /**
     * Render subpanel fields by getting their sfuuid.
     */
    renderSubpanelFields: function () {
        var self = this;
        $('.rowcell>span[sfuuid]').each(function () {
            var $this = $(this),
                    sfId = $this.attr('sfuuid');
            var field = self.view.fields[sfId];
            if (field) {
                field.setElement($this || self.$("span[sfuuid='" + sfId + "']"));
                field.listControlField = true;
                try {
                    field.render();
                    self.view.noEditFields.push(field.name);
                } catch (e) {
                }
            }
        });
    },

    /**
     * Fetch related records for subpanel data.
     */
    fetchRecords: function (recalculate) {
        var self = this;
        var data = {};
        data['records'] = [];
        var modelId = this.model.get('id');
        if (_.isEmpty(modelId)) {
            self.view.subpanelData['competitor_cost_revenuelineitems'] = data;
            self._render();
            return;
        }

        var collection = app.data.createRelatedCollection(this.model, this.def.linkField);
        if (!_.isUndefined(this.def.filter) && !_.isEmpty(this.def.filter)) {
            collection.filterDef = this.def.filter;
        }

        collection.fetch({
            relate: true,
            limit: -1,
            success: function (coll) {
                //Adding new models to collection
                var records = [];
                for (var i = 0; i < collection.models.length; i++) {
                    collection.models[i].template = "detail";
                    self.filteredCollection.add(collection.models[i]);
                    data['records'].push(collection.models[i].attributes);
                }
                // 
                self.view.subpanelData['competitor_cost_revenuelineitems'] = data;
                self._render();
            }
        });
    },

    /**
     * Preview button listener to show preview of clicked record.
     */
    openPreview: function (e) {
        var row = $(e.currentTarget).closest('tr');
        var beanName = $(row).attr('module');
        var beanID = $(row).attr('data-id');

        // Show alert 
        app.alert.show('fetching_related_record', {
            level: 'process',
            title: app.lang.getAppString('LBL_LOADING')
        });

        // var previewCollection = new Backbone.Collection();
        var bean = app.data.createBean(beanName, {id: beanID});
        bean.byPassHint = true;

        app.events.trigger("preview:render", bean, this.context.get("collection"), false, beanID, false);
        app.events.trigger('preview:pagination:hide');

        // Dismiss alert
        app.alert.dismiss('fetching_related_record');
    },

    /**
     * Listener function for error validation. To avoid all cells from being colored red.
     */
    handleValidationError: function (errors) {
        this._super('handleValidationError', [errors]);
        this.$el.closest('.record-cell').removeClass('error');
    },

    /**
     * Listener function for deleting clicked record.
     */
    deleteRecord: function (e) {
        var self = this;
        var row = $(e.currentTarget).closest('tr');
        var beanName = $(row).attr('module');
        var beanID = $(row).attr('data-id');
        var bean = app.data.createBean(beanName, {id: beanID});
        app.alert.show('delete_confirmation', {
            level: 'confirmation',
            messages: app.lang.get('LBL_DELETE_CONFIRM_CC', self.module),
            onConfirm: _.bind(function () {
                app.alert.show('deleting_record', {level: 'process', title: 'Deleting'});
                var success_message = app.lang.get('LBL_DELETE_SUCCESS_CC', self.module);
                var error_message = app.lang.get('LBL_DELETE_ERROR_CC', self.module);
                bean.destroy({
                    success: function (model, response) {
                        app.alert.dismiss('deleting_record', {level: 'process', title: 'Deleting'});
                        app.alert.show('deleted', {level: 'success', messages: success_message, autoClose: true, autoCloseDelay: 8000});
                        self.filteredCollection = new Backbone.Collection();
                        self.fetchRecords(true);
                    },
                    error: function (model, response, options) {
                        app.alert.dismiss('deleting_record', {level: 'process', title: 'Deleting'});
                        app.alert.show('not_deleted', {level: 'error', messages: error_message, autoClose: true, autoCloseDelay: 8000});
                    }
                });
            }, this)
        });
    },

    /**
     * Listener function to full-edit the clicked record.
     */
    editRecord: function (e) {
        var self = this;
        this.handleCreateButton(false);
        var row = $(e.currentTarget).closest('tr');
        var beanName = $(row).attr('module');
        var beanID = $(row).attr('data-id');
        var model = self.filteredCollection.get(beanID);
        $('#' + this.createWrapper).append("<div id='" + this.createDiv + "'></p>");
        var ele = $('#' + this.createDiv);
        self.context.edit = true;
        var newModel = app.data.createBean(beanName, {id: beanID});
        newModel.fetch({
            success: function () {
                newModel.parent = self;
                var vieww = app.view.createView({
                    module: beanName,
                    name: self.subpanelCreateView,
                    model: newModel,
                    edit: true,
                });
                vieww.setElement(ele);
                vieww.render();
            }
        });
    },

    /**
     * Listener function to inline-edit the clicked record.
     */
    inlineEditRecord: function (e) {
        var self = this;
        var row = $(e.currentTarget).closest('tr');
        var beanName = $(row).attr('module');
        var beanID = $(row).attr('data-id');
        var model = self.filteredCollection.get(beanID);
        model.template = "edit";
        self._render();
    },

    /**
     * Listener function when cancel is clicked for inline edited record.
     */
    removeInlineEditRecord: function (e) {
        var self = this;
        var row = $(e.currentTarget).closest('tr');
        var beanName = $(row).attr('module');
        var beanID = $(row).attr('data-id');
        var model = self.filteredCollection.get(beanID);
        model.revertAttributes();
        model.template = "detail";
        self._render();
    },

    /**
     * Listener function when save is clicked for inline edited record.
     */
    saveInlineRecord: function (e) {
        var fields = {};
        var self = this;
        _.each(this.columnsMeta, function (field, i) {
            fields[field.name] = field;
        });
        var row = $(e.currentTarget).closest('tr');
        var beanName = $(row).attr('module');
        var beanID = $(row).attr('data-id');
        var modelToSave = self.filteredCollection.get(beanID);
        modelToSave.doValidate(fields, function (isValid) {
            if (!isValid) {
                return false;
            }
            $(e.currentTarget).hide();
            self.saveRecord(modelToSave);
        });
    },

    /**
     * Linked with above function
     */
    saveRecord: function (modelToSave) {
        app.alert.show('saving_record', {level: 'process', title: 'Saving'});
        var self = this;
        var nameValue = modelToSave.get(this.name_field);
        modelToSave.set('name', nameValue);
        if (!_.isUndefined(this.def.filter) && !_.isEmpty(this.def.filter)) {
            modelToSave.set(_.keys(this.def.filter).toString(), _.values(this.def.filter).toString());
        }
        modelToSave.save({}, {
            success: function (model, response) {
                app.alert.dismiss('saving_record', {level: 'process', title: 'Saving'});
                app.alert.show('saved', {level: 'success', messages: "Record Saved", autoClose: true, autoCloseDelay: 8000});
                self.reRenderView();
            },
            error: function (model, response, options) {
                app.alert.dismiss('saving_record', {level: 'process', title: 'Saving'});
                app.alert.show('not_saved', {level: 'error', messages: "Record not saved", autoClose: true, autoCloseDelay: 8000});
                self.reRenderView();
            }
        });
    },

    /**
     * Listener function when save is clicked for fully edited record. Event is triggered from Related module's 
     * "Subpanel-create" view
     */
    createRecord: function (e) {
        if (!this.$('.trigger_create').hasClass("disabled")) {
            var row = $(e.currentTarget).closest('tr');
            this.context.edit = false;
            var beanName = $(row).attr('module');
            var model = app.data.createBean(beanName, this.mappingFieldsValues);
            var current_user = app.user.id;
            model.set('assigned_user_id', current_user);
            $('#' + this.createWrapper).append("<div id='" + this.createDiv + "'></p>");
            var ele = $('#' + this.createDiv);
            model.parent = this;
            var vieww = app.view.createView({
                module: beanName,
                name: this.subpanelCreateView,
                model: model
            });
            vieww.setElement(ele);
            vieww.render();
            this.handleCreateButton(true);
        }
    },

    /**
     * Set/unset ascending or descending class to specific column
     */
    setColumnClass: function (field, direction) {
        for (var i in this.columns) {
            if (this.columns[i]['name'] == field) {
                this.columns[i]['sorting_class'] = "sorting_" + direction;
            } else {
                this.columns[i]['sorting_class'] = "sorting";
            }
        }
    },

    /**
     * Sort subpanel data when a column is clicked
     */
    sortByColumn: function (e) {
        var self = this;
        var eventTarget = $(e.currentTarget);
        var orderBy = eventTarget.data('orderby');
        if (!orderBy) {
            orderBy = eventTarget.data('fieldname');
        }
        if (orderBy === self.orderBy.field) {
            self.orderBy.direction = self.orderBy.direction === 'desc' ? 'asc' : 'desc';
        } else {
            self.orderBy.field = orderBy;
            self.orderBy.direction = 'desc';
        }
        var query_string = self.orderBy.field + ":" + self.orderBy.direction;
        var url = app.api.buildURL(this.module, this.def.linkField, {id: this.model.get('id'), link: true}, {limit: '-1', order_by: query_string});
        app.api.call('read', url, {}, {
            success: _.bind(function (response) {
                self.filteredCollection = new Backbone.Collection();
                self.setColumnClass(self.orderBy.field, self.orderBy.direction);
                for (var i in response.records) {
                    var model = app.data.createBean(response.records[i]._module, response.records[i]);
                    model.template = "detail";
                    self.filteredCollection.add(model);
                }
                self._render();
            }, this)
        });
    },
})