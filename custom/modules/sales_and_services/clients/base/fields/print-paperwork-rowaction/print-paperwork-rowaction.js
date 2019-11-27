({
    extendsFrom: 'RowactionField',

    initialize: function (options) {
        this._super('initialize', [options]);
        this.type = 'rowaction';
    },
    rowActionSelect: function (evt) {
        this.printPaperworkDrawer();
    },

    printPaperworkDrawer: function () {
        app.drawer.open({
            layout: 'print-paperwork',
            context: {
                create: true,
                module: this.model.module || this.model.get('_module'),
                model: this.model,
            }
        }, _.bind(function (context, taskmodel) {
            // These are for code reference...
        }, this));
    },
})