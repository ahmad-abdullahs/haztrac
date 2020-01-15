({
    extendsFrom: 'RowactionField',

    initialize: function (options) {
        this._super('initialize', [options]);
        this.type = 'rowaction';
    },

    rowActionSelect: function (evt) {
        this.openWasteProfileTemplateRecordView();
    },

    openWasteProfileTemplateRecordView: function () {
        var recordId = this.getRecordId();
        var model = this.collection.get(recordId);
        var wasteProfileBean;
        var wasteProfileBean = app.data.createBean('WPM_Waste_Profile_Module', {
            id: model.get('id'),
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

    getRecordId: function () {
        var findName = this.$el.parents('tr:first').attr('name').split('_');
        return findName[findName.length - 1];
    },

    /*
     * Disable the button if service is already completed
     * @returns {undefined}
     */
    _render: function () {
        this._super('_render');
    },
})