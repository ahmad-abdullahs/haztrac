({
    extendsFrom: 'EnumField',
    counterLoop: false,

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    render: function () {
        this._super('render');
    },

    bindDataChange: function () {
        this._super('bindDataChange');

        // For Record View
        this.model.on('data:sync:complete', function () {
            this.model.on('change:account_terms_c', _.bind(this.updateAccountTermsForFuture, this));
        }, this);

//        app.events.on('custom:bind:onChange:forCreateView', function () {
//        }, this);
        // For Create View
        if (!this.model.get("id")) {
            this.model.on('change:account_terms_c', _.bind(this.updateAccountTermsForFuture, this));
        }
    },

    updateAccountTermsForFuture: function (model, value) {
        if (value) {
            var pieces = value.split('->');
            if (pieces.length > 1) {
                this.counterLoop = true;
                this.model.set('account_terms_c', pieces[0]);
                return;
            }

            if (this.counterLoop) {
                this.counterLoop = false;
                return;
            }

            if (this.model._syncedAttributes.account_terms_c != value) {
                app.alert.show('change-account-terms', {
                    level: 'confirmation',
                    title: "Confirmation",
                    messages: "You have changed the terms. <br><b>Do you want to save it for all your future transactions?</b><br><br>\n\
    <b style='color: red;'>Note:</b><br>\n\
    Changes will be saved when user save the record.",
                    onConfirm: _.bind(function () {
                        this.model.set('allowAccountTermsUpdate', true);
                    }, this),
                    onCancel: _.bind(function () {
                        this.model.set('allowAccountTermsUpdate', false);
                    }, this)
                });
            } else {
                this.model.set('allowAccountTermsUpdate', false);
            }
        }
    },
})