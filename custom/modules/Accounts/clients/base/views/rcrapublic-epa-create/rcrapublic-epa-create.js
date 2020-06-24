({
    fileLink: '',

    initialize: function (options) {
        this._super('initialize', [options]);

        this.fileLink = '';
        var context = this.context.parent || this.context;
        var model = context.get('model');

        model.on('change:ac_usepa_id_c', _.bind(this.getRCRAEpaInfo, this));
    },

    getRCRAEpaInfo: function () {
        var self = this;
        var context = this.context.parent || this.context;
        var model = context.get('model');

        if (model.get('ac_usepa_id_c')) {
            // Show Processing alert.
            app.alert.show('get_epa_info', {level: 'process', title: 'Fetching EPA (United States Environmental Protection Agency) Information'});
            // Make a call to update the RLIS
            app.api.call('read', app.api.buildURL('Accounts/' + model.get('ac_usepa_id_c') + '/getEPAInfo'), {}, {
                success: function (data) {
                    // Dismiss the alert.
                    app.alert.dismiss('get_epa_info');
                    if (data) {
                        app.alert.show('get_epa_info_success', {
                            level: 'success',
                            autoClose: true,
                            messages: 'Information against EPA ID: (' + model.get('ac_usepa_id_c') + ') is received.',
                        });

                        var href = window.location.href;
                        href = href.split("#");
                        href = href[0] + data;
                        self.fileLink = href;
                    } else {
                        app.alert.show('get_epa_info_success', {
                            level: 'warning',
                            autoClose: true,
                            messages: 'No information found for EPA ID: (' + model.get('ac_usepa_id_c') + ').',
                        });
                        self.fileLink = '';
                    }

                    self.render();
                },
                error: function (e) {
                    throw e;
                }
            });
        } else {
            self.fileLink = '';
            self.render();
        }
    },

    render: function () {
        this._super('render');
    }
})
