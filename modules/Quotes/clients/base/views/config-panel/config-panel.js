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
 * @class View.Views.Base.Quotes.ConfigPanelView
 * @alias SUGAR.App.view.views.BaseQuotesConfigPanelView
 * @extends View.Views.Base.ConfigPanelView
 */
({
    /**
     * @inheritdoc
     */
    extendsFrom: 'BaseConfigPanelView',

    /**
     * Holds an array of field names for the panel
     */
    panelFieldNameList: undefined,

    /**
     * Holds an array of field viewdefs for the panel
     */
    panelFields: undefined,

    /**
     * Contains the map of all related field dependencies
     */
    dependentFields: undefined,

    /**
     * Contains the map of all dependencies for each field
     */
    relatedFields: undefined,

    /**
     * The view name ID to use in events
     */
    eventViewName: undefined,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this.eventViewName = this._getEventViewName();

        this.getPanelFieldNamesList();

        var helpUrl = {
            more_info_url: '<a href="' + app.help.getMoreInfoHelpURL('config', 'QuotesConfig') + '" target="_blank">',
            more_info_url_close: '</a>',
        };
        var viewQuotesObj = app.help.get('Quotes', 'config_opps', helpUrl);
        this.quotesDocumentation = app.template.getView('config-panel.help', this.module)(viewQuotesObj);
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this._super('bindDataChange');

        this.context.once('change:dependentFields', this._onDependentFieldsChange, this);
        this.context.on('config:' + this.eventViewName + ':field:change', this._onConfigFieldChange, this);
    },

    /**
     * Returns the event and view name for this config panel.
     * Should be overridden by child views.
     *
     * @return {string}
     * @private
     */
    _getEventViewName: function() {
        return 'config_panel';
    },

    /**
     * Handles when the field dependencies list comes back from the config endpoint.
     * Should be extended in child classes to include anything specific views need to do
     * with the field dependencies list.
     *
     * @param {Core.Context} context
     * @param {Object} fieldDeps Dependent Fields
     * @protected
     */
    _onDependentFieldsChange: function(context, fieldDeps) {
        this.dependentFields = _.clone(fieldDeps);
        this.relatedFields = _.clone(this.context.get('relatedFields'));
        this.panelFields = this._buildPanelFieldsList();
    },

    /**
     * Handles when a checkbox on the RHS gets toggled
     *
     * @param {View.Fields.Base.TristateCheckboxField} field The field that was toggled
     * @param {string} oldState The old state for the field
     * @param {string} newState The new state for the field
     * @protected
     */
    _onConfigFieldChange: function(field, oldState, newState) {
    },

    /**
     * Returns an Array of field names to be used by the panel fields
     *
     * @return {Array}
     */
    getPanelFieldNamesList: function() {
        this.panelFieldNameList = [];
    },

    /**
     * Returns an Array of field names to be used by the panel fields
     *
     * @param {Array} fields The array of fields to use for panelFields
     * @return {Array}
     * @protected
     */
    _buildPanelFieldsList: function() {
        var fields = this._getPanelFields();
        var moduleName = this._getPanelFieldsModule();

        // convert fieldsObj to an array then sort the array by name
        if (!_.isArray(fields)) {
            var tmpArray = [];
            _.each(fields, function(value, key) {
                tmpArray.push(_.extend(value, {
                    name: key
                }));
            }, this);
            fields = tmpArray;
        }

        // apply any additional sorting to the fields
        fields = this._customFieldsSorting(fields);

        // return an array of the objects that pass the criteria
        fields = this._customFieldsProcessing(fields);

        fields = _.map(fields, function(field) {
            var def = {
                name: field.name,
                label: app.lang.get(field.label, moduleName),
                type: 'tristate-checkbox',
                labelModule: moduleName,
                locked: field.locked,
                related: field.related
            };

            return this._customFieldDef(def);
        }, this);

        return fields;
    },

    /**
     * Extensible function to get the fields array to be used in buildPanelFieldsList
     *
     * @private
     */
    _getPanelFields: function() {
        return [];
    },

    /**
     * Extensible function to get the module name for the buildPanelFieldsList
     *
     * @private
     */
    _getPanelFieldsModule: function() {
        return this.module;
    },

    /**
     * Handles any custom changes to the field defs a child view might need to make
     *
     * @param {Object} def The field def
     * @return {Object}
     * @protected
     */
    _customFieldDef: function(def) {
        return def;
    },

    /**
     * Handles any custom field sorting that child classes might need to do.
     * By default, sort by the name field
     *
     * @param {Array} arr The fields array
     * @return {Array}
     * @protected
     */
    _customFieldsSorting: function(arr) {
        return _.sortBy(arr, 'name');
    },

    /**
     * Handles any custom field processing, array manipulation, or changes
     * that child classes might need to do
     *
     * @param {Array} arr The fields array
     * @return {Array}
     * @protected
     */
    _customFieldsProcessing: function(arr) {
        return arr;
    }
})
