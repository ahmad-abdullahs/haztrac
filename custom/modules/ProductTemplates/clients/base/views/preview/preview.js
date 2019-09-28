
({

    extendsFrom: 'PreviewView',

    /*
     * Add hide class to the fields in preview which are hidden due to the 
     * visibility dependency for instance: custom/Extension/modules/ProductTemplates/Ext/Vardefs/dependencies.php
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        app.events.on('data:sync:complete', function (method, model, options) {
            this.$el.find('div.vis_action_hidden').addClass('hide');
        }, this);
    },
})

