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
    extendsFrom: 'RowactionField',

    events: {
        'click .print-status': 'rowActionSelect',
    },

    printStatusMap: {
        'Pending': {
            color: 'red',
            iconName: 'fa-clock-o',
            titleVal: 'Pending',
            labelVal: 'Pending',
        },
        'Queued': {
            color: 'yellow',
            iconName: 'fa-random',
            titleVal: 'Queued',
            labelVal: 'Queued',
        },
        'Printed': {
            color: 'green',
            iconName: 'fa-print',
            titleVal: 'Printed',
            labelVal: 'Printed',
        },
    },

    printStatusVal: {},

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    rowActionSelect: function (evt) {
        if (this.module == 'sales_and_services') {
            this.model.trigger('pullUpPrintPaperWorkDrawer');
        }
    },

    _render: function () {
        this._super('_render');
    },

    format: function () {
        if (!this.model.id)
            return;

        if (this.model.get('print_status_c') || this.model.get('print_status')) {
            var printStatus = this.model.get('print_status_c') || this.model.get('print_status');
            var printDate = this.model.get('print_date');
            if (!_.isUndefined(this.printStatusMap[printStatus])) {
                this.printStatusVal = this.printStatusMap[printStatus];
                if (printStatus == "Printed" && printDate) {
                    var temp = _.clone(this.printStatusMap[printStatus]);
                    temp.labelVal = temp.labelVal + ' on (' + moment.utc(printDate).format('MM/DD/YYYY') + ')';
                    temp.titleVal = temp.labelVal;
                    this.printStatusVal = temp;
                }
            }
        }

        return this.printStatusVal;
    },
})