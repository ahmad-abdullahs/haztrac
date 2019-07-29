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
 * @class View.Views.Base.Quotes.ConfigSummaryView
 * @alias SUGAR.App.view.views.BaseQuotesConfigSummaryView
 * @extends View.Views.Base.Quotes.ConfigPanelView
 */
({
    /**
     * @inheritdoc
     */
    extendsFrom: 'QuotesConfigPanelView',

    /**
     * @inheritdoc
     */
    events: {
        'click .restore-defaults-btn': 'onClickRestoreDefaultsBtn'
    },

    /**
     * The default list of field names for the Quotes summary columns
     */
    listDefaultFieldNames: [
        'deal_tot',
        'new_sub',
        'tax',
        'shipping',
        'total'
    ],

    /**
     * The Label names from each of the default fields
     */
    listDefaultFieldNameLabels: undefined,

    /**
     * The list header view
     * @type {View.Views.Base.Quotes.ConfigListHeaderColumnsView}
     */
    listHeaderView: undefined,

    /**
     * Contains an array of all the default fields to reset the list header
     */
    defaultFields: undefined,

    /**
     * Contains an array of all the current fields in the list header
     */
    listHeaderFields: undefined,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        var namesLen = this.listDefaultFieldNames.length;
        var quoteGrandTotalHeaderListMeta = app.metadata.getView('Quotes', 'quote-data-grand-totals-header');
        var field;
        var fieldLabels = [];
        var fieldLabel;
        var fieldLabelModule;
        var tmpField;

        this._super('initialize', [options]);

        this.quotesFieldMeta = app.metadata.getModule('Quotes', 'fields');

        this.defaultFields = [];

        // pluck all the fields arrays from panels and flatten into one array
        this.listHeaderFields = _.flatten(_.pluck(quoteGrandTotalHeaderListMeta.panels, 'fields'));

        _.each(this.listHeaderFields, function(field) {
            field.labelModule = this._getFieldLabelModule(field);
        }, this);

        // build the list header labels and defaultFields
        this.listDefaultFieldNameLabels = [];
        for (var i = 0; i < namesLen; i++) {
            // try to get view defs from the quote-data-group-list meta
            field = _.find(this.listHeaderFields, function(headerField) {
                return this.listDefaultFieldNames[i] === headerField.name;
            }, this);

            if (!field) {
                // if the field didn't exist in the group list meta, use the field vardef
                field = this.quotesFieldMeta[this.listDefaultFieldNames[i]];
            }

            // use either label (viewdefs) or vname (vardefs)
            if (field && (field.label || field.vname)) {
                fieldLabel = field.label || field.vname;

                // check Products strings first
                fieldLabel = app.lang.get(fieldLabel, 'Quotes');
                fieldLabelModule = 'Quotes';

                fieldLabels.push(fieldLabel);

                tmpField = {
                    name: field.name,
                    label: fieldLabel,
                    labelModule: fieldLabelModule,
                    widthClass: field.widthClass,
                    css_class: field.css_class || field.cssClass || ''
                };

                // push the fieldDefs to default fields
                this.defaultFields.push(tmpField);
            }
        }

        this.listDefaultFieldNameLabels = fieldLabels.join(', ');

        this.model.set(this.eventViewName, this.listHeaderFields);
    },

    /**
     * @inheritdoc
     */
    _getEventViewName: function() {
        return 'summary_columns';
    },

    /**
     * Returns the module to use for the label if no label module is given
     *
     * @param {Object} field
     * @return {string}
     * @private
     */
    _getFieldLabelModule: function(field) {
        return field.labelModule || 'Quotes';
    },

    /**
     * @inheritdoc
     */
    _getPanelFields: function() {
        var fields = [];
        _.each(this.context.get('quotesFields'), function(f, key) {
            if (f.type !== 'collection' && key.indexOf('_id') === -1) {
                fields.push(_.extend({
                    name: key
                }, f));
            }
        }, this);

        return fields;
    },

    /**
     * @inheritdoc
     */
    _getPanelFieldsModule: function() {
        return 'Quotes';
    },

    /**
     * @inheritdoc
     */
    onConfigPanelShow: function() {
        if (this.dependentFields) {
            this.context.trigger('config:fields:change', this.eventViewName, this.panelFields);
        }
    },

    /**
     * @inheritdoc
     */
    _onDependentFieldsChange: function(context, fieldDeps) {
        var pFieldDeps;
        var pRelatedFields;
        var pRelatedField;
        var pDependentField;
        var tmpRelatedFields;
        var relatedFieldsList = [];
        var tmpField;

        this._super('_onDependentFieldsChange', [context, fieldDeps]);

        pFieldDeps = this.dependentFields.Quotes;
        pRelatedFields = this.relatedFields.Quotes;

        _.each(this.panelFields, function(field) {
            pDependentField = pFieldDeps[field.name];
            pRelatedField = pRelatedFields[field.name];

            if (pDependentField) {
                tmpRelatedFields = _.extend({}, pDependentField.locked, pDependentField.related);

                if (!_.isEmpty(tmpRelatedFields)) {
                    field.dependentFields = tmpRelatedFields;
                    field.required = true;
                }

                if (field.required && !field.initialState) {
                    field.initialState = 'filled';
                    relatedFieldsList.push(field.name);
                }
            }

            if (pRelatedField) {
                tmpRelatedFields = _.extend({}, pRelatedField.locked, pRelatedField.related);

                if (!_.isEmpty(tmpRelatedFields)) {
                    field.relatedFields = field.relatedFields || [];

                    _.each(tmpRelatedFields, function(relField, relFieldName) {
                        field.relatedFields.push(relFieldName);
                    }, this);
                }
            }

            tmpField = _.find(this.listHeaderFields, function(headerField) {
                return headerField.name === field.name;
            });
            if (tmpField) {
                // if this panelField exists in listHeaderFields, set to visible
                field.initialState = 'checked';
            }
        }, this);

        this.model.set(this.eventViewName + '_related_fields', relatedFieldsList);

        // trigger to render the fields on config page load
        this.context.trigger('config:fields:change', this.eventViewName, this.panelFields);
    },

    /**
     * @inheritdoc
     */
    _onConfigFieldChange: function(field, oldState, newState) {
        var fieldVarDef = this.quotesFieldMeta[field.name];
        var fieldViewDef;
        var wasVisible = oldState === 'checked';
        var isNowVisible = newState === 'checked';
        var isUnchecked = newState === 'unchecked';
        var columnChanged = false;
        var toggleRelatedFields;

        if (!wasVisible && isNowVisible) {
            // field was not visible, but now is visible
            fieldViewDef = {
                name: fieldVarDef.name,
                type: fieldVarDef.type,
                label: fieldVarDef.vname || fieldVarDef.label
            };
            fieldViewDef.labelModule = this._getFieldLabelModule(field);

            // add the column to header fields
            this.listHeaderView.addColumnHeaderField(fieldViewDef);

            toggleRelatedFields = true;
            columnChanged = true;
        } else if (wasVisible && !isNowVisible) {
            // field was visible, but now is not visible, so remove from columns
            // remove the column from header fields
            this.listHeaderView.removeColumnHeaderField(fieldVarDef);

            toggleRelatedFields = false;
            columnChanged = true;
        } else if (!wasVisible && !isNowVisible && isUnchecked) {
            columnChanged = true;
            toggleRelatedFields = false;
        }

        if (columnChanged) {
            if (!_.isUndefined(toggleRelatedFields) && field.def.relatedFields) {
                _.each(field.def.relatedFields, function(fieldName) {
                    this.context.trigger(
                        'config:' + this.eventViewName + ':' + fieldName + ':related:toggle',
                        field,
                        toggleRelatedFields
                    );
                }, this);
            }
        }
    },

    /**
     * @inheritdoc
     */
    render: function() {
        this._super('render');

        this.listHeaderView = app.view.createView({
            context: this.context,
            eventViewName: this.eventViewName,
            type: 'config-list-header-columns',
            layout: this,
            model: this.model
        });

        this.$('.quote-summary-data-list-table').append(this.listHeaderView.el);

        // set the column header fields and render
        this.listHeaderView.setColumnHeaderFields(this.listHeaderFields);
    },

    /**
     * @inheritdoc
     */
    _customFieldDef: function(def) {
        def.eventViewName = this.eventViewName;

        return def;
    },

    /**
     * Handles the click event when user clicks to Restore Default fields
     * @param evt
     */
    onClickRestoreDefaultsBtn: function(evt) {
        var fieldList = _.pluck(this.defaultFields, 'name');
        this.listHeaderView.setColumnHeaderFields(this.defaultFields);
        this.context.trigger('config:fields:' + this.eventViewName + ':reset', fieldList);
    }
})
