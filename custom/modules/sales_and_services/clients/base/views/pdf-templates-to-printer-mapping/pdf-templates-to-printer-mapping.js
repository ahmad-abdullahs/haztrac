({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    render: function () {
        this._super('render');

        var field1 = this.getField('on_fly_manifest_name');
//        field1.hide();
        var field2 = this.getField('on_fly_manifest_number');
//        field2.hide();

        field1.$el.parents('div:first').hide();
        field2.$el.parents('div:first').hide();
    },

    _render: function () {
        this._super('_render');
    },

    bindDataChange: function () {
        this._super('bindDataChange');
    },
})