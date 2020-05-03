({
    extendsFrom: 'RowactionField',

    initialize: function (options) {
        this._super('initialize', [options]);
        this.type = 'rowaction';
    },

    getRecordId: function () {
        var findName = this.$el.parents('tr:first').attr('name').split('_');
        return findName[findName.length - 1];
    },

    _render: function () {
        this._super('_render');

        if (this.tplName == 'record' && this.module == 'RevenueLineItems') {
            // If this is the RevenueLineItems Bundle, remove the copy button from record view, 
            // Since copy feature for RevenueLineItems Bundle is not yet implemented.
            if (this.model.get('is_bundle_product_c') == 'parent') {
                this.hideListControl(this, {
                    'name': 'duplicate_button',
                }, model);
            }
        } else if (this.tplName == 'record' && this.module == 'ProductTemplates') {
            // If this is the ProductTemplates Group, remove the copy button from record view, 
            // Since copy feature for ProductTemplates Group is not yet implemented.
            if (this.model.get('is_group_item_c') == true) {
                this.hideListControl(this, {
                    'name': 'duplicate_button',
                }, model);
            }
        } else if (this.type == 'rowaction' && this.module == 'ProductTemplates') {
            // If this is the ProductTemplates Group, remove the copy button from record view, 
            // Since copy feature for ProductTemplates Group is not yet implemented.
            var recordId = this.getRecordId();
            var model = this.collection.get(recordId);
            if (model.get('is_group_item_c') == true) {
                this.hideListControl(this, {
                    'name': 'duplicate_button',
                }, model);
            }
        }
    },
})