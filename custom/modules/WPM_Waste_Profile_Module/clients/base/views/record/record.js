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
    extendsFrom: 'RecordView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['WasteProfilePlugin']);
        this._super('initialize', [options]);
        this.fieldsDataChangeBinding();
        // Add listener for print_paperwork_button
        this.context.on('button:convert_to_lab_template_button:click', this.openWasteProfileTemplateRecordView, this);
    },

    _render: function () {
        this._super('_render');
        this.colourTheRows();
    },

    colourTheRows: function () {
        //
        this.$('.LBL_RECORDVIEW_PANEL1[row-num="3"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="1"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="2"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="5"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="6"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="7"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="8"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="9"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="12"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="5"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="6"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="10"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="11"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="13"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="14"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="17"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="18"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="22"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="24"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="26"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="28"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="30"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="33"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="34"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="35"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="36"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="37"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="38"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL6[row-num="0"]').attr('style', 'background-color:#ebedef');
    },

    openWasteProfileTemplateRecordView: function () {
        var wasteProfileBean;
        var wasteProfileBean = app.data.createBean('WPM_Waste_Profile_Module', {
            id: this.model.get('id'),
        });
        wasteProfileBean.fetch({
            success: function (wasteProfileBean) {
                var module = 'WPM_Waste_Profile_Template',
                        prefill = app.data.createBean(module);

                prefill.copy(wasteProfileBean);
                prefill.unset('id');

                app.drawer.open({
                    layout: 'create',
                    context: {
                        create: true,
                        model: prefill,
                        module: module,
                    }
                });
            },
            error: function (err) {
                app.logger.error('Failed to fetch WPM_Waste_Profile_Module Bean: ' + JSON.stringify(err));
            }
        });
    },
})
