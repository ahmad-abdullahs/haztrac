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
 * @class View.Views.Base.Quotes.ConfigTotalsFooterRowsView
 * @alias SUGAR.App.view.views.BaseQuotesConfigTotalsFooterRowsView
 * @extends View.Views.Base.View
 */
({
    /**
     * CSS Class for Totals fields
     */
    sortableFieldsContainerClass: 'totals-fields',

    /**
     * CSS Class for Grand Totals fields
     */
    sortableGrandTotalFieldsContainerClass: 'grand-total-fields',

    /**
     * Array to hold the Totals fields objects
     */
    footerFields: undefined,

    /**
     * Array to hold the Grand Totals fields objects
     */
    footerGrandTotalFields: undefined,

    /**
     * Data attribute key to use for Totals fields
     */
    fieldTotalKey: 'total',

    /**
     * Data attribute key to use for Grand Totals fields
     */
    fieldGrandTotalKey: 'grand-total',

    /**
     * Array to hold the server synced fields objects
     */
    syncedFields: undefined,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this.footerFields = [];
        this.footerGrandTotalFields = [];
        this.syncedFields = [];
    },

    /**
     * Sets an array of fields into the footer rows
     *
     * @param {Array} footerFields The array of footer fields to set in the footer rows view
     */
    setFooterRowFields: function(footerFields) {
        this.syncedFields = _.clone(footerFields);
        this.footerFields = [];
        this.footerGrandTotalFields = [];

        this.model.set(this.options.eventViewName, this.syncedFields);

        _.each(this.syncedFields, function(field) {
            field.syncedType = field.type;
            field.type = 'currency';

            field.syncedCssClass = field.syncedCssClass || field.css_class || '';
            field.css_class = '';

            if (field.syncedCssClass.indexOf('grand-total') === -1) {
                this.footerFields.push(field);
            } else {
                this.footerGrandTotalFields.push(field);
            }
        }, this);

        this.render();
    },

    /**
     * Adds a field to the list of footer rows
     *
     * @param {Object} field The field defs of the field to add
     */
    addFooterRowField: function(field) {
        var newFieldsArr;

        // add field to top of footerFields
        this.footerFields.unshift(field);

        // rebuild the fields array for the model
        newFieldsArr = this._parseFieldsForModel();

        // save and render the new fields state
        this.model.set(this.options.eventViewName, newFieldsArr);
        this.render();
    },

    /**
     * Removes a field from the list of footer rows
     *
     * @param {Object} field The field defs of the field to remove
     */
    removeFooterRowField: function(field) {
        var newFieldsArr;

        // remove field from wherever it exists
        this.footerFields = _.reject(this.footerFields, function(f) {
            return f.name === field.name;
        });

        this.footerGrandTotalFields = _.reject(this.footerGrandTotalFields, function(f) {
            return f.name === field.name;
        });

        // rebuild the fields array for the model
        newFieldsArr = this._parseFieldsForModel();

        // save and render the new fields state
        this.model.set(this.options.eventViewName, newFieldsArr);
        this.render();
    },

    /**
     * @inheritdoc
     */
    render: function() {
        this._super('render');

        this.$('.connected-containers').sortable({
            // the items to make sortable
            items: '.sortable-item',
            // make the "helper" row (the row the user actually drags around) a clone of the original row
            helper: 'clone',
            // adds a slow animation when "dropping" a group, removing this causes the row
            // to immediately snap into place wherever it's sorted
            revert: true,
            // connect all connected-containers with each other
            connectWith: '.connected-containers',
            // allow drag to only go in Y axis direction
            axis: 'y',
            // the CSS class to apply to the placeholder underneath the helper clone the user is dragging
            placeholder: 'ui-state-highlight',
            // the cursor to use when dragging
            cursor: 'move',
            // handler for when dragging stops; the "drop" event
            stop: _.bind(this._onDragStop, this)
        }).disableSelection();

        this.$('.connected-containers').droppable({
            accept: '.sortable-item',
            stop: _.bind(this._onDragStop, this)
        });
    },

    /**
     * Handles when a user drops a dragged item into a sortable/droppable container
     *
     * @param {jQuery.Event} evt The jQuery drag stop event
     * @param {Object} ui The jQuery Sortable UI Object
     * @private
     */
    _onDragStop: function(evt, ui) {
        var $el = $(ui.item || ui.draggable);
        var fieldName = $el.data('fieldName');
        var fieldType = $el.data('fieldType');
        var groupType = $el.parent().data('groupType');
        var sortableTotalItemsCssSelector = '.' + this.sortableFieldsContainerClass + ' .sortable-item';
        var sortableGrandTotalItemsCssSelector = '.' + this.sortableGrandTotalFieldsContainerClass + ' .sortable-item';
        var newFieldsArr;

        if (fieldType !== groupType) {
            // the field has changed groups
            if (fieldType === this.fieldTotalKey && groupType === this.fieldGrandTotalKey) {
                // was total, now grand-total

                this._moveFieldToNewPosition(
                    fieldName,
                    this.footerFields,
                    this.footerGrandTotalFields,
                    sortableGrandTotalItemsCssSelector
                );

            } else if (fieldType === this.fieldGrandTotalKey && groupType === this.fieldTotalKey) {
                // was grand-total, now total

                this._moveFieldToNewPosition(
                    fieldName,
                    this.footerGrandTotalFields,
                    this.footerFields,
                    sortableTotalItemsCssSelector
                );
            }

            // set the new group type onto the field
            $el.data('fieldType', groupType);
        } else {
            // field stayed in same group

            if (groupType === 'total') {
                this._moveFieldToNewPosition(
                    fieldName,
                    this.footerFields,
                    this.footerFields,
                    sortableTotalItemsCssSelector
                );
            } else {
                this._moveFieldToNewPosition(
                    fieldName,
                    this.footerGrandTotalFields,
                    this.footerGrandTotalFields,
                    sortableGrandTotalItemsCssSelector
                );
            }
        }

        newFieldsArr = this._parseFieldsForModel();

        this.model.set(this.options.eventViewName, newFieldsArr);

        this.render();
    },

    /**
     * Parses footerFields and footerGrandTotalFields cleaning up CSS classes and merging them into one array
     *
     * @return {Array} The merged, processed array from footerFields and footerGrandTotalFields
     * @private
     */
    _parseFieldsForModel: function() {
        var newFieldsArr = [];
        var cssArr;
        var tmpField;

        _.each(this.footerFields, function(field) {
            cssArr = [];
            tmpField = _.clone(field);

            if (tmpField.syncedCssClass) {
                cssArr = cssArr.concat(tmpField.syncedCssClass.split(' '));
            }
            if (tmpField.css_class) {
                cssArr = cssArr.concat(tmpField.css_class.split(' '));
            }
            if (tmpField.syncedType) {
                tmpField.type = tmpField.syncedType;
            }
            if (cssArr.length) {
                cssArr = _.chain(cssArr)
                // only unique classes
                    .uniq()
                    // remove any grand-total css class since this is not in the grand total section
                    .without(this.fieldGrandTotalKey)
                    .value();
                tmpField.css_class = cssArr.join(' ');
            }
            newFieldsArr.push(_.pick(tmpField, 'name', 'type', 'label', 'css_class', 'default'));
        }, this);

        _.each(this.footerGrandTotalFields, function(field) {
            cssArr = [];
            tmpField = _.clone(field);

            if (tmpField.syncedCssClass) {
                cssArr = cssArr.concat(tmpField.syncedCssClass.split(' '));
            }
            if (tmpField.css_class) {
                cssArr = cssArr.concat(tmpField.css_class.split(' '));
            }
            if (tmpField.syncedType) {
                tmpField.type = tmpField.syncedType;
            }

            // make sure the grand total items have the grand total class
            cssArr.push(this.fieldGrandTotalKey);

            if (cssArr.length) {
                tmpField.css_class = _.uniq(cssArr).join(' ');
            }
            newFieldsArr.push(_.pick(tmpField, 'name', 'type', 'label', 'css_class', 'default'));
        }, this);

        return newFieldsArr;
    },

    /**
     * Moves a field to a new group and position if oldGroup and newGroup are different.
     * If oldGroup and newGroup are the same, it just moves a field to a new position
     * inside the same group.
     *
     * @param {string} fieldName The name of the field being moved
     * @param {Array} oldGroup The old group's array of fields
     * @param {Array} newGroup The new group's array of fields
     * @param {string} newGroupSelector The css selector for the new group
     * @private
     */
    _moveFieldToNewPosition: function(fieldName, oldGroup, newGroup, newGroupSelector) {
        var tmpField;
        var tmpFieldIndex;
        var $newGroupElements;

        // find the index of the item in the old group
        tmpFieldIndex = _.findIndex(oldGroup, function(row) {
            return row.name === fieldName;
        }, this);

        // remove the field from the old group
        tmpField = oldGroup.splice(tmpFieldIndex, 1)[0];

        // get the elements inside the new group
        $newGroupElements = this.$(newGroupSelector);

        // get the index of the field in the new group
        tmpFieldIndex = _.findIndex($newGroupElements, function(el) {
            return $(el).data('fieldName') === fieldName;
        }, this);

        // add the moved field into the new group
        newGroup.splice(tmpFieldIndex, 0, tmpField);
    }
})
