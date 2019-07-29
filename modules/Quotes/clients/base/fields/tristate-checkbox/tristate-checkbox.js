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
 * @class View.Fields.Base.Quotes.TristateCheckboxField
 * @alias SUGAR.App.view.fields.BaseQuotesTristateCheckboxField
 * @extends View.Fields.Base.BaseField
 */
({
    /**
     * @inheritdoc
     */
    events: {
        'click .checkbox': 'onCheckboxClicked'
    },

    /**
     * The list of possible states the field can be in
     * @type Object
     */
    statesData: undefined,

    /**
     * The previous state's state data
     * @type Object
     */
    previousState: undefined,

    /**
     * The name of the previous state
     * @type string
     */
    previousStateName: undefined,

    /**
     * The current state's state data
     * @type Object
     */
    currentState: undefined,

    /**
     * The name of the current state
     * @type string
     */
    currentStateName: undefined,

    /**
     * If the field is required by other fields
     * @type boolean
     */
    isRequired: undefined,

    /**
     * Text for the field's tooltip
     * @type string
     */
    tooltipText: undefined,

    /**
     * List of any dependent fields
     * @type Object
     */
    dependentFields: undefined,

    /**
     * Stored version of the app lang tooltip label
     */
    tooltipLabel: undefined,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this.dependentFields = _.clone(this.def.dependentFields) || {};

        this.statesData = this._getStatesData();

        this.isRequired = this.def.required || false;

        this.changeState(this._getInitialState());

        this.tooltipLabel = app.lang.get('LBL_CONFIG_TOOLTIP_FIELD_REQUIRED_BY', this.module);
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this._super('bindDataChange');
        this.context.on(
            'config:' + this.def.eventViewName + ':' + this.name + ':related:toggle',
            this._onToggleRelatedField,
            this
        );
        this.context.on('config:fields:' + this.def.eventViewName + ':reset', this._onFieldsReset, this);
    },

    /**
     * @inheritdoc
     */
    bindDomChange: function() {
    },

    /**
     * Handles changing from the current state to the next state
     *
     * @param {string} nextState The next state to transition to
     */
    changeState: function(nextState) {
        this.previousState = this.currentState;
        this.previousStateName = this.currentStateName;

        this.currentStateName = nextState;
        this.currentState = this.statesData[this.currentStateName];

        this.render();
    },

    /**
     * @inheritdoc
     */
    render: function() {
        this._updateTooltipText();

        this._super('render');

        if (this.currentState.isIndeterminate) {
            this.$('.checkbox').prop('indeterminate', true);
        }
    },

    /**
     * Returns if this is a required field or not
     *
     * @return {Object} If required was sent in from the field def or false
     * @protected
     */
    _getIsRequired: function() {
        return this.def.required || false;
    },

    /**
     * Returns the possible states data for the field
     *
     * @return {Object}
     * @protected
     */
    _getStatesData: function() {
        return {
            unchecked: {
                ariaState: 'false',
                checked: false,
                nextState: 'checked',
                nextStateIfRequired: 'checked', // filled
                isIndeterminate: false
            },
            checked: {
                ariaState: 'true',
                checked: true,
                nextState: 'unchecked', // filled
                nextStateIfRequired: 'filled',
                isIndeterminate: false
            },
            filled: {
                ariaState: 'mixed',
                checked: false,
                nextState: 'unchecked',
                nextStateIfRequired: 'checked',
                isIndeterminate: true
            }
        };
    },

    /**
     * Toggles field's inclusion in dependentFields to be ready for updating tooltip text
     *
     * @param {Object|Array} relatedFields Related fields that are dependent upon this field
     * @param {boolean} toggleFieldOn True if we're toggling fields on
     * @private
     */
    _onToggleRelatedField: function(relatedFields, toggleFieldOn) {
        if (!_.isArray(relatedFields)) {
            // make sure related fields is an array
            relatedFields = [relatedFields];
        }

        if (toggleFieldOn) {
            _.each(relatedFields, function(relatedField) {
                this.dependentFields[relatedField.name] = {
                    module: relatedField.def.labelModule,
                    field: relatedField.name,
                    reason: 'related_fields'
                };
            }, this);

            this.isRequired = true;

            if (this.currentStateName === 'unchecked') {
                // if we haven't changed this field from unchecked yet
                // change to the related state
                this.changeState('filled');
            }
        } else {
            _.each(relatedFields, function(relatedField) {
                delete this.dependentFields[relatedField.name];
            }, this);

            if (_.isEmpty(this.dependentFields)) {
                // Removing related fields that are not required by any displayed fields and is not checked
                if (this.currentStateName === 'filled') {
                    this.changeState('unchecked');
                }
                this.isRequired = false;
            }
        }

        // bubble up the related fields
        if (this.def.relatedFields) {
            if (toggleFieldOn ||
                (!toggleFieldOn && !this.isRequired && this.currentStateName === 'unchecked')) {
                // only add this field when we're toggling fields on,
                // or when toggling them off and this field is no longer required
                // and this field is unchecked
                relatedFields.push(this);
            }
            _.each(this.def.relatedFields, function(fieldName) {
                this.context.trigger(
                    'config:' + this.def.eventViewName + ':' + fieldName + ':related:toggle',
                    relatedFields,
                    toggleFieldOn
                );
            }, this);
        }

        this.render();
    },

    /**
     * Handles when the Restore Defaults link is clicked in config-columns
     *
     * @protected
     */
    _onFieldsReset: function(defaultFieldList) {
        // reset dependent fields back
        this.dependentFields = _.clone(this.def.dependentFields) || {};
        this.isRequired = !_.isEmpty(this.dependentFields);

        if (!_.contains(defaultFieldList, this.name)) {
            if (this.def.initialState === 'checked' && !this.isRequired) {
                this.def.initialState = 'unchecked';
            } else if (this.def.initialState === 'unchecked' && this.isRequired) {
                this.def.initialState = 'checked';
            } else if (this.def.initialState === 'checked' && this.isRequired &&
                _.intersection(defaultFieldList, this.dependentFields).length === 0) {
                this.def.initialState = 'unchecked';
                this.def.dependentFields = {};
            }
        } else {
            // Making sure default fields are checked.
            this.def.initialState = 'checked';
        }

        this.changeState(this._getInitialState());
    },

    /**
     * Handles when a user clicks on the field input
     *
     * @param {Event} evt The click event object
     */
    onCheckboxClicked: function(evt) {
        var nextState = this.isRequired ? this.currentState.nextStateIfRequired : this.currentState.nextState;
        var summaryColumns = this.view.model.get('summary_columns');
        evt.preventDefault();

        if (this.def.eventViewName === 'summary_columns' && summaryColumns && summaryColumns.length >= 6 &&
            nextState === 'checked') {
            app.alert.show('max_summaryColumns_reached', {
                level: 'warning',
                messages: app.lang.get('LBL_SUMMARY_WORKSHEET_COLUMNS_MAX_WARNING', this.module),
                autoclose: true
            }, this);

            nextState = 'unchecked';
            this._onCheckboxClicked(this.currentStateName, nextState);
            this.changeState(nextState);
        } else {
            this._onCheckboxClicked(this.currentStateName, nextState);
            this.changeState(nextState);
        }
    },

    /**
     * Handle any other events or actions that need to happen
     * when the checkbox is clicked, but before we change state.
     *
     * @param {string} currentState The name of the current state
     * @param {string} nextState The name of the next state
     * @protected
     */
    _onCheckboxClicked: function(currentState, nextState) {
        this.context.trigger(
            'config:' + this.def.eventViewName + ':field:change',
            this,
            currentState,
            nextState
        );
    },

    /**
     * @inheritdoc
     */
    _updateTooltipText: function() {
        var text;
        var isLTR = app.lang.direction === 'ltr';
        this.tooltipText = '';

        if (!_.isEmpty(this.dependentFields)) {
            this.tooltipText = '<div class="tristate-checkbox-config-tooltip">' + this.tooltipLabel + '<ul>';

            _.each(this.dependentFields, function(field) {
                text = isLTR ? field.module + ' - ' + field.field : field.field + ' - ' + field.module;
                this.tooltipText += '<li>' + text + '</li>';
            }, this);
            this.tooltipText += '</ul></div>';
        }
    },

    /**
     * Returns the initial state for the field
     *
     * @return {string} The initial state for the field
     * @protected
     */
    _getInitialState: function() {
        return this.def.initialState || 'unchecked';
    }
})
