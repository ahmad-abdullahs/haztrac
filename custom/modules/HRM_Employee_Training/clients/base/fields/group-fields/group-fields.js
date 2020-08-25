/*
 * @class View.Fields.Base.FieldsetField
 * @alias SUGAR.App.view.fields.BaseFieldsetField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'FieldsetField',

    initialize: function (options) {
        this._super('initialize', [options]);
        this.model.on("change:renewal_refresher_c", this.setFieldsVisibility, this);
    },

    _render: function () {
        this._super('_render');
        this.$el.css('display', '-webkit-box');
    },

    setFieldsVisibility: function (fields) {
        _.each(this.fields, function (field) {
            if (_.contains(['frequency_c', 'renewal_days_c'], field.name)) {
                if (!this.model.get('renewal_refresher_c')) {
                    field.$el.addClass('vis_action_hidden');
                    field.$el.parents('div.record-cell').addClass('hide');
                } else {
                    field.$el.removeClass('vis_action_hidden');
                    field.$el.parents('div').removeClass('hide');
                }
            }
        }, this);
    },
})
