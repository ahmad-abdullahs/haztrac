({
    extendsFrom: 'CompositionField',
    events: {
        'click .removeRecord:not(.disabled)': 'deleteRow',
        'click .addRecord:not(.disabled)': 'addRow',
    },
    fieldIds: [],
    footerFieldIds: [],
    modelFields: {},
    modelFooterFields: {},
    isFirst: true,
    addClass: 'addRecord',
    setFocusEle: '',

    initialize: function (options) {
        this._super('initialize', [options]);
        app.error.errorName2Keys['composition_max_total_should_not_more_than_100_message'] = 'ERROR_MAX_TOTAL_VALIDATION_MESSAGE';
        //add validation tasks
        this.model.addValidationTask('composition_max_total_should_not_more_than_100_message', _.bind(this._doValidateCompositionMaxTotal, this));
        // ++
        this.context.on('render:on-autopopulate:multirow:fields', this.render, this);
        app.events.on('refresh:multi-dd:fields', this.refreshDropdownFields, this);
    },

    refreshDropdownFields: function (data){
        var self = this;
        var fieldName = 'composition_uom';
        this.$('span[sfuuid]').each(function () {
            var sfId = $(this).attr('sfuuid');
            try {
                var fieldToRender = self.view.fields[sfId];
                if(fieldToRender.name.indexOf(fieldName) !== -1 && data[0].def.options == fieldToRender.def.options){
                    fieldToRender.items[data[2]] = data[1];
                    fieldToRender.render();
                }
            } catch (e) {
                console.log("Error occurred", e);
            }
        });
    },

    renderFooterFieldsMetaAndValues: function () {
        var field = this.model.get(this.name) || "[]",
                newRowObj = {
                    'empty_field1': '',
                    'empty_field2': '',
                    'composition_max_total': 0.00,
                    'empty_field2': '',
                };

        // Parse the data and sum the field values.
        var fieldObj = JSON.parse(field);
        _.each(fieldObj, function (rowObj) {
            if (!this.isRowEmpty(rowObj)) {
                if (rowObj['composition_uom'] != 'TCLP') {
                    newRowObj['composition_max_total'] += parseFloat(rowObj['composition_max']) || 0.00;
                    // ++
                    this.model.set('composition_max_total', newRowObj['composition_max_total']);
                }
            }
        }, this);

        this.insertFooterRow(newRowObj);
        this.renderFieldFooterInnerFields();
    },

    recalculateMaxTotal: function (innerFieldName) {
        var field = this.model.get(this.name),
                compositionMaxTotal = 0.00;

        // Parse the data and sum the field values.
        var fieldObj = JSON.parse(field);
        _.each(fieldObj, function (rowObj) {
            if (!this.isRowEmpty(rowObj)) {
                if (rowObj['composition_uom'] != 'TCLP') {
                    compositionMaxTotal += parseFloat(rowObj['composition_max']) || 0.00;
                }
            }
        }, this);

        if (!_.isEmpty(this.footerFieldIds)) {
            this.model.set('composition_max_total__' + this.footerFieldIds[0], compositionMaxTotal);
            // ++
            this.model.set('composition_max_total', compositionMaxTotal);
        }

        $.when(this.renderFieldFooterInnerFields()).then(function () {
            if (!_.isEmpty(innerFieldName)) {
                $('[name=' + innerFieldName + ']').parents('div:first').next().find('input').focus();
            }
        });
    },
})