({
    plugins: ['Dashlet'],

    viewModel: null,

    _defaultOptions: {
        limit: 10,
    },

    bindDataChange: function () {
        if (!this.meta.config && !this.meta.url.includes('entryPoint')) {
            var context = this.context.parent || this.context;
            var module = context.get('module');
            if (module == 'LR_Lab_Reports' || module == 'HT_Manifest') {
                this.model.on("change:multi_files", this.render, this);
            } else {
                this.model.on("change", this.render, this);
            }
        }
    },

    _render: function () {
        if (!this.meta.config) {
            this.dashletConfig.view_panel[0].height = this.settings.get('limit') * this.rowHeight;
        }

        this.viewModel = app.data.createBean();
        this.viewModel.set(this.settings.attributes);
        this.viewModel.set('url', this.parseFields(this.viewModel.get('url')));
        app.view.View.prototype._render.call(this);
    },

    parseFields: function (url) {
        // https://www.google.com/maps/embed/v1/place?key=AIzaSyAyAAyXJDGMIgFTJXsmdQdsnoS_XDQu62o&q=
        // {shipping_address_street}, {shipping_address_city}, {shipping_address_postalcode}, {shipping_address_country}
        var context = this.context.parent || this.context;
        var model = context.get('model');
        var module = context.get('module');
        var tempModelAttributes = _.clone(model.attributes);

        // (Accounts) If the model has account type Service Site and Different Service Site is checked then show the
        // Service Site Address on the Map
        if (module == 'Accounts' && url.includes('www.google.com/maps')) {
            if (model.get('different_service_site_c') == true) {
                tempModelAttributes.billing_address_street = tempModelAttributes.shipping_address_street = model.get('service_site_address_street_c');
                tempModelAttributes.billing_address_city = tempModelAttributes.shipping_address_city = model.get('service_site_address_city_c');
                tempModelAttributes.billing_address_postalcode = tempModelAttributes.shipping_address_postalcode = model.get('service_site_address_postalcode_c');
                tempModelAttributes.billing_address_country = tempModelAttributes.shipping_address_country = model.get('service_site_address_country_c');
            }
        }

//        var address = [];
//        address.push(tempModelAttributes.shipping_address_street);
//        address.push(tempModelAttributes.shipping_address_city);
//        address.push(tempModelAttributes.shipping_address_state);
//        address.push(tempModelAttributes.shipping_address_postalcode);
//        address.push(tempModelAttributes.shipping_address_country);
//        address = _.filter(address);
//         url = "https://www.google.com/maps/embed/v1/place?key=AIzaSyAyAAyXJDGMIgFTJXsmdQdsnoS_XDQu62o&q="
//         + encodeURIComponent(address.join(', '));

        _.each(tempModelAttributes, function (v, k) {
            url = url.replace(new RegExp('{' + k + '}', 'g'), v);
        });

        // This odering (service_site_address_plus_code_cb and then shipping_address_plus_code_cb) 
        // is important otherwise it will bring issue.
        if (module == 'Accounts' && url.includes('www.google.com/maps')) {
            if (model.get('service_site_address_plus_code_cb') == true && model.get('service_site_address_plus_code_val')) {
                url = "https://www.google.com/maps/embed/v1/place?key=AIzaSyAyAAyXJDGMIgFTJXsmdQdsnoS_XDQu62o&q="
                        + encodeURIComponent(model.get('service_site_address_plus_code_val'));
            } else if (model.get('shipping_address_plus_code_cb') == true && model.get('shipping_address_plus_code_val')) {
                url = "https://www.google.com/maps/embed/v1/place?key=AIzaSyAyAAyXJDGMIgFTJXsmdQdsnoS_XDQu62o&q="
                        + encodeURIComponent(model.get('shipping_address_plus_code_val'));
            }
        }

        return url;
    },

    initDashlet: function (view) {
        this.viewName = view;
        var settings = _.extend({}, this._defaultOptions, this.settings.attributes);
        this.settings.set(settings);
        app.events.on('loadTheFileInDashlet', this.loadTheFileInDashlet, this);
    },

    loadTheFileInDashlet: function (param) {
        var context = this.context.parent || this.context;
        var model = context.get('model');
        model.set('preview_doc_id', param.id + '.' + param.file_ext, {silent: true});
        if (param.hrefLink) {
            $('[name=popOutFullViewButton]').attr('href', param.hrefLink);
        }

        this._render();
    },

    loadData: function (options) {
        if (options && options.complete) {
            options.complete();
        }
        this._render();
    }
})
