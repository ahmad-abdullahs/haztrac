/*
 * @class View.Fields.Base.FieldsetField
 * @alias SUGAR.App.view.fields.BaseFieldsetField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'FieldsetField',

    /*
     * 
     * @param {type} options
     * @returns {undefined}
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    /*
     * 
     * @param {type} fields
     * @returns {undefined}
     */
    _render: function () {
        this._super('_render');
        this.$el.css('display', '-webkit-box');
    },

    /**
     * Renders the children fields in their respective placeholders.
     *
     * @param {Array} fields The children fields.
     * @protected
     */
    _renderFields: function (fields) {
        this._super('_renderFields', [fields]);
    },
})
