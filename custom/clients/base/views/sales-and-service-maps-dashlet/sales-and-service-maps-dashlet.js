({
    extendsFrom: 'DashablelistView',

    mapsApiAdded: false,

    _defaultSettings: {
        limit: 5,
        intelligent: '0'
    },

    /**
     * @inheritdoc
     */
    initDashlet: function(view) {
        this._super('initDashlet', [view]);
        this.settings.on('change:filter', _.bind(this.reApplyFilter, this), this);
    },

    /**
     * @Override
     */
    reApplyFilter: function() {
        if (this.disposed || this.meta.config) {
            return;
        }

        this._displayDashlet();
    },

    /**
     * @Override
     */
    _displayDashlet: function(filterDef) {
        filterDef = [{
            'on_date_c' : {
                '$dateRange': this.settings.get('filter')
            }
        }];

        this._super('_displayDashlet', [filterDef]);
    },

    /**
     * @Override
     */
    updateDashletFilterAndSave: function(filterModel) {
        var componentType = this.dashModel.get('componentType') || 'view';

        // Adding a new dashlet requires componentType to be set on the model.
        if (!this.dashModel.get('componentType')) {
            this.dashModel.set('componentType', componentType);
        }

        app.drawer.close(this.dashModel);
        app.events.trigger('dashlet:filter:save', this.dashModel.get('module'));
    },

    /**
     * @Override
     */
    _addFilterComponent: function() {},

    /**
     * @Override
     */
    render: function() {
        this._super('render');

        // loading maps api if not loaded
        if (typeof(google) == "undefined" && !this.mapsApiAdded) {
            var script = document.createElement('script');
            script.src = "//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAyAAyXJDGMIgFTJXsmdQdsnoS_XDQu62o";
            script.onload = _.bind(this.loadMap, this);
            document.body.appendChild(script);

            this.mapsApiAdded = true;

            return;
        }

        this.loadMap();
    },

    /**
     * loads the map and displays the markers
     */
    loadMap: function() {
        if (typeof(google) == "undefined") {
            return;
        }

        // Display a map on the page
        var canvas = this.$el.find('#map_canvas').get(0);
        var map = new google.maps.Map(canvas, {
            mapTypeId: 'roadmap'
        });
        map.setTilt(45);

        // set default center to NY, USA
        map.setCenter({lat:40.7128, lng:-74.0060})
        map.setZoom(8);

        // if markers are available then show them
        if (this.collection.models.length > 0) {
            var bounds = new google.maps.LatLngBounds();

            _.each(this.collection.models, function(model){
                var address = model.get('shipping_address_street_c') + ', ' +
                    model.get('shipping_address_city_c') + ', ' +
                    model.get('shipping_address_state_c') + ', ' +
                    model.get('shipping_address_postalcode_c') + ', ' +
                    model.get('shipping_address_country_c');

                var position = new google.maps.LatLng(
                    model.get('lat_c'),
                    model.get('lon_c')
                );
                new google.maps.Marker({
                    map: map,
                    position: position,
                    title: model.get('name') + "\n" + address
                });

                bounds.extend(position);
            }, this);

            map.fitBounds(bounds);
            map.setZoom(14);
        }
    }
})
