(function (app) {
    app.events.on('app:init', function () {
        app.plugins.register('FieldUtils', ['view', 'layout', 'field'], {
            disableListControl: function (field, field_attr, model) {
                // FOR EXAMPLE: field.$el.find('[name=edit_button]').removeClass("trigger_edit").addClass('disabled');
                field.$el.find('[name=' + field_attr.name + ']').addClass('disabled');
//                if (model.get('is_bundle_product_c') == 'parent') {
//                }
            },
            hideListControl: function (field, field_attr, model) {
                field.hide();
            },
        });
    });
})(SUGAR.App);