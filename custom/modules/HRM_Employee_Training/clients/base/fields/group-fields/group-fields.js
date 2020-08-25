/*
 * @class View.Fields.Base.FieldsetField
 * @alias SUGAR.App.view.fields.BaseFieldsetField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'FieldsetField',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    _render: function () {
        this._super('_render');
        this.$el.css('display', '-webkit-box');
    },

    _renderFields: function (fields) {
        this._super('_renderFields', [fields]);
    },
})
