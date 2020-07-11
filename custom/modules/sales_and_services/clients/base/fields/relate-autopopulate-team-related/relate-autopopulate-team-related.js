({
    extendsFrom: 'RelateField',
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    _render: function () {
        this._super('_render');
        // This should not run on the record view, but only on the create view.
        if (this.view.name != 'record') {
            this.setTransporter(this.model.get('team_name'));
        }
    },

    /*
     * Relate field is overitten to auto populate the default transporter.
     * On Sales and service create view when account is selected, it auto populate the team field.
     * We get the primary team out of that and fetch it to get the default transporter automatically populated.
     * @param {type} model
     * @returns {undefined}
     */
    updateRelatedFields: function (model) {
        var newData = {}
        , self = this;
        _.each(this.def.populate_list, function (target, source) {
            source = _.isNumber(source) ? target : source;
            if (!_.isUndefined(model[source]) && app.acl.hasAccessToModel('edit', this.model, target)) {
                var before = this.model.get(target)
                        , after = model[source];

                if (before !== after) {
                    newData[target] = model[source];
                }
            }
        }, this);

        if (_.isEmpty(newData)) {
            return;
        }

        if (newData.account_terms_c) {
            newData.account_terms_c = newData.account_terms_c + '->';
        }

        this.setTransporter(newData.team_name);
        // We are triggering the event to notify the Sales and Service create to 
        // bind the on change event after, once the fields are auto populated from 
        // Accounts relate field.
//        app.events.trigger('custom:bind:onChange:forCreateView');

        // if this.def.auto_populate is true set new data and doesn't show alert message
        if (!_.isUndefined(this.def.auto_populate) && this.def.auto_populate == true) {
            // if we have a currency_id, set it first to trigger the currency conversion before setting
            // the values to the model, this prevents double conversion from happening
            if (!_.isUndefined(newData.currency_id)) {
                this.model.set({currency_id: newData.currency_id});
                delete newData.currency_id;
            }
            this.model.set(newData);
            return;
        }

        // load template key for confirmation message from defs or use default
        var messageTplKey = this.def.populate_confirm_label || 'TPL_OVERWRITE_POPULATED_DATA_CONFIRM',
                messageTpl = Handlebars.compile(app.lang.get(messageTplKey, this.getSearchModule())),
                fieldMessageTpl = app.template.getField(
                        this.type,
                        'overwrite-confirmation',
                        this.model.module),
                messages = [],
                relatedModuleSingular = app.lang.getModuleName(this.def.module);

        _.each(newData, function (value, field) {
            var before = this.model.get(field),
                    after = value;

            if (before !== after) {
                var def = this.model.fields[field];
                messages.push(fieldMessageTpl({
                    before: before,
                    after: after,
                    field_label: app.lang.get(def.label || def.vname || field, this.module)
                }));
            }
        }, this);

        app.alert.show('overwrite_confirmation', {
            level: 'confirmation',
            messages: messageTpl({
                values: new Handlebars.SafeString(messages.join(', ')),
                moduleSingularLower: relatedModuleSingular.toLowerCase()
            }),
            onConfirm: function () {
                // if we have a currency_id, set it first to trigger the currency conversion before setting
                // the values to the model, this prevents double conversion from happening
                if (!_.isUndefined(newData.currency_id)) {
                    self.model.set({currency_id: newData.currency_id});
                    delete newData.currency_id;
                }
                self.model.set(newData);
            }
        });
    },

    setTransporter: function (team_name) {
        // ++
        var self = this;
        _.each(team_name, function (team) {
            if (team.primary) {
                var teamBean = app.data.createBean('Teams', {id: team.id});
                teamBean.fetch({
                    success: function (_model) {
//                        self.model.set('account_id_c', _model.get('account_id_c'));
//                        self.model.set('transporter_carrier_c', _model.get('transporter_carrier_c'));
                        self.model.set('transporter_carrier_c', JSON.stringify([
                            {
                                'id': _model.get('account_id_c'),
                                'name': _model.get('transporter_carrier_c'),
                                'add_button': true,
                                'remove_button': true,
                            }
                        ]));

                        var transporter_carrier_c = self.view.getField('transporter_carrier_c');
                        transporter_carrier_c.render();
                    }
                }, this);
            }
        }, this);
    },
})