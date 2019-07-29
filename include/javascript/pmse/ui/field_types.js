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
/*global PMSE.Field, $, document, PMSE.Element*/
var PMSE = PMSE || {};
/**
 * @class TextField
 * Handle text input fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var TextField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
    /**
     * Defines the maximum number of characters supported
     * @type {Number}
     */
    this.maxCharacters = null;
    TextField.prototype.initObject.call(this, options);
};
TextField.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
TextField.prototype.type = 'TextField';

/**
 * Initializes the object with the default values
 * @param {Object} options
 */
TextField.prototype.initObject = function (options) {
    var defaults = {
        maxCharacters: 0,
        value: "",
        initialValue: ""
    };
    $.extend(true, defaults, options);
    this.setMaxCharacters(defaults.maxCharacters)
        .setInitialValue(defaults.initialValue)
        .setValue(defaults.value);
};

/**
 * Sets the maximun characters property
 * @param {Number} value
 * @return {*}
 */
TextField.prototype.setMaxCharacters = function (value) {
    this.maxCharacters = value;
    return this;
};

/**
 * Creates the basic html node structure for the given object using its
 * previously defined properties
 * @return {HTMLElement}
 */
TextField.prototype.createHTML = function () {
    var fieldLabel, textInput, required = '', readAtt;
    PMSE.Field.prototype.createHTML.call(this);

    if (this.required) {
        required = '<i>*</i> ';
    }

    fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ': ' + required;
    fieldLabel.style.width = this.parent.labelWidth;
    this.html.appendChild(fieldLabel);

    textInput = this.createHTMLElement('input');
    textInput.type = "text";
    textInput.id = this.name;
    textInput.value = this.value || "";
    if (this.fieldWidth) {
        textInput.style.width = this.fieldWidth;
    }
    if (this.readOnly) {
        readAtt = document.createAttribute('readonly');
        textInput.setAttributeNode(readAtt);
    }
    this.html.appendChild(textInput);

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }
    this.labelObject = fieldLabel;
    this.controlObject = textInput;

    return this.html;
};

/**
 * Attaches event listeners to the text field , it also call some methods to set and evaluate
 * the current value (to send it to the database later).
 *
 * The events attached to this field are:
 *
 * - {@link TextField#event-change Change Input field event}
 * - {@link TextField#event-keydown key down event into an input field}
 *
 * @chainable
 */
TextField.prototype.attachListeners = function () {
    var self = this;
    if (this.controlObject) {
        $(this.controlObject)
            .change(function () {
                self.setValue(this.value, true);
                self.onChange();
            })
            .keydown(function (e) {
                e.stopPropagation();
            });
    }
    return this;
};

var FilterField = function(options, parent) {
    PMSE.Field.call(this, options, parent);
    this.selectField = null;
    this.selectOperator = null;
    this.valueElements = [];
    this.options = [];
    this.operators = [];
    this._type = null;
    this.module = null;
    this.value = null;
    FilterField.prototype.initObject.call(this, options);
};
FilterField.prototype = new PMSE.Field();
FilterField.prototype.type = 'FilterField';
FilterField.prototype.initObject = function(options) {
    var defaults = {
        options: []
    };
    $.extend(true, defaults, options);
    this.initOperators('pmse_Project');
};
FilterField.prototype._typeToControl = {
    address: 'text',
    checkbox: 'checkbox',
    currency: 'currency',
    date: 'date',
    datetime: 'datetime', //
    decimal: 'number',
    encrypt: 'text',
    dropdown: 'dropdown',
    float: 'number',
    email: 'text',
    name: 'text',
    htmleditable_tinymce: 'text',
    tinyint: 'integer',
    //html: 'html',
    //iframe: 'iframe',
    //image: 'image' ,
    integer: 'integer',
    multiselect: 'multiselect',
    //flex relate: 'flexrelate',
    phone: 'text',
    radio: 'radio',
    //relate: 'related',
    textarea: 'text',//'textarea',
    url: 'text',
    textfield: 'text',
    user: 'friendlydropdown'
};
FilterField.prototype.initOperators = function(module) {
    this.operators = [
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
            value: 'starts_with'
        },
        {
            textfield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_ENDS_TEXT', module),
            value: 'ends_with'
        },
        {
            textfield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_CONTAINS_TEXT', module),
            value: 'contains'
        },
        {
            textfield: App.lang.get('LBL_PMSE_EXPCONTROL_OPERATOR_NOT_CONTAINS_TEXT', module),
            value: 'does_not_contain'
        }
    ];
};
FilterField.prototype.createHTML = function() {
    PMSE.Field.prototype.createHTML.call(this);

    var disableAtt;
    if (this.readOnly) {
        disableAtt = document.createAttribute('disabled');
    }

    var required = '';

    if (this.required) {
        required = '<i>*</i> ';
    }

    this.dateFormat = App.date.getUserDateFormat();
    this.timeFormat = App.user.getPreference('timepref');

    var fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ': ' + required;
    fieldLabel.style.width = this.parent.labelWidth;
    this.html.appendChild(fieldLabel);

    this.selectField = this.createHTMLElement('select');
    this.selectField.id = this.name + '_field';
    this.selectField.style.width = '20%';
    this.selectField.className = 'adam-filterfield-selectors';

    if (this.readOnly) {
        this.selectField.setAttributeNode(disableAtt);
    }
    this.html.appendChild(this.selectField);

    this.selectOperator = this.createHTMLElement('select');
    this.selectOperator.id = this.name + '_operator';
    this.selectOperator.style.width = '20%';
    this.selectOperator.className = 'adam-filterfield-selectors';

    if (this.readOnly) {
        this.selectOperator.setAttributeNode(disableAtt);
    }
    this.html.appendChild(this.selectOperator);

    this.createValueElements({type: 'text'});

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }
    this.labelObject = fieldLabel;

    if (this.disabled) {
        this.disable();
    } else if (!this.readOnly) {
        this.enable();
    }

    return this.html;
};
FilterField.prototype.removeOptions = function(select) {
    while (select.firstChild) {
        select.removeChild(select.firstChild);
    }
    return this;
};
FilterField.prototype.setOptions = function(data) {
    this.options = data;
    if (this.html) {
        this.removeOptions(this.selectField);
        var first = {value: '', text: 'Select...'};
        this.selectField.appendChild(this.generateOption('expField', first, 'text'));
        for (var i = 0; i < this.options.length; i++) {
            this.selectField.appendChild(this.generateOption('expField', this.options[i], 'text'));
        }
    }
    return this;
};
FilterField.prototype.setOperators = function(data, labelField) {
    if (this.html) {
        this.removeOptions(this.selectOperator);
        for (var i = 0; i < data.length; i++) {
            this.selectOperator.appendChild(this.generateOption('expOperator', data[i], labelField));
        }
    }
    return this;
};
FilterField.prototype.generateOption = function(type, item, labelField) {
    var value;
    var text;
    var out = this.createHTMLElement('option');
    if (typeof item === 'object') {
        value = item.value;
        switch (labelField) {
            case 'textfield':
                text = item.textfield;
                break;
            case 'datefield':
                text = item.datefield;
                break;
            case 'label':
                text = item.label;
                break;
            default:
                text = item.text;
        }
    } else {
        value = item;
    }
    out.selected = this.value ? this.value[type] === value : false;
    out.value = value;
    out.label = text || value;
    out.appendChild(document.createTextNode(out.label));
    return out;
};
FilterField.prototype.getSelectedData = function(value) {
    for (var i = 0; i < this.options.length; i++) {
        if (this.options[i].value === value) {
            return cloneObject(this.options[i]);
        }
    }
    return null;
};
FilterField.prototype.attachListeners = function() {
    var self = this;
    if (this.selectField) {
        $(this.selectField).change(function() {
            self.value = null;
            FilterField.prototype.onFieldChange.call(self);
        });
    }
    return this;
};
FilterField.prototype.onFieldChange = function() {
    var type = this.getSelectedData(this.selectField.value);
    if (type) {
        type = this._typeToControl[type.type.toLowerCase()];
    }
    this.processValueDependency(type);
};
FilterField.prototype.processValueDependency = function(type) {
    var labelField = 'textfield';
    var settings = {type: 'text'};
    var operators = [];
    if (type) {
        var setPrecision = setGrouping = true;
        settings = {
            type: type
        };
        operators = this.operators.slice(0, 2);
        switch (type) {
            case 'checkbox':
                labelField = 'text';
                break;
            case 'dropdown':
                labelField = 'text';
            case 'multiselect':
            case 'radio':
                var aux = this.getSelectedData(this.selectField.value);
                var itemsObj = aux.optionItem;
                settings.options = [];
                Object.keys(itemsObj).forEach(function(item, index, arr) {
                    settings.options.push({
                        value: item,
                        label: itemsObj[item]
                    });
                });
                break;
            case 'friendlydropdown':
                settings.options = [
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
                settings.searchMore = {
                    module: 'Users',
                    fields: ['id', 'full_name'],
                    filterOptions: null
                };
                settings.searchValue = PMSE_USER_SEARCH.value;
                settings.searchLabel = PMSE_USER_SEARCH.text;
                settings.searchURL = PMSE_USER_SEARCH.url;
                break;
            case 'datetime':
                settings.timeFormat = this.timeFormat;
            case 'date':
                settings.dateFormat = this.dateFormat;
                operators = this.operators.slice(0, 6);
                labelField = 'datefield';
                break;
            case 'currency':
                var currencies = project ? project.getMetadata('currencies') : [];
                settings.options = [];
                for (var i = 0; i < currencies.length; i++) {
                    settings.options.push({
                        'label': currencies[i].symbol + ' (' + currencies[i].iso + ')',
                        'value': currencies[i].id
                    });
                }
                settings.decimalSeparator = App.user.getPreference('decimal_separator');
                settings.groupingSeparator = App.user.getPreference('number_grouping_separator');
                settings.precision = 2;
                operators = this.operators.slice(0, 6);
                labelField = 'text';
                break;
            case 'decimal':
            case 'float':
            case 'number':
                settings.precision = App.user.getPreference('decimal_precision');
            case 'integer':
                settings.precision = settings.precision || 0;
                settings.decimalSeparator = App.user.getPreference('decimal_separator');
                labelField = 'text';
                operators = this.operators.slice(0, 6);
                break;
            case 'text':
                operators = this.operators.slice();
                operators.splice(2, 4);
                break;
            default:
        }
    }
    this.setOperators(operators, labelField);
    this.swapValueElement(settings);
    if (this.value && this.value.expValue) {
        if (type === 'currency') {
            this.setValueElementsCurrency(this.value.expCurrency);
            this.setValueElementsValue(App.utils.formatNumber(this.value.expValue, settings.precision,
                settings.precision, settings.groupingSeparator, settings.decimalSeparator));
        } else {
            this.setValueElementsValue(this.value.expValue);
        }
    }
};
FilterField.prototype.swapValueElement = function(settings) {
    this.removeValueElements();
    this.createValueElements(settings);
};
FilterField.prototype.removeValueElements = function() {
    if (this.html) {
        for (var i = 0; i < this.valueElements.length; i++) {
            this.html.removeChild(this.valueElements[i]);
        }
    }
    this.valueElements = [];
};
FilterField.prototype.createValueElements = function(settings) {
    var valueElement = this.createHTMLElement('input');
    valueElement.className = 'adam-filterfield-input';

    switch (settings.type) {
        case 'datetime':
            settings.showTimePicker = true;
        case 'date':
            valueElement = this.createDateElement(settings);
            break;
        case 'checkbox':
            valueElement.type = 'checkbox';
            break;
        case 'dropdown':
        case 'radio':
            valueElement = this.createDropdownValueElement(settings);
            break;
        case 'currency':
            valueElement = this.createCurrencyValueElement(settings);
            break;
        case 'friendlydropdown':
            valueElement = this.createFriendlyDropdownValueElement(settings);
            break;
        case 'decimal':
        case 'float':
        case 'number':
        case 'integer':
            valueElement = this.createNumberValueElement(settings);
            break;
        case 'text':
        default:
            valueElement.type = 'text';
    }
    valueElement.id = this.name + '_value';
    valueElement.style.width = '25%';
    if (this.readOnly) {
        valueElement.setAttributeNode(document.createAttribute('disabled'));
    }
    this.valueElements.push(valueElement);
    if (this.html) {
        for (var i = 0; i < this.valueElements.length; i++) {
            if (this.selectField && this.selectField.disabled === true) {
                this.valueElements[i].disabled = true;
            }
            this.html.appendChild(this.valueElements[i]);
        }
    }
    this._type = settings.type;
};
FilterField.prototype.selectedFieldOption = function(html, options) {
    var option = jQuery(html).find('option:selected')[0].text;
    var optionType = null;
    for (var i = 0; i < options.length; i++) {
        if (option && options[i].text === option && options[i].type) {
            optionType = options[i].type;
        }
    }
    return optionType;
};
FilterField.prototype.setFilterFieldDisable = function(filterField, value) {
    if (filterField.labelObject) {
        filterField.labelObject.className = value ? 'adam-form-label-disabled' : 'adam-form-label';
    }
    if (filterField.selectField) {
        filterField.selectField.disabled = value;
    }
    if (filterField.selectOperator) {
        filterField.selectOperator.disabled = value;
    }
    if (filterField.valueElements[0]) {
        filterField.valueElements[0].disabled = value;
    }
};
/**
 * Creates a date element
 * @param settings
 * @return {HTMLElement}
 */
FilterField.prototype.createDateElement = function(settings) {
    var valueElement = this.createHTMLElement('span');
    valueElement.id = this.id;
    valueElement.className = 'adam form-panel-item';
    valueElement.className += ' adam form-panel-field record-cell';
    valueElement.className += ' adam-' + settings.type.toLowerCase();

    var dateInput = this.createPicker('55%');
    dateInput.className += ' adam-filterfield-' + settings.type.toLowerCase();

    $(dateInput).datepicker({format: this.dateFormat.toLowerCase()});

    valueElement.appendChild(dateInput);

    if (settings.showTimePicker) {
        var timeInput = this.createPicker('40%');
        timeInput.className += ' adam-filterfield-' + settings.type.toLowerCase();
        $(timeInput).timepicker({timeFormat: this.timeFormat});
        $(timeInput).blur(function() {
            $(timeInput).timepicker('hide');
        });
        valueElement.appendChild(timeInput);
    }

    $(valueElement).click(function() {
        jQuery(valueElement[0]).datepicker('show');
        jQuery(valueElement[1]).timepicker('show');
    });
    return valueElement;
};

/**
 * Create a date or time picker
 * @param width
 * @return {HTMLElement}
 */
FilterField.prototype.createPicker = function(width) {
    var picker = this.createHTMLElement('input');
    picker.className = 'inherit-width adam form-panel-field-control';
    picker.style.width = width;
    return picker;
};
/**
 * Formats a date
 * @param value
 * @param format
 * @return formatted value or null
 */
FilterField.prototype.dateFormatter = function(value, format) {
    if (!value) {
        return value;
    }
    value = App.date(value);
    return value.isValid() ? value.format(format) : null;
};
FilterField.prototype.createDropdownValueElement = function(settings) {
    var valueElement = this.createHTMLElement('div');
    valueElement.id = this.id;
    valueElement.value = '';
    valueElement.label = '';
    if (settings && settings.options && settings.options[0]) {
        if (typeof settings.options[0].value !== 'undefined') {
            valueElement.value = settings.options[0].value;
        }
        if (typeof settings.options[0].label !== 'undefined') {
            valueElement.label = settings.options[0].label;
        }
    }
    valueElement.className = 'adam form-panel-field';

    var select = this.createHTMLElement('select');
    select.className = 'inherit-width adam form-panel-field-control';
    select.className += ' adam-filterfield-' + settings.type.toLowerCase();

    for (var i = 0; i < settings.options.length; i++) {
        select.appendChild(this.generateOption('expValue', settings.options[i], 'label'));
    }
    valueElement.appendChild(select);
    $(valueElement).change(function() {
        var option = jQuery(this).find('option:selected')[0];
        if (option && typeof option.value !== 'undefined') {
            this.value = option.value;
        }
        if (option && typeof option.label !== 'undefined') {
            this.label = option.label;
        }
    });
    return valueElement;
};
FilterField.prototype.createCurrencyValueElement = function(settings) {
    var valueElement = this.createHTMLElement('div');
    valueElement.className = 'adam form-panel-field';
    valueElement.className += ' adam-filterfield-' + settings.type.toLowerCase();
    valueElement.appendChild(this.createCurrencyValueCurrencySelector(settings));
    valueElement.appendChild(this.createCurrencyValueAmountSelector(settings));
    return valueElement;
};
FilterField.prototype.createCurrencyValueCurrencySelector = function(settings) {
    var currencyControl = this.createHTMLElement('select');
    currencyControl.className = 'inherit-width adam form-panel-field-control';
    currencyControl.className += ' adam-filterfield-' + settings.type.toLowerCase();
    for (var i = 0; i < settings.options.length; i++) {
        var option = this.createHTMLElement('option');
        option.text = settings.options[i].label;
        option.value = settings.options[i].value;
        currencyControl.appendChild(option);
    }
    currencyControl.style.width = '41%';
    return currencyControl;
};
FilterField.prototype.createCurrencyValueAmountSelector = function(settings) {
    var amountControl = this.createHTMLElement('input');
    amountControl.className = 'adam adam-filterfield-currency-value';
    amountControl.type = 'text';
    amountControl.value = '0.00';

    // Can't use FormPanelCurrency, so copy the behavior of its value field
    // Only allow numbers to be entered, and format the value to {settings.precision} decimal places
    var onKeyDown = function(e) {
        return function(e) {
            var number;
            var printableKey = '';

            // If key is non-numeric, do not process it (unless its left arrow, right arrow, backspace, delete, or tab)
            if ((e.keyCode < 48 || (e.keyCode > 57 && e.keyCode < 96) || e.keyCode > 105) &&
                e.keyCode !== 37 && e.keyCode !== 39 && e.keyCode !== 8 && e.keyCode !== 46 && e.keyCode !== 9) {
                e.preventDefault();
                return;
            }

            // If key is a number, process it
            if ((e.keyCode > 47 && e.keyCode < 58) || e.keyCode === 8) {
                printableKey = String.fromCharCode(e.keyCode);
                e.preventDefault();
            }

            // If the key is a backspace, delete the last number (cent value)
            if (e.keyCode === 8) {
                this.value = this.value.slice(0, -1);
            }

            number = parseInt(this.value.replace(/[^0-9]/g, '') + printableKey, 10) / Math.pow(10, settings.precision);
            number = isNaN(number) ? 0 : number;
            this.value = App.utils.formatNumber(number, settings.precision, settings.precision,
                settings.groupingSeparator, settings.decimalSeparator);
        };
    };
    $(amountControl).on('keydown', onKeyDown());
    return amountControl;
};
FilterField.prototype.createNumberValueElement = function(settings) {
    var valueElement = this.createHTMLElement('input');
    valueElement.className = 'adam adam-filterfield-number';
    valueElement.type = 'text';

    // Only allow numbers, left, right, backspace, delete, and tab
    // Numbers are entered/deleted from right to left, as elsewhere in AWF
    // Automatically format value in real time to the given precision
    var onKeyDown = function(e) {
        return function(e) {
            var number;
            var printableKey = '';

            if ((e.keyCode < 48 || (e.keyCode > 57 && e.keyCode < 96) || e.keyCode > 105) &&
                e.keyCode !== 37 && e.keyCode !== 39 && e.keyCode !== 8 && e.keyCode !== 46 && e.keyCode !== 9) {
                e.preventDefault();
                return;
            }

            if ((e.keyCode > 47 && e.keyCode < 58) || e.keyCode === 8) {
                printableKey = String.fromCharCode(e.keyCode);
                e.preventDefault();
            }

            if (e.keyCode === 8) {
                this.value = this.value.slice(0, -1);
            }

            number = parseInt(this.value.replace(/[^0-9]/g, '') + printableKey, 10) / Math.pow(10, settings.precision);
            number = isNaN(number) ? 0 : number;
            this.value = App.utils.formatNumber(number, settings.precision, settings.precision,
                '', settings.decimalSeparator);
        };
    };

    $(valueElement).on('keydown', onKeyDown());
    return valueElement;
};
FilterField.prototype.createFriendlyDropdownValueElement = function(settings) {
    var defaults = {
        placeholder: '',
        searchURL: null,
        searchLabel: 'text',
        searchValue: 'value',
        searchDelay: 1500,
        searchMore: false,
        pageSize: 5
    };
    var valueElement;
    var htmlLabelContainer;
    var span;
    var input;
    var control;

    this._searchURL = null;
    this._searchValue = null;
    this._searchLabel = null;
    this._searchMoreList = null;
    this._pageSize = null;
    this._valueOptions = null;
    this._finalData = null;

    valueElement = this.createHTMLElement('div');
    valueElement.id = this.id;
    valueElement.className = 'adam form-panel-field';
    valueElement.className += ' adam-' + settings.type.toLowerCase();
    $.extend(true, defaults, settings);
    this._pageSize = typeof defaults.pageSize === 'number' &&
        defaults.pageSize >= 1 ? Math.floor(defaults.pageSize) : 0;
    this._htmlControl = [];
    this._searchValue = defaults.searchValue;
    this._searchLabel = defaults.searchLabel;
    this.friendlyDropdownSetSearchURL(defaults.searchURL);

    this._valueOptions = settings.options;

    if (!this._htmlControl[0]) {
        input = this.createHTMLElement('input');
        input.name = this._name;
        this._htmlControl[0] = $(input);
        this._htmlControl[0].select2({
            placeholder: this._placeholder,
            query: this.friendlyDropdownQueryFunction(),
            initSelection: this.friendlyDropdownInitSelection(),
            width: '100%',
            formatNoMatches: function(term) {
                return (term && (term !== '')) ? translate('LBL_PA_FORM_COMBO_NO_MATCHES_FOUND') : '';
            }
        });
        control = this._htmlControl[0].data('select2').container[0];
        control.className += ' inherit-width adam form-panel-field-control';
        valueElement.appendChild(control);
        valueElement.appendChild(this._htmlControl[0].get(0));
    }

    this._searchMore = defaults.searchMore;
    if (this._htmlControl[0]) {
        this.friendlyDropdownCreateSearchMoreOption();
        this._searchMoreList.style.display = '';
    }
    $(this._searchMoreList).on('click', this.friendlyDropdownOpenSearchMore());

    return valueElement;
};
FilterField.prototype.friendlyDropdownCreateSearchMoreOption = function() {
    var dropdownHTML;
    var additionalList;
    var listItem;
    var tpl;
    if (!this._searchMoreList && this._htmlControl[0]) {
        dropdownHTML = this._htmlControl[0].data('select2').dropdown;
        additionalList = this.createHTMLElement('ul');
        additionalList.className = 'select2-results adam-searchmore-list';
        listItem = this.createHTMLElement('li');
        tpl = this.createHTMLElement('div');
        tpl.className = 'select2-result-label';
        tpl.appendChild(document.createTextNode(translate('LBL_SEARCH_AND_SELECT_ELLIPSIS')));
        listItem.appendChild(tpl);
        additionalList.appendChild(listItem);
        dropdownHTML.append(additionalList);
        this._searchMoreList = additionalList;
    }
    return this;
};
FilterField.prototype.friendlyDropdownQueryFunction = function() {
    var self = this;
    return function(queryObject) {
        var finalData = [];
        if (queryObject.term) {
            self._searchFunction(queryObject);
        } else {
            if ($(self._htmlControl[0]).select2('dropdown').find('.select2-result-selectable').length == 0) {
                self._valueOptions.forEach(function(item) {
                    finalData.push({
                        id: item.value,
                        text: item.label
                    });
                });
            }
            queryObject.callback({
                more: false,
                results: finalData
            });
        }
    };
};
FilterField.prototype.friendlyDropdownInitSelection = function() {
    var self = this;
    return function($el, callback) {
        var options = self._valueOptions;
        var value = (self.value && self.value.expValue) ? self.value.expValue : '';
        var text = (self.value && self.value.expLabel) ? self.value.expLabel : '';
        for (var i = 0; i < options.length; i += 1) {
            if (options[i][value] === value) {
                callback({
                    id: options[i].value,
                    text: options[i].label
                });
                return;
            }
        }
        callback({
            id: value,
            text: text || value
        });
    };
};
FilterField.prototype.friendlyDropdownResizeListSize = function() {
    var list = this._htmlControl[0].data('select2').dropdown;
    var listItemHeight;
    list = $(list).find('ul[role=listbox]');
    listItemHeight = list.find('li').eq(0).outerHeight();
    list.get(0).style.maxHeight = (listItemHeight * this._pageSize) + 'px';
    return this;
};
FilterField.prototype.friendlyDropdownSetSearchURL = function(url) {
    var delayToUse;
    var self = this;
    if (!(typeof url === 'string' || url === null)) {
        throw new Error('friendlyDropdownSetSearchURL(): The parameter must be a string or null.');
    }
    if (url !== null && (!this._searchLabel || !this._searchValue)) {
        throw new Error('friendlyDropdownSetSearchURL(): You can\'t set the Suggestions URL ' +
            'if the Suggestions Label or Suggestions Value are set to null.');
    }
    this._searchURL = url;
    delayToUse = url ? this._searchDelay : 0;

    this._searchFunction = _.debounce(function(queryObject) {
        var proxy = new SugarProxy();
        var result = {
                more: false
            };
        var term = jQuery.trim(queryObject.term);
        var finalData = [];
        var getText = function(obj, criteria) {
                if (typeof criteria === 'function') {
                    return criteria(obj);
                } else {
                    return obj[criteria];
                }
            };
        var options = self._valueOptions;
        if (queryObject.page == 1) {
            options.forEach(function(item) {
                if (!term || queryObject.matcher(term, item.label)) {
                    finalData.push({
                        id: item.value,
                        text: item.label
                    });
                }
            });
        }
        if (term && self._searchURL) {
            proxy.url = this._searchURL.replace(/\{%TERM%\}/g, queryObject.term)
                .replace(/\{%OFFSET%\}/g, (queryObject.page - 1) * self._pageSize);
            if (self._pageSize > 0) {
                proxy.url = proxy.url.replace(/\{%PAGESIZE%\}/g, self._pageSize);
            }
            proxy.getData(null, {
                success: function(data) {
                    result.more = data.next_offset >= 0 ? true : false;
                    data = data.records;
                    data.forEach(function(item) {
                        finalData.push({
                            id: getText(item, self._searchValue),
                            text: getText(item, self._searchLabel)
                        });
                    });
                    self._finalData = finalData;
                    result.results = finalData;
                    queryObject.callback(result);
                    self.friendlyDropdownResizeListSize();
                },
                error: function() {
                    console.log('failure', arguments);
                }
            });
        } else {
            result.results = finalData;
            queryObject.callback(result);
        }
    }, delayToUse);

    return this;
};
FilterField.prototype.friendlyDropdownOpenSearchMore = function() {
    var self = this;

    return function() {
        self._htmlControl[0].select2('close');
        $(self.html).closest('.adam-modal').hide();
        App.drawer.open({
                layout: 'selection-list',
                context: self._searchMore
            },
            _.bind(function(drawerValues) {
                var oldValue = (self.value && self.value.expValue) ? self.value.expValue : '';
                $(self.html).closest('.adam-modal').show();
                if (!_.isUndefined(drawerValues)) {
                    self.friendlyDropdownSetValue({text: drawerValues.value, value: drawerValues.id}, true);
                    self.processValueDependency('friendlydropdown');
                }
            }, this)
        );
    };
};
FilterField.prototype.friendlyDropdownSetValue = function(value) {
    var theText = null;
    if (value && typeof value === 'object') {
        theText = value.text;
        value = value.value;
    }
    if (this._htmlControl[0]) {
        if (this.value) {
            this.value.expLabel = theText;
            this.value.expValue = value;
        } else {
            var objectValue = this.getObjectValue();
            if (objectValue && objectValue.act_field_filter && objectValue.act_field_filter.filter) {
                this.value = objectValue.act_field_filter.filter;
                this.value.expLabel = theText;
                this.value.expValue = value;
            } else if (objectValue && objectValue.act_field_filter_related &&
                objectValue.act_field_filter_related.filter) {
                this.value = objectValue.act_field_filter_related.filter;
                this.value.expLabel = theText;
                this.value.expValue = value;
            }
        }
    } else {
        this.value = value;
    }
    return this;
};
FilterField.prototype.friendlyDropdownGetValues = function() {
    var expValue;
    var expLabel;
    var currentLabel;
    if (this.valueElements && this.valueElements[0] && this.valueElements[0].innerText) {
        currentLabel = this.valueElements[0].innerText.trim();
    }
    if (this._finalData) {
        for (var i = 0; i < this._finalData.length; i++) {
            if (this._finalData[i] && this._finalData[i].id &&
                this._finalData[i].text && this._finalData[i].text === currentLabel) {
                expLabel = this._finalData[i].text;
                expValue = this._finalData[i].id;
            }
        }
        this._finalData = null;
    } else if (this.value && this.value.expValue &&
        this.value.expLabel && this.value.expLabel === currentLabel) {
        expLabel = this.value.expLabel;
        expValue = this.value.expValue;
    } else {
        for (var i = 0; i < this._valueOptions.length; i++) {
            if (this._valueOptions[i] && this._valueOptions[i].label &&
                this._valueOptions[i].label === currentLabel) {
                expLabel = this._valueOptions[i].label;
                expValue = this._valueOptions[i].value;
            }
        }
    }
    return [expValue, expLabel];
};
FilterField.prototype.getValueElementsValue = function() {
    var value = null;
    if (this.valueElements.length > 0) {
        switch (this._type) {
            case 'date':
                value = this.getDateValue();
                break;
            case 'datetime':
                value = this.getDateTimeValue();
                break;
            case 'checkbox':
                value = this.valueElements[0].checked;
                break;
            case 'currency':
                value = this.valueElements[0].children[1].value.replace(/,/g, '');
                break;
            case 'dropdown':
            case 'radio':
            case 'decimal':
            case 'float':
            case 'number':
            case 'integer':
            case 'friendlydropdown':
            case 'text':
            default:
                value = this.valueElements[0].value;
        }
    }
    return value;
};

FilterField.prototype.getValueElementsCurrency = function() {
    if (this.valueElements.length > 0 && this._type === 'currency') {
        return this.valueElements[0].children[0].value;
    }
};

/**
 * Gets the date value
 * @return string or null
 */
FilterField.prototype.getDateValue = function() {
    var date = App.date(this.valueElements[0].children[0].value, this.dateFormat, true);
    var value = date.isValid() ? date.formatServer(true) : null;
    return value;
};

/**
 * Gets date and time value
 * @return string or null
 */
FilterField.prototype.getDateTimeValue = function() {
    var date = this.valueElements[0].children[0].value;
    var time = this.valueElements[0].children[1].value;
    var datetime = SUGAR.App.date(date + '' + time, this.dateFormat + '' +
        SUGAR.App.date.convertFormat(this.timeFormat), true);

    var value = datetime.isValid() ? datetime.formatServer() : null;
    return value;
};

FilterField.prototype.setValueElementsValue = function(value) {
    if (this.valueElements.length > 0) {
        switch (this._type) {
            case 'date':
                this.valueElements[0].children[0].value = this.dateFormatter(value, this.dateFormat);
                break;
            case 'datetime':
                this.valueElements[0].children[0].value = this.dateFormatter(value, this.dateFormat);
                this.setTimeValue(value);
                break;
            case 'checkbox':
                this.valueElements[0].checked = value;
                break;
            case 'currency':
                this.valueElements[0].children[1].value = value;
                break;
            case 'dropdown':
            case 'radio':
            case 'decimal':
            case 'float':
            case 'number':
            case 'integer':
            case 'friendlydropdown':
            case 'text':
            default:
                this.valueElements[0].value = value;
        }
    }
};

FilterField.prototype.setValueElementsCurrency = function(value) {
    if (this.valueElements.length > 0 && this._type === 'currency') {
        this.valueElements[0].children[0].value = value;
    }
};

/**
 * Sets the value of time field
 * @param value
 */
FilterField.prototype.setTimeValue = function(value) {
    var datetime = value.split('T');
    var time = datetime[1].split(/[\+\-]/);
    jQuery(this.valueElements[0].children[1]).timepicker('setTime', time[0]);
};

FilterField.prototype.setModule = function(module, base) {
    this.module = module;
    if (module) {
        var self = this;
        this.proxy.url = 'pmse_Project/CrmData/fields/' + module;
        this.proxy.getData({call_type: 'PD', base_module: base}, {
            success: function(data) {
                App.alert.dismiss('upload');
                if (data) {
                    self.setOptions(data.result);
                    self.onFieldChange();
                }
            }
        });
    } else {
        App.alert.dismiss('upload');
        this.setOptions([]);
        this.onFieldChange();
    }
};
FilterField.prototype.getObjectValue = function() {
    var value = {};
    var data = this.getSelectedData(this.selectField.value);
    var expValue;
    var expLabel;
    if (this._type === 'friendlydropdown') {
        var values = this.friendlyDropdownGetValues();
        if (values && values[0] && values[1]) {
            expValue = values[0];
            expLabel = values[1];
        }
    } else {
        expValue = this.getValueElementsValue();
        expLabel = this.valueElements[0].label ? this.valueElements[0].label : expValue;
    }
    if (data && this.submit) {
        value[this.name] = {
            module: this.module,
            filter: {
                expType: 'MODULE',
                expSubtype: data.type,
                expLabel: expLabel,
                expValue: expValue,
                expOperator: this.selectOperator.value,
                expModule: this.module,
                expField: this.selectField.value
            }
        };
        if (data.type === 'Currency') {
            value[this.name].filter.expCurrency = this.getValueElementsCurrency();
        }
    }
    return value;
};
FilterField.prototype.setObjectValue = function(value) {
    this.value = value;
};

/**
 * @class ComboboxField
 * Handles drop down fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var ComboboxField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
    /**
     * Defines the combobox options
     * @type {Array}
     */
    this.options = [];
    this.related = null;
    this._isValid = true;
    ComboboxField.prototype.initObject.call(this, options);
};
ComboboxField.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
ComboboxField.prototype.type = 'ComboboxField';

/**
 * Initializes the object with default values
 * @param {Object} options
 */
ComboboxField.prototype.initObject = function (options) {
    var defaults = {
        options: [],
        related: null,
        isValid: true
    };
    $.extend(true, defaults, options);
    this.setOptions(defaults.options)
        .setRelated(defaults.related)
        .setValid(defaults.isValid);
};

/**
 * Sets the combo box options
 * @param {Array} data
 * @return {*}
 */
ComboboxField.prototype.setOptions = function (data) {
    var i;
    this.options = data;
    if (this.html) {
        for (i = 0; i < this.options.length; i += 1) {
            this.controlObject.appendChild(this.generateOption(this.options[i]));
        }

        //if (!this.value) {
            this.value = this.controlObject.value;
        //}
    }
    return this;

};

/**
 * Adds a single option to the dropdown
 * @param data
 * @return {ComboboxField}
 */
ComboboxField.prototype.addOption = function(data) {
    if ((this.html) && (data)) {
        this.controlObject.appendChild(this.generateOption(data));
    }
    if (!this.value) {
        this.value = this.controlObject.value;
    }
    return this;
};

ComboboxField.prototype.setRelated = function (data) {
    this.related = data;
    return this;
};

/**
 * Creates the basic html node structure for the given object using its
 * previously defined properties
 * @return {HTMLElement}
 */
ComboboxField.prototype.createHTML = function () {
    var fieldLabel, selectInput, required = '', opt, i, disableAtt;
    PMSE.Field.prototype.createHTML.call(this);

    if (this.required) {
        required = '<i>*</i> ';
    }

    fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ': ' + required;
    fieldLabel.style.width = this.parent.labelWidth;
    this.html.appendChild(fieldLabel);

    selectInput = this.createHTMLElement('select');
    selectInput.id = this.name;
    for (i = 0; i < this.options.length; i += 1) {
        selectInput.appendChild(this.generateOption(this.options[i]));
    }
    if (!this.value) {
        this.value = selectInput.value;
    }
    if (this.fieldWidth) {
        selectInput.style.width = this.fieldWidth;
    }
    if (this.readOnly) {
        disableAtt = document.createAttribute('disabled');
        selectInput.setAttributeNode(disableAtt);
    }
    this.html.appendChild(selectInput);

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }
    this.labelObject = fieldLabel;
    this.controlObject = selectInput;

    if (this.disabled) {
        this.disable();
    } else if (!this.readOnly) {
        this.enable();
    }

    return this.html;
};

ComboboxField.prototype.removeOptions = function () {
    if (this.options) {
        while (this.controlObject.firstChild) {
            this.controlObject.removeChild(this.controlObject.firstChild);
        }
        this.options = [];
    }
    return this;
};


ComboboxField.prototype.generateOption = function (item) {
    var out, selected = '', value, text;
    out = this.createHTMLElement('option');
    if (typeof item === 'object') {
        value = item.value;
        text = item.text;
    } else {
        value = item;
    }
    out.selected = this.value === value;
    out.value = value;
    out.label = text || value;
    out.appendChild(document.createTextNode(text || value));
    return out;
};

/**
 * Returns the data associated to the current selected value.
 * @return {Object|null}
 */
ComboboxField.prototype.getSelectedData = function () {
    return _.find(this.options, function (item) {
        return item.value == this.value;
    }, this) || null;
};

/**
 * Attaches event listeners to the combo box field , it also call some methods to set and evaluate
 * the current value (to send it to the database later).
 *
 * The events attached to this field are:
 *
 * - {@link TextField#event-change Change Input field event}
 *
 * @chainable
 */
ComboboxField.prototype.attachListeners = function () {
    var self = this;
    if (this.controlObject) {
        $(this.controlObject)
            .change(function (e) {
                var oldValue = self.value;
                self.setValue(this.value, true);
                self.onChange(this.value, oldValue);
            });
    }
    return this;
};

ComboboxField.prototype.isValid = function() {
    return this._isValid;
};

ComboboxField.prototype.setValid = function(valid) {
    this._isValid = valid ? true : false;
    this.decorateValid();
    return this;
};

ComboboxField.prototype.decorateValid = function() {
    $(this.controlObject).toggleClass(this._invalidFieldClass, !this.isValid());
};

/**
 * @class TextareaField
 * Handles TextArea fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var TextareaField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
    this.fieldHeight = null;
    TextareaField.prototype.initObject.call(this, options);
};
TextareaField.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
TextareaField.prototype.type = "TextareaField";

TextareaField.prototype.initObject = function (options) {
    var defaults = {
        fieldHeight: null,
        value: "",
        initialValue: ""
    };
    $.extend(true, defaults, options);
    this.setFieldHeight(defaults.fieldHeight)
        .setInitialValue(defaults.initialValue)
        .setValue(defaults.value);
};

TextareaField.prototype.setFieldHeight = function (height) {
    this.fieldHeight = height;
    return this;
};

/**
 * Creates the basic html node structure for the given object using its
 * previously defined properties
 * @return {HTMLElement}
 */
TextareaField.prototype.createHTML = function () {
    var fieldLabel, textInput, required = '', readAtt;
    PMSE.Field.prototype.createHTML.call(this);

    if (this.required) {
        required = '<i>*</i> ';
    }

    fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ': ' + required;
    fieldLabel.style.width = this.parent.labelWidth;
    fieldLabel.style.verticalAlign = 'top';
    this.html.appendChild(fieldLabel);

    textInput = this.createHTMLElement('textarea');
    textInput.id = this.name;
    textInput.value = this.value;
    if (this.fieldWidth) {
        textInput.style.width = this.fieldWidth;
    }
    if (this.fieldHeight) {
        textInput.style.height = this.fieldHeight;
    }
    if (this.readOnly) {
        readAtt = document.createAttribute('readonly');
        textInput.setAttributeNode(readAtt);
    }
    this.html.appendChild(textInput);

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }

    this.controlObject = textInput;
    this.labelObject = fieldLabel;

    if (this.disabled) {
        this.disable();
    } else {
        this.enable();
    }

    return this.html;
};

/**
 * Attaches event listeners to the text area , it also call some methods to set and evaluate
 * the current value (to send it to the database later).
 *
 * The events attached to this field are:
 *
 * - {@link TextareaField#event-change Change Input field event}
 * - {@link TextareaField#event-keydown key down event into an input field}
 *
 * @chainable
 */

TextareaField.prototype.attachListeners = function () {
    var self = this;
    if (this.controlObject) {
        $(this.controlObject)
            .change(function () {
                self.setValue(this.value, true);
                self.onChange();
            })
            .keydown(function (e) {
                e.stopPropagation();
            });
    }
    return this;
};
//

/**
 * @class CheckboxField
 * Handles the checkbox fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var CheckboxField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
    this.defaults = {
        //options: {},
        onClick: function (e, ui) {}
    };
    $.extend(true, this.defaults, options);
};

CheckboxField.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
CheckboxField.prototype.type = 'CheckboxField';

/**
 * Creates the HTML Element of the field
 */
CheckboxField.prototype.createHTML = function () {
    var fieldLabel, textInput, required = '', readAtt;
    PMSE.Field.prototype.createHTML.call(this);

    if (this.required) {
        required = '<i>*</i> ';
    }

    fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ': ' + required;
    fieldLabel.style.width = this.parent.labelWidth;
//    fieldLabel.style.verticalAlign = 'top';
    this.html.appendChild(fieldLabel);

    textInput = this.createHTMLElement('input');
    textInput.id = this.name;
    textInput.type = 'checkbox';
    if (this.value) {
        textInput.checked = true;
    } else {
        textInput.checked = false;
    }
    if (this.readOnly) {
        readAtt = document.createAttribute('readonly');
        textInput.setAttributeNode(readAtt);
    }
    this.html.appendChild(textInput);

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }
    this.labelObject = fieldLabel;
    this.controlObject = textInput;

    if (this.disabled) {
        this.disable();
    } else {
        this.enable();
    }

    return this.html;
};

/**
 * Attaches event listeners to checkbox field , it also call some methods to set and evaluate
 * the current value (to send it to the database later).
 *
 * The events attached to this field are:
 *
 * - {@link CheckboxField#event-onClick on click mouse event}
 * - {@link CheckboxField#event-change Change Input field event}
 * - {@link CheckboxField#event-keydown key down event into an input field}
 *
 * @chainable
 */
CheckboxField.prototype.attachListeners = function () {
    var self = this;
    if (this.controlObject) {
        if (typeof this.defaults.onClick !== 'undefined' && typeof this.defaults.onClick === 'function') {
            $(this.controlObject).on('click', function (e, ui) {return self.defaults.onClick(); });
        }

        $(this.controlObject)
            .change(function (a, b) {
                var val;
                if (this.checked) {
                    val = true;
                } else {
                    val = false;
                }
                self.setValue(val, true);
                self.onChange();
            });
    }
    return this;
};

CheckboxField.prototype.getObjectValue = function () {
    var response = {};
    if (this.value) {
        response[this.name] = true;
    } else {
        response[this.name] = false;
    }
    return response;
};

CheckboxField.prototype.evalRequired = function () {
    var response = true;
    if (this.required) {
        response = this.value;
        this.markFieldError(!response);
    }
    return response;
};
/**
 * @class RadiobuttonField
 * Handles the radio button fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var RadiobuttonField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
    this.defaults = {
        options: {},
        onClick: function (e, ui) {}
    };
    $.extend(true, this.defaults, options);
    //RadiobuttonField.prototype.initObject.call(this, options);
};
RadiobuttonField.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
RadiobuttonField.prototype.type = 'RadiobuttonField';

/**
 * Creates the basic html node structure for the given object using its
 * previously defined properties
 * @return {HTMLElement}
 */
RadiobuttonField.prototype.createHTML = function () {
    var fieldLabel, textInput, required = '', readAtt;
    PMSE.Field.prototype.createHTML.call(this);

    if (this.required) {
        required = '<i>*</i> ';
    }
//    console.log(this.defaults);
    fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';

    textInput = this.createHTMLElement('input');
    textInput.name = this.name;
    textInput.type = 'radio';
    textInput.value = this.value;

    if (typeof (this.defaults.labelAlign) === 'undefined' ||
            this.defaults.labelAlign === 'left') {
        fieldLabel.style.width = this.parent.labelWidth;
        fieldLabel.innerHTML = this.label + ': ' + required;
        fieldLabel.style.verticalAlign = 'top';
        fieldLabel.style.width = this.parent.labelWidth;
        this.html.appendChild(fieldLabel);
        this.html.appendChild(textInput);
    } else if (this.defaults.labelAlign === 'right') {
        fieldLabel.innerHTML = '&nbsp;' + this.label + required;
        textInput.style.marginLeft = (this.defaults.marginLeft) ? this.defaults.marginLeft + 'px' : '0px';
        fieldLabel.style.width = this.parent.labelWidth;
        this.html.appendChild(textInput);
        this.html.appendChild(fieldLabel);
    }

    if (this.value) {
        textInput.checked = true;
    } else {
        textInput.checked = false;
    }

    if (this.readOnly) {
        readAtt = document.createAttribute('readonly');
        textInput.setAttributeNode(readAtt);
    }

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }

    this.controlObject = textInput;
    this.labelObject = fieldLabel;

    if (this.disabled) {
        this.disable();
    } else {
        this.enable();
    }

    return this.html;
};

/**
 * Attaches event listeners to radio field , it also call some methods to set and evaluate
 * the current value (to send it to the database later).
 *
 * The events attached to this field are:
 *
 * - {@link RadiobuttonField#event-onClick on click mouse event}
 * - {@link RadiobuttonField#event-change Change Input field event}
 *
 * @chainable
 */
RadiobuttonField.prototype.attachListeners = function () {
    var self = this;
    if (this.controlObject) {
        if (typeof this.defaults.onClick !== 'undefined' && typeof this.defaults.onClick === 'function') {
            $(this.controlObject).on('click', function (e, ui) {return self.defaults.onClick(); });
        }
        $(this.controlObject)
            .change(function (a, b) {
                self.onChange();
            });
//        $(this.controlObject)
//            .change(function (a, b) {
//                var val;
//                if (this.checked) {
//                    val = true;
//                } else {
//                    val = false;
//                }
//                self.setValue(val, true);
//                self.onChange();
//            });
    }
    return this;
};

RadiobuttonField.prototype.getObjectValue = function () {
    return this.value;
};

RadiobuttonField.prototype.evalRequired = function () {
    var response = true;
    if (this.required) {
        response = this.value;
        this.markFieldError(!response);
    }
    return response;
};

RadiobuttonField.prototype._setValueToControl = function (value) {
    if (this.html && this.controlObject) {
        this.controlObject.checked = this.value;
    }
    return this;
};

/**
 * @class LabelField
 * Handles the Label fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var LabelField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
    this.submit = false;
    this.defaults = {
        options: {
            marginLeft : 10
        }
    };
    $.extend(true, this.defaults, options);
};
LabelField.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
LabelField.prototype.type = 'LabelField';

/**
 * Creates the basic html node structure for the given object using its
 * previously defined properties
 * @return {HTMLElement}
 */
LabelField.prototype.createHTML = function () {
    var fieldLabel;
    PMSE.Field.prototype.createHTML.call(this);

    fieldLabel = this.createHTMLElement('span');
//    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ':';
    fieldLabel.style.verticalAlign = 'top';
    fieldLabel.style.marginLeft = this.defaults.options.marginLeft + 'px';
    this.html.appendChild(fieldLabel);

    return this.html;
};

/**
 * @class HiddenField
 * Handle the hidden fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var HiddenField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
};
HiddenField.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
HiddenField.prototype.type = 'HiddenField';

/**
 * Creates the basic html node structure for the given object using its
 * previously defined properties
 * @return {HTMLElement}
 */
HiddenField.prototype.createHTML = function () {
    PMSE.Element.prototype.createHTML.call(this);
    return this.html;
};

//

var EmailGroupField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
};

EmailGroupField.prototype = new PMSE.Field();

EmailGroupField.prototype.type = 'EmailGroupField';

/**
 * @class DateField
 * Handle text input fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var DateField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
    /**
     * Defines the maximum number of characters supported
     * @type {Number}
     */
    this.maxCharacters = null;
    DateField.prototype.initObject.call(this, options);
};
DateField.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
DateField.prototype.type = 'TextField';

/**
 * Initializes the object with the default values
 * @param {Object} options
 */
DateField.prototype.initObject = function (options) {
    var defaults = {
        maxCharacters: 0
    };
    $.extend(true, defaults, options);
    this.setMaxCharacters(defaults.maxCharacters);
};

/**
 * Sets the maximun characters property
 * @param {Number} value
 * @return {*}
 */
DateField.prototype.setMaxCharacters = function (value) {
    this.maxCharacters = value;
    return this;
};

/**
 * Creates the basic html node structure for the given object using its
 * previously defined properties
 * @return {HTMLElement}
 */
DateField.prototype.createHTML = function () {
    var fieldLabel, textInput, required = '', readAtt;
    PMSE.Field.prototype.createHTML.call(this);

    if (this.required) {
        required = '<i>*</i> ';
    }

    fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ': ' + required;
    fieldLabel.style.width = this.parent.labelWidth;
    this.html.appendChild(fieldLabel);

    textInput = this.createHTMLElement('input');
    textInput.id = this.name;
    textInput.value = this.value || "";
    $(textInput).datepicker();
    if (this.fieldWidth) {
        textInput.style.width = this.fieldWidth;
    }
    if (this.readOnly) {
        readAtt = document.createAttribute('readonly');
        textInput.setAttributeNode(readAtt);
    }
    this.html.appendChild(textInput);

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }
    this.labelObject = fieldLabel;
    this.controlObject = textInput;

    if (this.disabled) {
        this.disable();
    } else {
        this.enable();
    }

    return this.html;
};

/**
 * Attaches event listeners to date field , it also call some methods to set and evaluate
 * the current value (to send it to the database later).
 *
 * The events attached to this field are:
 *
 * - {@link TextareaField#event-change Change Input field event}
 * - {@link TextareaField#event-keydown key down event into an input field}
 *
 * @chainable
 */
DateField.prototype.attachListeners = function () {
    var self = this;
    if (this.controlObject) {
        $(this.controlObject)
            .change(function () {
                self.setValue(this.value, true);
                self.onChange();
            })
            .keydown(function (e) {
                e.stopPropagation();
            });
    }
    return this;
};
DateField.prototype.disable = function () {
    PMSE.Field.prototype.disable.call(this);
    $(this.controlObject).datepicker('hide');
    return this;
};

/**
 * @class NumberField
 * Handle text input fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var NumberField = function (options, parent) {
    PMSE.Field.call(this, options, parent);
    /**
     * Defines the maximum number of characters supported
     * @type {Number}
     */
    this.maxCharacters = null;
    NumberField.prototype.initObject.call(this, options);
};
NumberField.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
NumberField.prototype.type = 'TextField';

/**
 * Initializes the object with the default values
 * @param {Object} options
 */
NumberField.prototype.initObject = function (options) {
    var defaults = {
        maxCharacters: 0
    };
    $.extend(true, defaults, options);
    this.setMaxCharacters(defaults.maxCharacters);
};

/**
 * Sets the maximun characters property
 * @param {Number} value
 * @return {*}
 */
NumberField.prototype.setMaxCharacters = function (value) {
    this.maxCharacters = value;
    return this;
};

/**
 * Creates the basic html node structure for the given object using its
 * previously defined properties
 * @return {HTMLElement}
 */
NumberField.prototype.createHTML = function () {
    var fieldLabel, textInput, required = '', readAtt;
    PMSE.Field.prototype.createHTML.call(this);

    if (this.required) {
        required = '<i>*</i> ';
    }

    fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ': ' + required;
    fieldLabel.style.width = this.parent.labelWidth;
    this.html.appendChild(fieldLabel);

    textInput = this.createHTMLElement('input');
    textInput.id = this.name;
    textInput.value = this.value || "";
    if (this.fieldWidth) {
        textInput.style.width = this.fieldWidth;
    }
    if (this.readOnly) {
        readAtt = document.createAttribute('readonly');
        textInput.setAttributeNode(readAtt);
    }
    this.html.appendChild(textInput);

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }
    this.labelObject = fieldLabel;
    this.controlObject = textInput;

    if (this.disabled) {
        this.disable();
    } else {
        this.enable();
    }

    return this.html;
};

/**
 * Attaches event listeners to the text field , it also call some methods to set and evaluate
 * the current value (to send it to the database later).
 *
 * The events attached to this field are:
 *
 * - {@link TextField#event-change Change Input field event}
 * - {@link TextField#event-keydown key down event into an input field}
 *
 * @chainable
 */
NumberField.prototype.attachListeners = function () {
    var self = this;
    if (this.controlObject) {
        $(this.controlObject)
            .change(function () {
                self.setValue(this.value, true);
                self.onChange();
            });
    }
    return this;
};

/**
 * Validates a number field
 * @return {boolean}
 */
NumberField.prototype.isValid = function() {
    // Start with a true return
    var valid = true;
    // If this field is required, check whether it is numeric
    if (this.required && !$.isNumeric(this.value)) {
        // If not, mark it invalid and mark a field error
        valid = false;
        this.markFieldError(!valid);
    }
    return valid;
};

/**
 * @class CheckboxGroup
 * Handles the checkbox fields
 * @extends PMSE.Field
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 * @param {PMSE.Form} parent
 */
var CheckboxGroup = function (options, parent) {
    PMSE.Field.call(this, options, parent);
//    this.defaults = {
//        options: {},
//        onClick: function (e, ui) {}
//    };
//    $.extend(true, this.defaults, options);
    this.controlObject = {};
    CheckboxGroup.prototype.initObject.call(this, options);
};

CheckboxGroup.prototype = new PMSE.Field();

/**
 * Defines the object's type
 * @type {String}
 */
CheckboxGroup.prototype.type = 'CheckboxGroup';

/**
 * Initializes the object with the default values
 * @param {Object} options
 */
CheckboxGroup.prototype.initObject = function (options) {
    var defaults = {
        items: []
    };
    $.extend(true, defaults, options);
    //this.setMaxCharacters(defaults.maxCharacters);
    this.items = defaults.items;
};

/**
 * Creates the HTML Element of the field
 */
CheckboxGroup.prototype.createHTML = function () {
    var fieldLabel, input, required = '', readAtt, div, i, text, ul, li, root = this, object;
    //this.controlObject.control = [];
    PMSE.Field.prototype.createHTML.call(this);

    if (this.required) {
        required = '<i>*</i> ';
    }
    div = this.createHTMLElement('div');
    div.style.display = 'inline-block';
    div.style.width = "30%";
    div.style.verticalAlign = 'top';
    fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ': ' + required + '&nbsp;&nbsp;&nbsp;&nbsp;';
    fieldLabel.style.width = this.parent.labelWidth;
//    fieldLabel.style.verticalAlign = 'top';
    div.appendChild(fieldLabel);
    this.html.appendChild(div);


    div = this.createHTMLElement('div');
    div.style.display = 'inline-block';
    div.style.width = "40%";
    ul =  this.createHTMLElement('ul');

    for (i = 0; i < this.items.length; i += 1) {
        li = this.createHTMLElement('li');
        li.style.listStyleType = 'none';
        input = this.createHTMLElement('input');
        input.id = this.items[i].value;
        input.type = 'checkbox';
        if (this.items[i].checked) {
            input.checked = true;
        } else {
            input.checked = false;
        }
        if (this.readOnly) {
            readAtt = document.createAttribute('readonly');
            input.setAttributeNode(readAtt);
        }
        li.appendChild(input);

        object = {'control': input};
        if (this.items[i].checked) {
            object.checked = true;
        }
        this.controlObject[this.items[i].value] = object;
//        <label for="male">Male</label>
        text = document.createElement("Label");
        text.innerHTML = ' &nbsp;&nbsp;' + this.items[i].text;
        li.appendChild(text);

        ul.appendChild(li);

        $(input).change(function () {
            if (this.checked) {
                //control.checked = true;
                root.controlObject[$(this).attr('id')].checked = true;
            } else {
                //control.checked = false;
                root.controlObject[$(this).attr('id')].checked = false;
            }
        });
    }
    div.appendChild(ul);
    this.html.appendChild(div);

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }
    this.labelObject = fieldLabel;

    if (this.disabled) {
        this.disable();
    } else {
        this.enable();
    }

    return this.html;
};

/**
 * Attaches event listeners to checkbox field , it also call some methods to set and evaluate
 * the current value (to send it to the database later).
 *
 * The events attached to this field are:
 *
 * - {@link CheckboxField#event-onClick on click mouse event}
 * - {@link CheckboxField#event-change Change Input field event}
 * - {@link CheckboxField#event-keydown key down event into an input field}
 *
 * @chainable
 */
CheckboxGroup.prototype.attachListeners = function () {
    var self = this, i, control;
//    if (this.controlObject) {
//        if (typeof this.defaults.onClick !== 'undefined' && typeof this.defaults.onClick === 'function') {
//            $(this.controlObject).on('click', function (e, ui) {return self.defaults.onClick(); });
//        }
//
//        $(this.controlObject)
//            .change(function (a, b) {
//                var val;
//                if (this.checked) {
//                    val = true;
//                } else {
//                    val = false;
//                }
//                self.setValue(val, true);
//                self.onChange();
//            });
//    }
//    for (i = 0; i < this.controlObject.length; i += 1) {
//    }
    return this;
};

CheckboxGroup.prototype.getObjectValue = function () {
    var response = {}, i, control, array = [];
    $.each(this.controlObject, function (key, value) {
        //console.log(key);
        if (value.checked) {
            array.push(key);
        }
    });

    response[this.name] = array;
    return response;
};

CheckboxGroup.prototype.evalRequired = function () { var response = true;
    if (this.required) {
        response = this.value;
        this.markFieldError(!response);
    }
    return response;
};

var SearchableCombobox = function (options, parent) {
    PMSE.Field.call(this, options, parent);
    this._placeholder = null;
    this._pageSize = null;
    this._valueField = null;
    this._textField = null;
    this._options = [];
    this._searchURL = null;
    this._searchValue = null;
    this._searchLabel = null;
    this._searchFunction = null;
    this._searchDelay = null;
    this._searchMore = null;
    this._searchMoreList = null;
    this._isValid = true;
    SearchableCombobox.prototype.initObject.call(this, options, parent);
};

SearchableCombobox.prototype = new PMSE.Field();
SearchableCombobox.prototype.constructor = SearchableCombobox;
SearchableCombobox.prototype.type = "SearchableCombobox";

SearchableCombobox.prototype.initObject = function (options, parent) {
    var defaults = {
        placeholder: "",
        pageSize: 5,
        textField: "text",
        valueField: "value",
        fieldWidth: "200px",
        options: [],
        searchURL: null,
        searchLabel: "text",
        searchValue: "value",
        searchDelay: 1500,
        searchMore: false,
        isValid: true
    };

    $.extend(true, defaults, options);

    this._placeholder = defaults.placeholder;
    this._textField = defaults.textField;
    this._valueField = defaults.valueField;
    this._pageSize = typeof defaults.pageSize === 'number' && defaults.pageSize >= 1 ? Math.floor(defaults.pageSize) : 0;
    this.setFieldWidth(defaults.fieldWidth)
        .setSearchDelay(defaults.searchDelay)
        .setSearchValue(defaults.searchValue)
        .setSearchLabel(defaults.searchLabel)
        .setSearchURL(defaults.searchURL)
        .setOptions(defaults.options)
        .setValid(defaults.isValid);

    if (defaults.searchMore) {
        this.enableSearchMore(defaults.searchMore);
    } else {
        this.disableSearchMore();
    }
};

SearchableCombobox.prototype.isValid = function() {
    return this.disabled || this._isValid;
};

SearchableCombobox.prototype.setValid = function(valid) {
    this._isValid = valid ? true : false;
    this.decorateValid();
    return this;
};

SearchableCombobox.prototype.decorateValid = function() {
    $(this.controlObject).toggleClass(this._invalidFieldClass, !this.isValid());
};

SearchableCombobox.prototype._createSearchMoreOption = function () {
    var dropdownHTML, additionalList, listItem, tpl;
    if (this.controlObject && ! this._searchMoreList) {
        dropdownHTML = this.controlObject.data("select2").dropdown;
        additionalList = this.createHTMLElement('ul');
        additionalList.className = 'select2-results adam-searchmore-list';
        listItem = this.createHTMLElement('li');
        tpl = this.createHTMLElement('div');
        tpl.className = 'select2-result-label';
        tpl.appendChild(document.createTextNode(translate('LBL_SEARCH_AND_SELECT_ELLIPSIS')));
        listItem.appendChild(tpl);
        additionalList.appendChild(listItem);
        dropdownHTML.append(additionalList);
        this._searchMoreList = additionalList;
    }
    return this;
};

SearchableCombobox.prototype.enableSearchMore = function (options) {
    if (typeof options !== 'object') {
        throw new Error("enableSearchMore(): The parameter must be an object.");
    }
    this._searchMore = options;
    if (this.controlObject) {
        this._createSearchMoreOption();
        this._searchMoreList.style.display = '';
    }
    return this;
};

SearchableCombobox.prototype.disableSearchMore = function () {
    this._searchMore = false;
    if (this.controlObject) {
        this._createSearchMoreOption();
        this._searchMoreList.style.display = 'none';
    }
    return this;
};

SearchableCombobox.prototype.setSearchDelay = function (delay) {
    if (typeof delay !== 'number') {
        throw new Error("setSearchDelay(): The parameter must be a number.");
    }

    this._searchDelay = delay;

    return this;
};

SearchableCombobox.prototype.setSearchValue = function(value) {
    if (!(typeof value === 'string' || typeof value === 'function' || value === null)) {
        throw new Error("setSearchValue(): The parameter must be a string or a function or null.");
    }
    this._searchValue = value;
    return this;
};

SearchableCombobox.prototype.setSearchLabel = function(label) {
    if (!(typeof label === 'string' || typeof label === 'function' || label === null)) {
        throw new Error("setSearchLabel(): The parameter must be a string or a function or null.")
    }
    this._searchLabel = label;
    return this;
};

SearchableCombobox.prototype._getFilteredOptions = function (queryObject, items, textField, valueField) {
    var finalData = [],
        term = jQuery.trim(queryObject.term);

    items.forEach(function(item, index, arr) {
        if (!term || queryObject.matcher(term, item[textField])) {
            finalData.push({
                id: item[valueField],
                text: item[textField]
            });
        }
    });

    return finalData;
};

SearchableCombobox.prototype._resizeListSize = function () {
    var list = this.controlObject.data("select2").dropdown,
        listItemHeight;
    list = $(list).find('ul[role=listbox]');
    listItemHeight = list.find('li').eq(0).outerHeight();
    list.get(0).style.maxHeight = (listItemHeight * this._pageSize) + 'px';
    return this;
};

SearchableCombobox.prototype.setSearchURL = function(url) {
    var delayToUse, that = this;

    if (!(typeof url === 'string' || url === null)) {
        throw new Error("setSearchURL(): The parameter must be a string or null.");
    }
    if (url !== null && (!this._searchLabel || !this._searchValue)) {
        throw new Error("setSearchURL(): You can't set the Suggestions URL if the Suggestions Label or "
        + "Suggestions Value are set to null.");
    }
    this._searchURL = url;

    delayToUse = url ? this._searchDelay : 0;

    this._searchFunction = _.debounce(function(queryObject) {
        var proxy = new SugarProxy(),
            result = {
                more: false
            }, term = jQuery.trim(queryObject.term),
            finalData,
            getText = function(obj, criteria) {
                if (typeof criteria === 'function') {
                    return criteria(obj);
                } else {
                    return obj[criteria];
                }
            };

        finalData = queryObject.page > 1 ? [] : that._getFilteredOptions(queryObject, that._options, 'text', 'id');

        if (term && that._searchURL) {
            proxy.url = this._searchURL.replace(/\{%TERM%\}/g, queryObject.term)
                .replace(/\{%OFFSET%\}/g, (queryObject.page - 1) * that._pageSize);

            if (that._pageSize > 0) {
                proxy.url = proxy.url.replace(/\{%PAGESIZE%\}/g, that._pageSize);
            }

            proxy.getData(null, {
                success: function (data) {
                    result.more = data.next_offset >= 0 ? true : false;
                    data = data.records;
                    data.forEach(function (item) {
                        finalData.push({
                            id: getText(item, that._searchValue),
                            text: getText(item, that._searchLabel)
                        });
                    });

                    result.results = finalData;
                    queryObject.callback(result);
                    that._resizeListSize();
                },
                error: function () {
                    console.log("failure", arguments);
                }
            });
        } else {
            result.results = finalData;
            queryObject.callback(result);
        }
    }, delayToUse);

    return this;
};

SearchableCombobox.prototype.setOptions = function (options) {
    var that = this;
    if (!$.isArray(options)) {
        throw new Error("setOptions(): The parameter must be an array.");
    }

    this._options = [];

    options.forEach(function(item, index, arr) {
        that._options.push({
            id: item.value,
            text: item.text
        });
    });
    return this;
};

SearchableCombobox.prototype._setValueToControl = function (value) {
    if (this.html && this.controlObject) {
        this.controlObject.select2("val", value);
    }
    return this;
};

SearchableCombobox.prototype.setValue = function (value, change) {
    var theValue, theText;

    if (value && typeof value === 'object') {
        theText = value[this._textField];
        value = value[this._valueField];
    }

    theValue = change ? value : value || this.initialValue;

    if (this.controlObject) {
        this.controlObject.data("text", theText);
        this.controlObject.select2("val", theValue, false);
        this.value = this.controlObject.select2("val");
    } else {
        this.value = theValue;
    }
    return this;
};

SearchableCombobox.prototype.setReadOnly = function (value) {
    this.readOnly = value;
    if (this.html) {
        this.controlObject.select2("readonly", value);
    }
    return this;
};

SearchableCombobox.prototype.disable = function () {
    if (this.controlObject) {
        this.labelObject.className = 'adam-form-label-disabled';
        this.controlObject.select2("disable");
    }
    if (!this.oldRequiredValue) {
        this.oldRequiredValue = this.required;
    }
    this.setRequired(false);
    this.disabled = true;
    this.decorateValid();
    return this;
};

SearchableCombobox.prototype.enable = function () {
    if (this.controlObject) {
        this.labelObject.className = 'adam-form-label';
        this.controlObject.select2("enable");
    }
    if (this.oldRequiredValue) {
        this.setRequired(this.oldRequiredValue);
    }
    this.disabled = false;
    this.decorateValid();
    return this;
};

SearchableCombobox.prototype._queryFunction = function () {
    var that = this;
    return function (queryObject) {
        var result = {
            more: false
        }, finalData;
        if (jQuery.trim(queryObject.term)) {
            that._searchFunction(queryObject);
        } else {
            finalData = that._getFilteredOptions(queryObject, that._options, 'text', 'id');
            result.results = finalData;
            queryObject.callback(result);
        }
    };
};

SearchableCombobox.prototype._initSelection = function () {
    var that = this;
    return function ($el, callback) {
        var value = $el.val(), i, text = $el.data("text");
        for (i = 0; i < that._options.length; i += 1) {
            if (that._options[i]["id"] === value) {
                callback({
                    id: that._options[i]["id"],
                    text: that._options[i]["text"]
                });
                return;
            }
        }
        callback({
            id: value,
            text: text || value
        });
    };
};

SearchableCombobox.prototype.getSelectedText = function () {
    var data = {};

    if (this.controlObject) {
        data = $(this.controlObject).select2("data");
    }
    return data.text || "";
};

SearchableCombobox.prototype._openSearchMore = function() {
    var self = this;
    var zIndex = $(self.html).closest('.adam-modal').css('zIndex');

    return function () {
        self.controlObject.select2('close');
        $(self.html).closest('.adam-modal').css('zIndex', -1);
        App.drawer.open({
                layout: 'selection-list',
                context: self._searchMore
            },
            _.bind(function (drawerValues) {
                $(self.html).closest('.adam-modal').css('zIndex', zIndex);
                if (!_.isUndefined(drawerValues)) {
                    self.setValue({text: drawerValues.value, value: drawerValues.id}, true);
                    self.onChange();
                }
        }, this));
    };
};

SearchableCombobox.prototype.attachListeners = function () {
    var that = this;
    if (this.controlObject) {
        $(this._searchMoreList).find('li').on('mousedown', this._openSearchMore());
        this.controlObject.on("change", function () {
            that.value = that.controlObject.select2("val");
            that.onChange();
        });
    }
    return this;
};

SearchableCombobox.prototype.createHTML = function () {
    var fieldLabel, textInput, required = '', readAtt;
    PMSE.Field.prototype.createHTML.call(this);

    if (this.required) {
        required = '<i>*</i> ';
    }

    fieldLabel = this.createHTMLElement('span');
    fieldLabel.className = 'adam-form-label';
    fieldLabel.innerHTML = this.label + ': ' + required;
    fieldLabel.style.width = this.parent.labelWidth;
    this.html.appendChild(fieldLabel);

    textInput = this.createHTMLElement('input');
    textInput.type = "text";
    textInput.id = this.name;
    this.controlObject = $(textInput);
    this.controlObject.select2({
        placeholder: this._placeholder,
        query: this._queryFunction(),
        initSelection: this._initSelection(),
        width: this.fieldWidth || "200px",
        formatNoMatches: function (term) {
            return (term && (term !== '')) ? translate('LBL_PA_FORM_COMBO_NO_MATCHES_FOUND') : '';
        }
    });
    if (this._searchMore) {
        this.enableSearchMore(this._searchMore);
    } else {
        this.disableSearchMore();
    }
    this.controlObject.select2("val", this.value, false);
    if (this.readOnly) {
        this.setReadOnly(true);
    }
    this.html.appendChild(this.controlObject.data("select2").container[0]);
    this.html.appendChild(textInput);

    if (this.helpTooltip) {
        this.html.appendChild(this.helpTooltip.getHTML());
    }
    this.labelObject = fieldLabel;

    if (this.disabled) {
        this.disable();
    } else {
        this.enable();
    }

    return this.html;
};
