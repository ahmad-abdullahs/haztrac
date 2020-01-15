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
