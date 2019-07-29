({
    plugins: ['Dashlet'],

    viewModel: null,
    
    _defaultOptions: {
        limit: 10,
    },

    bindDataChange: function(){
        if(!this.meta.config) {
            this.model.on("change", this.render, this);
        }
    },

    _render: function() {
        if (!this.meta.config) {
            this.dashletConfig.view_panel[0].height = this.settings.get('limit') * this.rowHeight;
        }

        this.viewModel = app.data.createBean();
        this.viewModel.set(this.settings.attributes);
        this.viewModel.set('url', this.parseFields(this.viewModel.get('url')));
        app.view.View.prototype._render.call(this);
    },

    parseFields: function(url) {
        var context = this.context.parent || this.context;
        var model = context.get('model');

        _.each(model.attributes, function(v, k) {
            url = url.replace(new RegExp('{'+k+'}', 'g'), v);
        });

        return url;
    },

    initDashlet: function(view) {
        this.viewName = view;
        var settings = _.extend({}, this._defaultOptions, this.settings.attributes);
        this.settings.set(settings);
    },

    loadData: function(options) {
        if (options && options.complete) {
            options.complete();
        }
    }
})
