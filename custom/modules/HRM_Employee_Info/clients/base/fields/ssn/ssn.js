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
({
    extendsFrom: 'BaseField',
    originalValue: '',
    events: {
        'click .ssn-preview': 'toggleDiv',
    },

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    format: function (value) {
        if (_.isNull(value) || _.isUndefined(value)) {
            return value;
        }

        this.originalValue = value;

        if (this.tplName == "detail" && this.action == "detail") {
            if (!value.toString().includes('xxx-xx-')) {
                var pieces = value.split('-');
                if (pieces[2]) {
                    return 'xxx-xx-' + pieces[2];
                }
            }
        }

        return value;
    },

    toggleDiv: function (ele) {
        $('#ssn-full-text').toggle();
    },
})
