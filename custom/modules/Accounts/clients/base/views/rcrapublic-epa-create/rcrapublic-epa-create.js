({
    fileLink: '',

    initialize: function (options) {
        this._super('initialize', [options]);

        this.fileLink = '';
        var context = this.context.parent || this.context;
        var model = context.get('model');

        model.on('change:shipping_address_street', _.bind(this.getRCRAEpaInfoBySearch, this));
        model.on('change:shipping_address_city', _.bind(this.getRCRAEpaInfoBySearch, this));
        model.on('change:shipping_address_postalcode', _.bind(this.getRCRAEpaInfoBySearch, this));
    },

    getRCRAEpaInfoBySearch: function () {
        var self = this;
        var context = this.context.parent || this.context;
        var model = context.get('model');

        if (model.get('shipping_address_street') && model.get('shipping_address_city') && model.get('shipping_address_postalcode')) {
            // Show Processing alert.
            app.alert.show('get_epa_info', {level: 'process', title: 'Fetching EPA (United States Environmental Protection Agency) Information'});
            // Make a call to update the RLIS
            app.api.call('read', app.api.buildURL('Accounts/'
                    + model.get('shipping_address_street') + '/' +
                    model.get('shipping_address_city') + '/' +
                    model.get('shipping_address_postalcode') + '/' +
                    '/getEPAInfoBySearch'), {}, {
                success: function (data) {
                    // Dismiss the alert.
                    setTimeout(function () {
                        app.alert.dismiss('get_epa_info');
                        if (data.src) {
                            app.alert.show('get_epa_info_success', {
                                level: 'success',
                                autoClose: true,
                                messages: 'Information received.',
                            });
                        }
                    }, data.siteIdsList.length * 300);


                    if (data.src) {
                        var href = window.location.href;
                        href = href.split("#");
                        href = href[0] + data.src;
                        self.fileLink = href;
                    } else {
                        app.alert.dismiss('get_epa_info');
                        app.alert.show('get_epa_info_success', {
                            level: 'warning',
                            autoClose: true,
                            messages: 'No information received.',
                        });
                        self.fileLink = '';
                    }

                    self.render();

                    if (data) {
                        _.each(data.siteIdsList, function (usEpaId) {
                            self.getRCRAEpaInfo(usEpaId);
                        });
                    }
                },
                error: function (e) {
                    app.alert.dismiss('get_epa_info');
                    throw e;
                }
            });
        } else {
            self.fileLink = '';
            self.render();
        }
    },

    getRCRAEpaInfo: function (usEpaId) {
        if (usEpaId) {
            // Make a call to update the RLIS
            app.api.call('read', app.api.buildURL('Accounts/' + usEpaId + '/getEPAInfo'), {}, {
                success: function (data) {
                    if (data.html) {
                        var appendHTMLToDiv = setInterval(function () {
                            var iframe = document.getElementById('rcrapublic-epa-create-iframe');
                            if (iframe) {
                                var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
                                var div = innerDoc.getElementsByName('eyeball-' + usEpaId + '-div');
                                if (div.length) {
                                    $(div).append(data.html);
                                    // Stop the spinner and show the eyeball instead.
                                    var i = innerDoc.getElementsByName('eyeball-' + usEpaId + '-i');
                                    $(i).removeClass("fa fa-spinner").addClass('fa fa-eye');
                                    clearInterval(appendHTMLToDiv);
                                }
                            }
                        }, 100);
                    } else {
                        // No data received against EPA ID
                    }
                },
                error: function (e) {
                    throw e;
                }
            });
        }
    },

//    getRCRAEpaInfo: function () {
//        var self = this;
//        var context = this.context.parent || this.context;
//        var model = context.get('model');
//
//        if (model.get('ac_usepa_id_c')) {
//            // Show Processing alert.
//            app.alert.show('get_epa_info', {level: 'process', title: 'Fetching EPA (United States Environmental Protection Agency) Information'});
//            // Make a call to update the RLIS
//            app.api.call('read', app.api.buildURL('Accounts/' + model.get('ac_usepa_id_c') + '/getEPAInfo'), {}, {
//                success: function (data) {
//                    // Dismiss the alert.
//                    app.alert.dismiss('get_epa_info');
//                    if (data) {
//                        app.alert.show('get_epa_info_success', {
//                            level: 'success',
//                            autoClose: true,
//                            messages: 'Information against EPA ID: (' + model.get('ac_usepa_id_c') + ') is received.',
//                        });
//
//                        var href = window.location.href;
//                        href = href.split("#");
//                        href = href[0] + data;
//                        self.fileLink = href;
//                    } else {
//                        app.alert.show('get_epa_info_success', {
//                            level: 'warning',
//                            autoClose: true,
//                            messages: 'No information found for EPA ID: (' + model.get('ac_usepa_id_c') + ').',
//                        });
//                        self.fileLink = '';
//                    }
//
//                    self.render();
//                },
//                error: function (e) {
//                    throw e;
//                }
//            });
//        } else {
//            self.fileLink = '';
//            self.render();
//        }
//    },

    render: function () {
        this._super('render');
    }
})
