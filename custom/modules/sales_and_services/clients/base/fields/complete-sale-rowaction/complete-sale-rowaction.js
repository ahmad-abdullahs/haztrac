({
    extendsFrom: 'RowactionField',

    initialize: function (options) {
        this._super('initialize', [options]);
        this.type = 'rowaction';
    },
    rowActionSelect: function (evt) {
        this.openServiceRecordView();
    },
    openServiceRecordView: function () {
        var recordId = this.getRecordId();
        var model = this.collection.get(recordId);
        var module = 'sales_and_services';
        app.drawer.open({
            layout: 'record',
            context: {
                // This layout abbribute is essential to add, otherwise record in the drawer will not
                // load the record view dashlets.
                layout: 'record',
                module: module,
                model: model,
                modelId: recordId,
                initiatedByMapView: true,
                completeSales: true,
//                loadSpecifiedPanels: [
//                    'sales_and_services_revenuelineitems_1',
//                ],
            }
        }, _.bind(function () {
            // On Close
            this.collection.fetch();
        }, this), _.bind(function (renderedComponent) {
            // On Open make the record view in edit mode.
            renderedComponent.context.trigger('button:edit_button:click');
            // Take user to the completion tab.
            $('li.tab.panel_completion > a').click();
            // When you go for Service Completion, open the Completion panel automatically 
            $('div[data-panelname="panel_completion"] > div').click();
        }, this));
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

        // Make the button un clickable if the sales and service is already completed...
        var recordId = this.getRecordId();
        var model = this.collection.get(recordId);
        if (model.get('status_c') == 'Complete') {
            this.disableListControl(this, {
                'name': 'complete_sale_button',
            }, model);
        }
    },
})