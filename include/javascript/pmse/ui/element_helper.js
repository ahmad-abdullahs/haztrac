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
// jscs:disable
var PMSE = PMSE || {};
/**
 * @class PMSE.ElementHelper
 * Helper class to handle support functionalities for the Element class
 * @extends PMSE.Base
 *
 *
 * @constructor
 * Create a new instance of the class 'PMSE.ElementHelper'
 * @param {Object} options
 */
PMSE.ElementHelper = function(options) {
    PMSE.Base.call(this, options);

    this._mode = null;

    this._currentMod = null;
    this._currentType = null;
    this._currentVal = null;
    this._currentRelMod = null;
    this._currentRelType = null;
    this._currentRelVal = null;

    this._dateFormat = null;
    this._timeFormat = null;
    this._decimalSeparator = null;
    this._numberGroupingSeparator = null;
    this._auxSeparator = "|||";
    this._itemValueWildcard = '%VALUE%';
    this._currencies = [];
    this._preferredCurrency = null;

    this._parent = null;

    PMSE.ElementHelper.prototype.initObject.call(this, options);
};
PMSE.ElementHelper.prototype = new PMSE.Base();

/**
 * Defines the object type
 * @type {String}
 * @private
 */
PMSE.ElementHelper.prototype.type = 'Base';
/**
 * Defines the object family
 * @type {String}
 * @private
 */
PMSE.ElementHelper.prototype.family = 'Base';

PMSE.ElementHelper.prototype._typeToControl = {
    "address": "text",
    "checkbox": "checkbox",
    "currency": "currency",
    "date": "date",
    "datetime": "datetime", //
    "decimal": "number",
    "encrypt": "text",
    "dropdown": "dropdown",
    "float": "number",
    "email": "text",
    "name": "text",
    "htmleditable_tinymce": "text",
    "tinyint": "integer",
    //"html": "html",
    //"iframe": "iframe",
    //"image": "image" ,
    "integer": "integer",
    "multiselect": "multiselect",
    //"flex relate": "flexrelate",
    "phone": "text",
    "radio": "radio",
    //"relate": "related",
    "textarea": "text",//"textarea",
    "url": "text",
    "textfield": "text",
    "user": "friendlydropdown"
};

/**
 * Initializes the operators
 * @return {*}
 */
PMSE.ElementHelper.prototype.initOperators = function () {
    PMSE.ElementHelper.prototype.OPERATORS  = {
        'runTime': [
            {
                text: translate('LBL_PMSE_RUNTIME_BUTTON'),
                value: 'Run Time'
            }
        ],
        "arithmetic": [
            {
                text: "+",
                value: "addition"
            },
            {
                text: "-",
                value: "substraction"
            },
            {
                text: "x",
                value: "multiplication"
            },
            {
                text: "/",
                value: "division"
            }
        ],
        "logic": [
            {
                text: "AND",
                value: "AND"
            },
            {
                text: "OR",
                value:  "OR"
            },
            {
                text: "NOT",
                value: "NOT"
            }
        ],
        'group': [
            {
                text: '(',
                value: '('
            },
            {
                text: ')',
                value: ')'
            }
        ]
    };
    return this;
};

/**
 * Initializes the comparison operators
 * @param {String} module
 * @return {*}
 */
PMSE.ElementHelper.prototype.initComparisonOperators = function(module) {
    var changesLabel = App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_CHANGES', module);
    var fromLabel = App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_CHANGES_FROM', module);
    var toLabel = App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_CHANGES_TO', module);
    PMSE.ElementHelper.prototype.OPERATORS.comparison = [
        {
            text: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_EQUAL', module),
            textfield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_EQUAL_TEXT', module),
            datefield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_EQUAL', module),
            value: 'equals'
        },
        {
            text: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_NOT_EQUAL', module),
            textfield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_NOT_EQUAL_TEXT', module),
            datefield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_NOT_EQUAL_DATE', module),
            value: 'not_equals'
        },
        {
            text: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_MAJOR', module),
            datefield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_MAJOR_DATE', module),
            value: 'major_than'
        },
        {
            text: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_MINOR_THAN', module),
            datefield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_MINOR_THAN_DATE', module),
            value: 'minor_than'
        },
        {
            text: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_MAJOR_EQUAL', module),
            datefield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_MAJOR_EQUAL_DATE', module),
            value: 'major_equals_than'
        },
        {
            text: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_MINOR_EQUAL_THAN', module),
            datefield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_MINOR_EQUAL_DATE', module),
            value: 'minor_equals_than'
        },
        {
            textfield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_STARTS_TEXT', module),
            value: "starts_with"
        },
        {
            textfield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_ENDS_TEXT', module),
            value: "ends_with"
        },
        {
            textfield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_CONTAINS_TEXT', module),
            value: "contains"
        },
        {
            textfield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_NOT_CONTAINS_TEXT', module),
            value: "does_not_contain"
        }
    ];
    PMSE.ElementHelper.prototype.OPERATORS.changes = [
        {
            text: changesLabel,
            textfield: changesLabel,
            datefield: changesLabel,
            value: 'changes'
        },
        {
            text: fromLabel,
            textfield: fromLabel,
            datefield: fromLabel,
            value: 'changes_from'
        },
        {
            text: toLabel,
            textfield: toLabel,
            datefield: toLabel,
            value: 'changes_to'
        }
    ];
    return this;
};

PMSE.ElementHelper.prototype.EXTRA_OPERATORS = {};

/**
 * Checks whether the character has special meaning in the RegExp pattern
 * @param {String} c
 * @return {Boolean}
 */
PMSE.ElementHelper.prototype._isRegExpSpecialChar = function (c) {
    switch (c) {
        case "\\":
        case "^":
        case "$":
        case "*":
        case "+":
        case "?":
        case ".":
        case "(":
        case ")":
        case "|":
        case "{":
        case "}":
            return true;
    }
    return false;
};

/**
 * Returns the RegExp pattern for the decimal separator
 * @return {Object}
 */
PMSE.ElementHelper.prototype._getDecimalSeparatorRegExp = function () {
    var prefix = "";
    if (this._isRegExpSpecialChar(this._decimalSeparator)) {
        prefix = "\\";
    }
    return new RegExp(prefix + this._decimalSeparator, "g");
};

/**
 * Parses the input for either a string or a number, returns the result
 * @param {String} value
 * @return {String}
 */
PMSE.ElementHelper.prototype._getStringOrNumber = function (value) {
    var aux, isNum = false;

    value = jQuery.trim(value);
    if (this._decimalSeparator !== ".") {
        isNum = value.indexOf(".") < 0;
        if (isNum) {
            aux = value.replace(this._getDecimalSeparatorRegExp(), ".");
        }
    }
    if(isNum && !isNaN(aux) && aux !== "") {
        aux = aux.split(".");
        value = parseInt(aux[0]);
        value += aux[1] ? parseInt(aux[1]) / Math.pow(10, aux[1].length) : 0;
    } else if (value.length > 1) {
        if (value[0] === "\"" && value.slice(-1) === "\"") {
            value = value.slice(1, -1);
        } else if (value[0] === "'" && value.slice(-1) === "'") {
            value = value.slice(1, -1);
        }
    }
    return value;
};

/**
 * Sets the currency fields of the form to use the proper currency settings
 * @return {*}
 */
PMSE.ElementHelper.prototype._updateCurrenciesToCurrenciesForm = function() {
    var currenciesField;
    if (this._parent && this._parent._constantPanels && this._parent._constantPanels.currency) {
        currenciesField = this._parent._constantPanels.currency.getItem("currency");
        currenciesField.setOptions(this._currencies);
        if (this._preferredCurrency) {
            currenciesField.setValue(this._preferredCurrency);
        }
    }
    if (this._parent && this._parent._evaluationPanels && this._parent._evaluationPanels.module) {
        currenciesField = this._parent._evaluationPanels.module.getItem("value");
        if (currenciesField instanceof FormPanelCurrency) {
            currenciesField.setCurrencies(this._currencies);
        }
    }
    return this;
};

/**
 * Creates a currency object
 * @param {Object} Data
 * @return {Object}
 * @private
 */
PMSE.ElementHelper.prototype._createCurrencyObject = function(data) {
    if (!(data.id && data.name && data.rate)) {
        throw new Error('_createCurrencyObject(): id, name and rate properties are required.');
    }
    return {
        id: data.id,
        iso: data.iso,
        name: data.name,
        rate: data.rate,
        preferred: !!data.preferred,
        symbol: data.symbol
    };
};

/**
 * Sets the currency objects
 * @param {Array} Currency objects
 * @return {Object} ElementHelper
 */
PMSE.ElementHelper.prototype.setCurrencies = function(currencies) {
    if (!$.isArray(currencies)) {
        throw new Error("setCurrencies(): The parameter must be an array.");
    }
    this._currencies = [];
    for (var i = 0; i < currencies.length; i++) {
        this._currencies.push(this._createCurrencyObject(currencies[i]));
        if (currencies[i].preferred) {
            this._preferredCurrency = currencies[i].id;
        }
    }
    return this._updateCurrenciesToCurrenciesForm();
};

/**
 * Sets the decimal separator
 * @param {String} decimalSeparator
 * @return {*}
 * @throws {Object}
 */
PMSE.ElementHelper.prototype.setDecimalSeparator = function (decimalSeparator) {
    if (!(typeof decimalSeparator === 'string' && decimalSeparator && decimalSeparator.length === 1
        && !/\d/.test(decimalSeparator) && !/[\+\-\*\/]/.test(decimalSeparator))) {
        throw new Error("setDecimalSeparator(): The parameter must be a single character different than a digit and "
            + "arithmetic operator.");
    }
    if (decimalSeparator === this._numberGroupingSeparator) {
        throw new Error("setDecimalSeparator(): The decimal separator must be different from the number grouping "
            + "separator.");
    }
    this._decimalSeparator = decimalSeparator;
    return this;
};

/**
 * Sets the number grouping separator
 * @param {String} separator
 * @return {*}
 * @throws {Object}
 */
PMSE.ElementHelper.prototype.setNumberGroupingSeparator = function (separator) {
    if (!(separator === null || (typeof separator === 'string' && separator.length <= 1))) {
        throw new Error("setNumberGroupingSeparator(): The parameter is optional should be a single character or "
            + "null.");
    }
    if (separator === this._decimalSeparator) {
        throw new Error("setNumberGroupingSeparator(): The decimal separatpr must be different from the number grouping "
            + "separator.");
    }
    this._numberGroupingSeparator = separator;
    return this;
};

/**
 * Sets the date format
 * @param {String} dateFormat
 * @return {*}
 */
PMSE.ElementHelper.prototype.setDateFormat = function (dateFormat) {
    this._dateFormat = dateFormat;
    if (this._parent && this._parent._constantPanels && this._parent._constantPanels.date) {
        this._parent._constantPanels.date.getItem("date").setFormat(dateFormat);
    }
    if (this._parent && this._parent._constantPanels && this._parent._constantPanels.datetime) {
        this._parent._constantPanels.datetime.getItem("datetime").setFormat(dateFormat);
    }
    return this;
};

/**
 * Sets the time format
 * @param {String} timeFormat
 * @return {*}
 */
PMSE.ElementHelper.prototype.setTimeFormat = function (timeFormat) {
    this._timeFormat = timeFormat;
    if (this._parent && this._parent._constantPanels && this._parent._constantPanels.datetime) {
        this._parent._constantPanels.datetime.getItem("datetime").setTimeFormat(timeFormat);
    }
    return this;
};

/**
 * Initializes the object with the default values
 * @param {Object} options
 * @private
 */
PMSE.ElementHelper.prototype.initObject = function(options) {
    PMSE.ElementHelper.prototype.initOperators();
    PMSE.ElementHelper.prototype.initComparisonOperators('pmse_Project');

    var defaults = {
        mode: 'ExpressionControl',
        dateFormat: "YYYY-MM-DD",
        timeFormat: "H:i",
        currencies: [],
        decimalSeparator: options.numberGroupingSeparator === "." ? "," : ".",
        numberGroupingSeparator: options.decimalSeparator === "," ? "." : ","
    };

    jQuery.extend(true, defaults, options);

    this._mode = defaults.mode;

    this.setDateFormat(defaults.dateFormat)
        .setTimeFormat(defaults.timeFormat)
        .setDecimalSeparator(defaults.decimalSeparator)
        .setNumberGroupingSeparator(defaults.numberGroupingSeparator)
        .setCurrencies(defaults.currencies);
};

/**
 * Processes the module field evaluation into the proper data format
 * @param {Object} fieldPanel
 * @param {Object} fieldPanelItem
 * @param {Object} data
 * @param {Boolean} related
 * @return {Object}
 */
PMSE.ElementHelper.prototype.moduleFieldEvalGeneration = function(fieldPanel, fieldPanelItem, data, related) {
    var aux, modItem, fieldItem, opItem, valItem, val, valueField, value, valueType, op, label, itemData = {};

    if (related) {
        aux = data.relField.split(this._auxSeparator);
        modItem = 'related';
        fieldItem = 'relField';
        opItem = 'relOperator';
        valItem = 'relValue';
        val = data.relValue;
    } else {
        aux = data.field.split(this._auxSeparator);
        modItem = 'module';
        fieldItem = 'field';
        valItem = 'value';
        opItem = 'operator';
        val = data.value;
    }
    if (aux.length > 1 && (aux[0] != 'null' || aux[1] != 'null')) {
        valueField = fieldPanelItem.getItem(valItem);
        if (aux[1] === 'Currency') {
            value = valueField.getAmount();
        } else if (aux[1] === 'MultiSelect') {
            value = val;
        } else {
            value = this._getStringOrNumber(val);
        }
        valueType = typeof val === 'string' ? typeof value : typeof val;
        op = fieldPanelItem.getItem(opItem).getSelectedText();
        label = fieldPanelItem.getItem(modItem).getSelectedData().module_label + ' (' +
            fieldPanelItem.getItem(fieldItem).getSelectedText() + ' ' +
            op + ' ';
        if (data.rel) {
            label = data.rel + ' ' + label;
        }
        if (op != 'changes') {
            switch (aux[1]) {
                case 'Date':
                case 'Datetime':
                    label += '%VALUE%';
                    break;
                case 'user':
                case 'DropDown':
                    label += valueField.getSelectedText();
                    break;
                case 'Currency':
                    label += valueField.getCurrencyText() + ' %VALUE%';
                    break;
                case 'MultiSelect':
                    label += valueField.getSelectionAsText();
                    break;
                default:
                    label += (valueType === 'string' ? '"' + value + '"' : val);
            }
        }
        label += ')';

        itemData = {
            expType: "MODULE",
            expSubtype: aux[1],
            expLabel: label,
            expValue: value,
            expOperator: related ? data.relOperator : data.operator,
            expModule: related ? data.related : data.module,
            expField: aux[0]
        };
        if (data.rel) {
            itemData.expRel = data.rel;
        }
        if (aux[1] === 'Currency') {
            itemData.expCurrency = valueField.getCurrency();
        }
    }

    return itemData;
};

/**
 * Gets the user facing text label from the data object
 * @param {Object} data
 * @return {String}
 */
PMSE.ElementHelper.prototype.getLabel = function (data) {
    var label, aux, that = this;
    if (data.expType === 'MODULE' || (data.expType === 'CONSTANT'
        && (data.expSubtype === 'date' || data.expSubtype === 'datetime') )) {
        aux = data.expSubtype.toLowerCase();

        label = data.expLabel.replace(new RegExp(this._itemValueWildcard, "g"), function () {
            if (aux === "date") {
                return FormPanelDate.format(data.expValue, that._dateFormat);
            } else if (aux === "datetime") {
                return FormPanelDatetime.format(data.expValue, that._dateFormat, that._timeFormat);
            } else if (aux === 'currency') {
                return FormPanelNumber.format(data.expValue, {
                    precision: 2,
                    groupingSeparator: this._numberGroupingSeparator,
                    decimalSeparator: this._decimalSeparator
                });
            } else {
                return data.expLabel;
            }
        });
    } else {
        label = data.expLabel;
    }

    return label;
};

/**
 * Retrieves the proper data from the backend and populate the field control
 * @param {Object} dependantField
 * @param {Object} field
 * @param {String} value
 * @param {String} name
 */
PMSE.ElementHelper.prototype.loadFieldControl = function(dependantField, field, value, name) {
    var parent = field.getName();
    var module;
    if (parent == 'module') {
        module = PROJECT_MODULE;
    } else {
        var form = dependantField.getForm();
        var moduleField = form.getItem('module');
        module = moduleField.getSelectedData().module_name;
    }
    var type;
    if (name == 'emailAddressField') {
        type = 'ET';
    } else {
        type = 'PD';
    }
    dependantField.setDataURL('pmse_Project/CrmData/fields/' + value)
        .setAttributes({
            base_module: module,
            call_type: type
        })
        .load();
};

/**
 * Handles the dependency change event for the field control
 * @param {Object} dependantField
 * @param {Object} field
 * @param {String} value
 */
PMSE.ElementHelper.prototype.fieldDependencyHandler = function(dependantField, field, value) {
    dependantField.clearOptions();
    var name = dependantField.getName();
    if (this._mode == 'EmailPickerField' && name != 'emailAddressField' &&
        (field._disabled ||
        !value ||
        value == PROJECT_MODULE ||
        field.getSelectedData().type == 'one')) {
        if (!dependantField._disabled) {
            dependantField.disable();
        }
    } else if (name == 'emailAddressField' && field.getName() == 'related' &&
        value === '' && !_.isUndefined(dependantField.getForm().getItem('module').getSelectedData())) {
        // handle edge case when user unselects related module dropdown we want to populate email address
        // field using parent module
        module = PROJECT_MODULE;
        var form = dependantField.getForm();
        var moduleField = form.getItem('module');
        value = moduleField.getSelectedData().module_name;
        field = form.getItem('related');
        if (dependantField._disabled) {
            dependantField.enable();
        }
    } else {
        if (dependantField._disabled) {
            dependantField.enable();
        }
    }
    if (!dependantField._disabled && value) {
        this.loadFieldControl(dependantField, field, value, name);
    }
    dependantField.fireDependentFields();
};

/**
 * Switches the value control type based on the parent field type
 * Populates the operator control with the proper operators
 * @param {Object} dependantField
 * @param {Object} parentField
 * @param {Object} operatorField
 * @param {String} type
 * @param {String} selVal
 * @param {Object} form
 * @return {Object}
 */
PMSE.ElementHelper.prototype.processValueDependency = function (dependantField, parentField, operatorField, type, selVal, form) {
    var labelField = 'textfield',
        newFieldSettings = {
            type: type,
            width: dependantField.width,
            label: dependantField.getLabel(),
            name: dependantField.getName()
        },
        operators = this.OPERATORS.comparison.slice(0, 2),
        setPrecision = true,
        setGrouping = true;
    switch (type) {
        case 'checkbox':
            labelField = 'text';
            break;
        case 'dropdown':
            labelField = 'text';
        case 'multiselect':
        case 'radio':
            var aux = parentField.getSelectedData() ||
                parentField._getFirstAvailableOption(),
                itemsObj = aux.optionItem;
            newFieldSettings.options = [];
            Object.keys(itemsObj).forEach(function(item, index, arr) {
                newFieldSettings.options.push({
                    value: item,
                    label: itemsObj[item]
                });
            });
            break;
        case 'friendlydropdown':
            newFieldSettings.options = [
                {
                    'label': translate('LBL_PMSE_FORM_OPTION_CURRENT_USER'),
                    'value': 'currentuser'
                },
                {
                    'label': translate('LBL_PMSE_FORM_OPTION_RECORD_OWNER'),
                    'value': 'owner'
                },
                {
                    'label': translate('LBL_PMSE_FORM_OPTION_SUPERVISOR'),
                    'value': 'supervisor'
                }
            ];
            newFieldSettings.searchMore = {
                module: 'Users',
                fields: ['id', 'full_name'],
                filterOptions: null
            };
            newFieldSettings.searchValue = PMSE_USER_SEARCH.value;
            newFieldSettings.searchLabel = PMSE_USER_SEARCH.text;
            newFieldSettings.searchURL = PMSE_USER_SEARCH.url;
            break;
        case 'datetime':
            newFieldSettings.timeFormat = this._timeFormat;
        case 'date':
            newFieldSettings.dateFormat = this._dateFormat;
            operators = this.OPERATORS.comparison.slice(0, 6);
            labelField = 'datefield';
            break;
        case 'currency':
            newFieldSettings.currencies = this._currencies;
            newFieldSettings.precision = 2;
            setPrecision = false;
            newFieldSettings.groupingSeparator = this._numberGroupingSeparator;
            setGrouping = false;
        case 'decimal':
        case 'float':
        case 'number':
            if (setPrecision) {
                newFieldSettings.precision = -1;
                setPrecision = false;
            }
        case 'integer':
            labelField = 'text';
            if (setPrecision) {
                newFieldSettings.precision = 0;
            }
            if (setGrouping) {
                newFieldSettings.groupingSeparator = '';
            }
            newFieldSettings.decimalSeparator = this._decimalSeparator;
            operators = this.OPERATORS.comparison.slice(0, 6);
            break;
        case 'text':
            operators = this.OPERATORS.comparison.slice();
            operators.splice(2, 4);
            break;
        default:
    }
    if (this.EXTRA_OPERATORS[labelField]) {
        operators = operators.concat(this.EXTRA_OPERATORS[labelField]);
    }
    if (!selVal) {
        var expControl = (this._parent) ? this._parent : null;
        if (expControl && expControl._name &&
            (expControl._name === 'evn_criteria' || expControl._name === 'pro_terminate_variables')) {
            operators = operators.concat(this.OPERATORS.changes);
        }
    } else if (selVal == 'updated' || selVal == 'allupdates') {
        var url = parentField._dataURL,
            base = parentField._attributes ? parentField._attributes.base_module : false;
        if (url && base && (url.substring(url.length - base.length) === base)) {
            operators = operators.concat(this.OPERATORS.changes);
        }
    }
    operatorField.setLabelField(labelField);
    operatorField.setOptions(operators);
    var newField = form._createField(newFieldSettings);
    form.replaceItem(newField, dependantField);
    newField.setDependencyHandler(dependantField._dependencyHandler);
    return newField;
};

/**
 * Checks whether the value control type needs to be switched
 * @param {Object} dependantField
 * @param {Object} parentField
 * @param {String} value
 * @param {String} parent
 * @return {Object}
 */
PMSE.ElementHelper.prototype.doValueDependency = function (dependantField, parentField, value, parent) {
    var module, operator;
    if (parent == 'field') {
        module = 'module';
        operator = 'operator';
    } else {
        module = 'related';
        operator = 'relOperator';
    }
    var form = dependantField.getForm();
    var operatorField = form.getItem(operator);
    var modVal = form.getItem(module)._value;
    var selVal = $('#evn_params').val();
    var type = value.split(this._auxSeparator)[1];
    type = type && this._typeToControl[type.toLowerCase()];
    if (parent == 'field') {
        if (!type ||
            (type && type !== this._currentType) ||
            type === 'dropdown' ||
            selVal !== this._currentVal ||
            modVal !== this._currentMod) {
            this._currentType = type;
            this._currentVal = selVal;
            this._currentMod = modVal;
            dependantField = this.processValueDependency(dependantField, parentField, operatorField, type, selVal, form);
        }
    } else {
        if (!type ||
            (type && type !== this._currentRelType) ||
            type === 'dropdown' ||
            selVal !== this._currentRelVal ||
            modVal !== this._currentRelMod) {
            this._currentRelType = type;
            this._currentRelVal = selVal;
            this._currentRelMod = modVal;
            dependantField = this.processValueDependency(dependantField, parentField, operatorField, type, selVal, form);
        }
    }
    return {operator: operatorField, value: dependantField};
};

/**
 * Handles the dependency change event for the value control
 * @param {Object} dependantField
 * @param {Object} parentField
 * @param {String} value
 */
PMSE.ElementHelper.prototype.valueDependencyHandler = function (dependantField, parentField, value) {
    var operatorField;
    var parent = parentField.getName();
    if (parent == 'field' || parent == 'relField') {
        var res = this.doValueDependency(dependantField, parentField, value, parent);
        operatorField = res.operator;
        dependantField = res.value;
        if (this._mode == 'EmailPickerField' &&
            parentField._disabled) {
            if (!dependantField._disabled) {
                dependantField.disable();
            }
            if (!operatorField._disabled) {
                operatorField.disable();
            }
        } else {
            if (dependantField._disabled) {
                dependantField.enable();
            }
            if (operatorField._disabled) {
                operatorField.enable();
            }
        }
    } else {
        operatorField = parentField;
    }
    var showValue = (operatorField.getValue() != 'changes');
    dependantField.setVisible(showValue);
};

/**
 * Retrieves the proper data from the backend and populate the related control
 * @param {Object} dependantField
 * @param {Object} field
 */
PMSE.ElementHelper.prototype.loadRelatedControl = function(dependantField, field) {
    var auxProxy = new SugarProxy({
        url: 'pmse_Project/CrmData/related/' + field.getSelectedData().module_name
    });
    auxProxy.getData({'removeTarget': true}, {
        success: function (data) {
            data = data.result;
            data.unshift({value: "", text: "Select..."});
            data = _.filter(data, function (item) {
                if (item.module !== "Users") return item;
            });
            dependantField.setOptions(data);
        }
    });
};

/**
 * Handles the dependency change event for the related control
 * @param {Object} dependantField
 * @param {Object} field
 * @param {String} value
 */
PMSE.ElementHelper.prototype.relatedDependencyHandler = function(dependantField, field, value) {
    dependantField.clearOptions();
    if (this._mode == 'EmailPickerField' &&
        (!value ||
            value == PROJECT_MODULE)) {
        if (!dependantField._disabled) {
            dependantField.disable();
        }
    } else {
        if (dependantField._disabled) {
            dependantField.enable();
        }
    }
    if (!dependantField._disabled && value) {
        this.loadRelatedControl(dependantField, field);
    }
    dependantField.fireDependentFields();
};
