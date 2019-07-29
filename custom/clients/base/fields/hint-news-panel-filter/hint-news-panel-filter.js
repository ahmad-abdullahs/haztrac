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
 * @class View.Fields.Base.HintNewsPanelFilterField
 * @alias SUGAR.App.view.fields.BaseHintNewsPanelFilterFieldField
 * @extends View.Fields.Base.EnumField
 */
({
    extendsFrom: 'EnumField',

    initialize: function(options) {
        this.defaultOption = options.viewDefs.default;
        this._super('initialize', [options]);
    },

    /**
     * @override
     * Custom options for the dropdown. By default the search input will filter and search
     * the available options fed into the dropdown. The createSearchChoice method will allow us
     * to add options to the dropdown dynamically instead of the classic filtering.
     */
    getSelect2Options: function() {
        var select2Options = {};
        select2Options.width = '100%';
        select2Options.dropdownCssClass = this.def.dropdown_class ? this.def.dropdown_class : '';
        if (this.def.container_class) {
            select2Options.containerCssClass = this.def.container_class;
        } else if (this.def.isMultiSelect) {
            select2Options.containerCssClass = 'select2-choices-pills-close';
        } else {
            select2Options.containerCssClass = '';
        }

        select2Options.minimumResultsForSearch = 1;

        select2Options.initSelection = _.bind(this._initSelection, this);
        select2Options.query = _.bind(this._query, this);

        select2Options.createSearchChoice = function(term) {
            return {
                id: term, text: term
            };
        };
        select2Options.createSearchChoicePosition = 'top';

        return select2Options;
    },

    /**
     * Looks through the available options from the dropdown and returns the option if found.
     * If the option is not found an empty object will be returned.
     * Note that aside the initial options fed to the dropdown
     * we need to take into account the option created dynamically by the filter input.
     * 
     * @param {String} filter The id of an existing dropdown option.
     * @return {Object} Represents an option from the dropdown; the object has a single property.
     * The property's value is the displayed text and the key is the real value/the id.
     */
    getMatchingOption: function(filter) {
        var items = _.isString(this.items) ? app.lang.getAppListStrings(this.items) : this.items;
        this.items = this._filterOptions(items);
        var filteredItems = this._filterOptions(items),
            extendedFilteredItems = _.extend({}, filteredItems, this.searchTerm || {});
        return _.pick(extendedFilteredItems, filter);
    },

    /**
     * @inheritdoc
     * This is a simplified version of the original, additionally allows us
     * to set a default value and a placeholder text.
     */
    _initSelection: function($ele, callback) {
        var filter = $ele.val() || this.defaultOption,
            matchingOption = this.getMatchingOption(filter);

        callback({
            id: _.keys(matchingOption)[0] || 'placeholder',
            text: _.values(matchingOption)[0] || app.lang.get('LBL_SEARCH_SELECT')
        });
    },

    /**
     * When typing into the dropdown's input we would like to be able to create a new option
     * based on the input text and be able to select it. This method will save the search term
     * into a component variable so we could later confirm that we would like to select the dynamic option.
     * 
     * @param {Object} The option being selected.
     */
    setSearchTerm: function(selection) {
        this.searchTerm = {};
        this.searchTerm[selection.choice.id] = selection.choice.text;
    },

    /**
     * Sets an option manually for the filter dropdown. If the option is not existing
     * we handle it as a search term input, an option created dynamically. Null is taken as
     * the default filter.
     * 
     * @param {String} filter The id of an existing dropdown option or just a custom string to be set.
     */
    setFilter: function(filter) {
        if (filter === null) filter = 'All';
        if (!this.items[filter]) {
            this.setSearchTerm({ choice: { id: filter, text: filter } });
        }
        this.dropdown.select2('val', filter);
    },

    /**
     * We trigger an event that could be caught by other parts of the application.
     * If the new value is 'All' we consider it as a null filter.
     * 
     * @param {Object} event The change event object.
     */
    exportFilter: function(event) {
        var category = event.added.id === 'All' ? null : event.added.id;
        app.events.trigger('hint-news-panel:filter', category);
    },

    bindEvents: function() {
        this.dropdown = this.$(this.fieldTag);
        this.dropdown.on('change', this.exportFilter);
        app.events.on('hint-news-panel-filter:set', this.setFilter, this);
        this.dropdown.on('select2-selecting', _.bind(this.setSearchTerm, this));
    },

    /**
     * @inheritdoc
     * We bind the events to the select2 dropdown only after it has been initialized.
     */
    _render: function() {
        this._super('_render');
        this.bindEvents();
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        app.events.off('hint-news-panel-filter:set');
        this.dropdown.off('change', this.exportFilter);
        this.dropdown.off('select2-selecting', _.bind(this.setSearchTerm, this));
        this._super('_dispose');
    }
});
