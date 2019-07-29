({
    plugins: ['Dashlet'],

    mapsApiAdded: false,

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
        map.setCenter({lat:40.7128, lng:-74.0060});
        map.setZoom(8);

        // if marker is available then show them
        var context = this.context || this.context.parent;
        var model = context.get('model');

        if (!_.isUndefined(model)) {
            var address = model.get('shipping_address_street') + ', ' +
                model.get('shipping_address_city') + ', ' +
                model.get('shipping_address_state') + ', ' +
                model.get('shipping_address_postalcode') + ', ' +
                model.get('shipping_address_country');

            var position = new google.maps.LatLng(
                model.get('lat_c'),
                model.get('lon_c')
            );
            new google.maps.Marker({
                map: map,
                position: position,
                title: model.get('name') + "\n" + address
            });

            map.setCenter(position);
            map.setZoom(8);
        }
    }
})
