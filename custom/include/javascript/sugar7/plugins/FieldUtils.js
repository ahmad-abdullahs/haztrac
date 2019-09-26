(function (app) {
    app.events.on('app:init', function () {
        app.plugins.register('FieldUtils', ['view', 'layout', 'field'], {
            disableEditListControl: function (field, model) {
                if (model.get('is_bundle_product_c') == 'parent') {
                    field.$el.find('[name=edit_button]').removeClass("trigger_edit").addClass('disabled');
                }
            }
        });
    });
})(SUGAR.App);