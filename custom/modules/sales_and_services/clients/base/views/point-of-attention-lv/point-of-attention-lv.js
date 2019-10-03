({
    // This view is used for showing up the dashlet on right side of the drawer for 
    // showing module important fields in the dashlet
    // @see screenshots 5.png
    extendsFrom: 'ListView',

    parentModel: null,

    dashletListModel: null,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.dashletListModel = {};
        this.viewName = options.name;

        options = _.extend({}, {module: options.module}, options || {});
        this.parentModel = options.context.parent.get('model')

        // If we enable the super call it will take the view to list view.
        // this._super('initialize', [options]);


        /**/
        //Grab the list of fields to display from the main list view (assuming initialize is being called from a subclass)
        var listViewMeta = app.metadata.getView(options.module, options.name) || {};
        //Extend from an empty object to prevent polution of the base metadata
        options.meta = _.extend({}, listViewMeta, options.meta || {});
        // FIXME: SC-5622 we shouldn't manipulate metadata this way.
        options.meta.type = options.meta.type || options.name;
        options.meta.action = options.name;
        options = this.parseFieldMetadata(options);

//        app.view.View.prototype.initialize.call(this, options);
        this._super('initialize', [options]);

        this.viewName = options.name;

        if (this.dataViewName) {
            app.logger.warn('`dataViewName` is deprecated, please use `dataView`.');
            this.context.set('dataView', options.name);
        }

        this.attachEvents();
        this.orderByLastStateKey = app.user.lastState.key('order-by', this);
        this.orderBy = this._initOrderBy();
        if (this.collection) {
            this.collection.orderBy = this.orderBy;
        }
        // Dashboard layout injects shared context with limit: 5.
        // Otherwise, we don't set so fetches will use max query in config.
        this.limit = this.context.has('limit') ? this.context.get('limit') : null;
        this.metaFields = this.meta.panels ? _.first(this.meta.panels).fields : [];

        this.registerShortcuts();
        /**/

        this.dashletListModel = App.data.createBeanCollection(options.module);
        this.dashletListModel.add(this.parentModel);
    },
})
