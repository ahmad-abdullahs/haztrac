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
 * @class View.Views.Base.pmse_Project.DependencyPickerView
 * @alias SUGAR.App.view.views.Basepmse_ProjectDependencyPickerView
 * @extends View.View
 */
({
    /**
     * The dependency collections map
     */
    collections: {},

    /**
     * The dependency models map
     */
    models: {},

    /**
     * Indicates if there are any dependencies
     */
    hasDependencies: false,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this.context.on('updateData', this.processData, this);
        this.brCollection = app.data.createBeanCollection('br');
        this.etCollection = app.data.createBeanCollection('et');
        this.massCollection = app.data.createBeanCollection('pmse_elements');

        this.brModel = app.data.createBean('br', {elementType: 'business_rule'});
        this.etModel = app.data.createBean('et', {elementType: 'email_template'});

        this._setUpCollectionMap();
        this._setUpModelMap();

        this.context.set('mass_collection', this.massCollection);
        this._bindMassCollectionEvents();

        this.leftColumns = [{
            type: 'fieldset',
            fields: [
                {
                    name: 'actionmenu',
                    type: 'actionmenu',
                    buttons: [],
                    disable_select_all_alert: true
                }
            ],
            value: false,
            sortable: false
        }];
    },

    /**
     * Save collection to object for easy accessing
     * @private
     */
    _setUpCollectionMap: function() {
        this.collections.business_rule = this.brCollection;
        this.collections.email_template  = this.etCollection;
        this.collections.mass_collection = this.massCollection;
    },

    /**
     * Save models to object for easy accessing
     * @private
     */
    _setUpModelMap: function() {
        this.models.business_rules = this.brModel;
        this.models.email_template = this.etModel;
    },

    /**
     * Add dependencies to their respective collections and render
     * @param data
     */
    processData: function(data) {
        this._resetCollections();

        this.hasDependencies = false;

        // No dependencies so don't do anything
        if (!data || !data.dependencies) {
            this.render();
            return;
        }

        _.each(data.dependencies, function(defs, type) {
            var collection = this._getCollectionForType(type);
            // add dependency only when there's a definition
            if (collection && !_.isEmpty(defs)) {
                collection.add(defs);
                this.hasDependencies = true;
            }
        }, this);

        this._cleanFieldsForView();

        this.render();
    },

    /**
     * Set up the mass collection's events
     * @private
     */
    _bindMassCollectionEvents: function() {
        this.context.on('mass_collection:add', _.bind(this._updateModels, this, true));
        this.context.on('mass_collection:add:all', _.bind(this._updateAllModels, this, true));
        this.context.on('mass_collection:remove', _.bind(this._updateModels, this, false));
        this.context.on('mass_collection:remove:all', _.bind(this._updateAllModels, this, false));
    },

    /**
     * Add or remove a model or models in the mass collection. If all checkboxes are in a group are checked,
     * toggle the select all checkbox to checked. When removing a model, uncheck the select all checkbox
     *
     * @param {boolean} `true` to add model, `false` to remove
     * @param {Data.Bean|Data.Bean[]} models The model or the list of models to add/remove.
     * @private
     */
    _updateModels: function(addModel, models) {
        models = _.isArray(models) ? models : [models];
        var type = _.first(models).elementType;
        if (addModel) {
            this.massCollection.add(models);
            if (this._isAllChecked(type)) {
                this._toggleAllCheckbox(type, true);
            }
        } else {
            this.massCollection.remove(models);
            this._toggleAllCheckbox(type, false);
        }
    },

    /**
     * Add or remove all models for the collection group to the mass collection
     *
     * @param {boolean} `true` to add all models, `false` to remove all
     * @param {Data.Bean} checkbox Model containing elementType to indicate which
     *  check-all box was checked
     * @private
     */
    _updateAllModels: function(addModels, checkbox) {
        var type = checkbox.get('elementType');
        var models = this._getCollectionForType(type).models;
        this._updateModels(addModels, models);
    },

    /**
     * Checks if all elements in the collection are in the mass collection
     *
     * @param {string} type The element type
     * @return {boolean} `true` if all elements are in the mass collection
     * @private
     */
    _isAllChecked: function(type) {
        var collection = this._getCollectionForType(type);
        if (this.massCollection.length < collection.length) {
            return false;
        }
        var allChecked = _.every(collection.models, function(model) {
            return this.massCollection.get(model.id);
        }, this);

        return allChecked;
    },

    /**
     * Check/Uncheck the check-all checkbox
     * @param {string} type The element type
     * @param {boolean} check `true` to mark checked
     * @private
     */
    _toggleAllCheckbox: function(type, check) {
        var checkboxField = this.getField('actionmenu', this._getModelForType(type));
        checkboxField.$(checkboxField.fieldTag).prop('checked', check);
    },

    /**
     * Get the collection for type
     * @param {string} type The element type
     * @return {Data.BeanCollection|null} The collection asked for
     * @private
     */
    _getCollectionForType: function(type) {
        return this.collections[type] || null;
    },

    /**
     * Get the model for type
     * @param {string} type The element type
     * @return {Data.Bean|null} The model asked for
     * @private
     */
    _getModelForType: function(type) {
        return this.models[type] || null;
    },

    /**
     * Set up fields for the model so we render correctly
     * @private
     */
    _cleanFieldsForView: function() {
        _.each(this.collections, function(collection, type) {
            _.each(collection.models, function(model) {
                model.fields = this.meta.fields;
                model.elementType = type;
            }, this);
        }, this);
    },

    /**
     * Remove all the models from the collections
     * @param {Data.BeanCollection[]} collections
     * @private
     */
    _resetCollections: function(collections) {
        collections = collections || this.collections;
        _.each(collections, function(collection) {
            collection.reset();
        });
    }
})
