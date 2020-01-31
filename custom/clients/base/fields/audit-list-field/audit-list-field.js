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
    },

    filteredCollection: null,
    columns: null,
    columnsMeta: null,
    orderBy: {},
    subpanelModule: null,
    filters: [],
    allowedFieldList: [],

    /**
     * calling parent initialize
     * @param {Function} initialize
     * @param {Object} options
     */
    initialize: function (options) {
        this._super('initialize', [options]);

        this.baseModule = app.controller.context.get('module');
        this.baseRecord = app.controller.context.get('modelId');
        this._initCollection();

        this.columns = this.def.columns;
        this.subpanelModule = this.def.relatedModule;
        this.allowedFieldList = this.def.allowedFieldList;
        this.filteredCollection = new Backbone.Collection();
        this.columnsMeta = this.getColumnsMeta();
        this.fetchRecords();

        this.model.on('data:sync:complete', function () {
            this.reRenderView();
        }, this);
    },

    _initCollection: function () {
        var self = this;
        var AuditCollection = app.BeanCollection.extend({
            module: 'audit',
            baseModule: this.baseModule,
            baseRecordId: this.baseRecord,

            // FIXME PX-46: remove this function
            buildURL: function (params) {
                params = params || {};

                var parts = [],
                        url;
                parts.push(app.api.serverUrl);
                parts.push(this.baseModule);
                parts.push(this.baseRecordId);
                parts.push(this.module);
                url = parts.join('/');
                params = $.param(params);
                if (params.length > 0) {
                    url += '?' + params;
                }
                return url;
            },
            sync: function (method, model, options) {
                var url = this.buildURL(options.params);
                var callbacks = app.data.getSyncCallbacks(method, model, options);
                callbacks.success = function (data, request) {
                    self._applyModelDataOnRecords(app.controller.context.get('model'), data.records);

                    for (var i in data.records) {
                        if (_.contains(self.allowedFieldList, data.records[i].field_name)) {
                            var model = app.data.createBean(this.subpanelModule, data.records[i]);
                            model.template = "list";

                            if (_.contains(['discount_price', 'list_price', 'cost_price'], model.get('field_name')) && model.get('data_type') == 'currency') {
                                model.set('before', app.currency.formatAmountLocale(model.get('before') || 0, '-99'));
                                model.set('after', app.currency.formatAmountLocale(model.get('after') || 0, '-99'));
                            }

                            self.filteredCollection.add(model);                
                        }
                    }

                    self._render();

                };
                app.api.call(method, url, options.attributes, callbacks);
            }
        });
        this.collection = new AuditCollection();
    },

    /**
     * Override to only show list template. 
     **/
    _loadTemplate: function () {
        this._super('_loadTemplate');
        var template = app.template.getField(this.type, 'list', this.model.module);
        this.template = template || this.template;
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
        var fieldsDef = app.metadata.getModule(this.subpanelModule, "fields");
        _.each(this.columns, function (fieldViewMeta) {
            var fieldVardef = App.utils.deepCopy(fieldsDef[fieldViewMeta.name] || {});
            var fieldMeta = _.extend(fieldVardef, fieldViewMeta);
            meta.push(fieldMeta);
        }, this);
        return meta;
    },

    /**
     * Refetch subpanel data and render view.
     */
    reRenderView: function () {
        this.filteredCollection = new Backbone.Collection();
        this.fetchRecords();
    },

    /**
     * Render subpanel view and its inner fields.
     */
    _render: function () {
        if (_.isNull(this.el))
            return;
        this.removeValidationErrors();
        this._super('_render');
        this.renderSubpanelFields();
        this.showToAdminOnly();
        $('.tooltip').remove();
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
                } catch (e) {
                }
            }
        });
    },

    /**
     * Fetch related records for subpanel data.
     */
    fetchRecords: function () {
        if (this.collection.dataFetched) {
            return;
        }
        this.collection.fetch();
    },

    /**
     * Listener function for error validation. To avoid all cells from being colored red.
     */
    handleValidationError: function (errors) {
        this._super('handleValidationError', [errors]);
        this.$el.closest('.record-cell').removeClass('error');
    },

    /**
     * Specific Subpanel Logics start from here
     */
    showToAdminOnly: function () {
        // if (!this.filteredCollection.models.length > 0)
        if (app.user.get('type') != 'admin') {
            $('div [data-type="audit-list-field"]').hide();
        } else {
            $('div [data-type="audit-list-field"]').show();
        }
    },

    _applyModelDataOnRecords: function (model, records) {
        var erasedFields = model.get('_erased_fields');
        _.each(erasedFields, function (erasedField) {
            // Apply erased fields only for records that are marked
            var erasedFieldName = erasedField.field_name || erasedField;

            var properties;
            var recordsRequiringErasedFields;
            if (erasedField.field_name) {
                // email and other non-scalar erased fields
                // check both the before and after fields
                // of each record to see if it matches up with
                // an erased email's ID, and if so mark that field as erased
                var fieldsToCheck = ['before', 'after'];
                _.each(fieldsToCheck, function (fieldToCheck) {
                    properties = {field_name: erasedFieldName};
                    properties[fieldToCheck] = erasedField.id;
                    recordsRequiringErasedFields = _.where(records, properties);
                    _.each(recordsRequiringErasedFields, function (record) {
                        record._erased_fields = record._erased_fields || [];
                        record._erased_fields.push(fieldToCheck);
                    });
                });
            } else {
                properties = {field_name: erasedFieldName};
                recordsRequiringErasedFields = _.where(records, properties);
                _.each(recordsRequiringErasedFields, function (record) {
                    record._erased_fields = ['before', 'after'];
                });
            }
        });
    },

    // remove all tooltips on dispose.this will remove all
    _dispose: function () {
        $('.tooltip').remove();
        this._super('_dispose');
    },

})