({
    extendsFrom: 'RelateField',
    initialize: function (options) {
        this._super('initialize', [options]);
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

        this._super('updateRelatedFields', [model]);

        // ++
        var self = this;
        _.each(newData.team_name, function (team) {
            if (team.primary) {
                var teamBean = app.data.createBean('Teams', {id: team.id});
                teamBean.fetch({
                    success: function (_model) {
                        self.model.set('account_id_c', _model.get('account_id_c'));
                        self.model.set('transporter_carrier_c', _model.get('transporter_carrier_c'));
                    }
                }, this);
            }
        }, this);
    },
})