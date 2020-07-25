({
    extendsFrom: "EnumField",
    assetsCollection: null,

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    bindDataChange: function () {
        this._super('bindDataChange');
        this.model.on('change:team_name', _.bind(this.loadEnumOptions, this));
    },

    format: function (value) {
        this.models = [];
        if (this.def.isMultiSelect && _.isArray(value) && _.indexOf(value, '') > -1) {
            value = _.clone(value);
            // Delete empty values from the select list
            delete value[''];
        }

        if (this.def.isMultiSelect && _.isString(value)) {
            return this.convertMultiSelectDefaultString(value);
        } else {
            var values = [];
            var self = this;
            _.each(value, function (val, i) {
                if (!_.isUndefined(self.items[val])) {
                    values.push(self.items[val]);
                    var href = '#' + app.router.buildRoute(this.def.module, val);
                    self.models.push({
                        'text': self.items[val],
                        'href': href
                    });
                }
            }, this);

            return this.action == 'edit' ? value : values;
        }
    },
    /**
     * Load the options for this field and pass them to callback function.  May be asynchronous.
     * @param {Boolean} fetch (optional) Force use of Enum API to load options.
     * @param {Function} callback (optional) Called when enum options are available.
     */
    loadEnumOptions: function (fetch, callback, error) {
        var self = this;
        var parentTeamIds = [], assetTeamIds = [];
        this.items = {};

        // Get the parent team ids
        parentTeamIds = this.getTeamIds(this.model.get('team_name'));

        // First fetch the whole assets list... 
        // then show the item based on the teams selected
        if (_.isNull(this.assetsCollection)) {
            var collection = App.data.createBeanCollection('HT_Assets_and_Objects');
            collection.fetch({
                'showAlerts': false,
                'fields': ['id', 'name', 'team_name'],
                'limit': -1,
                success: function (data) {
                    var items = {};
                    self.assetsCollection = data;

                    _.each(self.assetsCollection.models, function (model) {
                        // Get the asset team ids
                        assetTeamIds = self.getTeamIds(model.get('team_name'));
                        if (!_.isEmpty(parentTeamIds)) {
                            if (!_.isEmpty(_.intersection(parentTeamIds, assetTeamIds))) {
                                items[model.get('id')] = model.get('name');
                            }
                        } else {
                            items[model.get('id')] = model.get('name');
                        }
                    }, this);

                    self.items = items;
                    self.render();
                }, error: function (err) {
                    console.error('Error :: ', err);
                }
            });
        } else {
            var items = {};

            _.each(this.assetsCollection.models, function (model) {
                // Get the asset team ids
                assetTeamIds = this.getTeamIds(model.get('team_name'));
                if (!_.isEmpty(parentTeamIds)) {
                    if (!_.isEmpty(_.intersection(parentTeamIds, assetTeamIds))) {
                        items[model.get('id')] = model.get('name');
                    }
                } else {
                    items[model.get('id')] = model.get('name');
                }
            }, this);

            // This code is added to keep the assets only selected which belongs to the teams selected.
            // For instance if any user has removed the team from record, and assets related to that team
            // should also be removed.
            var fieldValue = _.intersection(_.keys(items), self.model.get(self.name));
            self.model.set(self.name, fieldValue);

            this.items = items;
            this.render();
        }
    },

    // Return the team ids
    getTeamIds: function (team_name) {
        var teamIds = [];
        _.each(team_name, function (team) {
            teamIds.push(team.id);
        }, this);

        return teamIds;
    },
})