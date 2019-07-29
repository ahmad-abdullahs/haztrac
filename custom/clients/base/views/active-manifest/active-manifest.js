({
    extendsFrom: 'TabbedDashletView',

    _defaultSettings: {
        limit: 10,
        visibility: 'user'
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        options.meta = options.meta || {};
        options.meta.template = 'tabbed-dashlet';

        this.tbodyTag = 'ul[data-action="pagination-body"]';

        this._super('initialize', [options]);
    },

    /**
     * @inheritdoc
     */
    _initEvents: function() {
        this._super('_initEvents');
        this.on('render:rows', this._renderAvatars, this);

        return this;
    },

    /**
     * @inheritdoc
     */
    _initTabs: function() {
        this._super("_initTabs");
    },

    /**
     * Create new record.
     *
     * @param {Event} event Click event.
     * @param {Object} params
     * @param {String} params.layout Layout name.
     * @param {String} params.module Module name.
     */
    createRecord: function(event, params) {
        var self = this;
        app.drawer.open({
            layout: 'create',
            context: {
                create: true,
                module: params.module
            }
        }, function(context, model) {
            if (!model) {
                return;
            }
            self.context.resetLoadFlag();
            self.context.set('skipFetch', false);
            if (_.isFunction(self.loadData)) {
                self.loadData();
            } else {
                self.context.loadData();
            }
        });
    },

    /**
     * New model related properties are injected into each model.
     * Update the picture url's property for model's assigned user.
     *
     * @param {Bean} model Appended new model.
     */
    bindCollectionAdd: function(model) {
        var pictureUrl = app.api.buildFileURL({
            module: 'Users',
            id: model.get('assigned_user_id'),
            field: 'picture'
        });
        model.set('picture_url', pictureUrl);
        this._super('bindCollectionAdd', [model]);
    },

    /**
     * @inheritdoc
     *
     * New model related properties are injected into each model:
     *
     * - {Boolean} overdue True if record is prior to now.
     */
    _renderHtml: function() {
        if (this.meta.config) {
            this._super('_renderHtml');
            return;
        }

        this._super('_renderHtml');
        this._renderAvatars();
    }
})
