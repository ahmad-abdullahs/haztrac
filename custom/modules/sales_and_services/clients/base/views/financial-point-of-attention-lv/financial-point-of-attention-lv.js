({
    // This view is used for showing up the dashlet on right side of the drawer for 
    // showing module important fields in the dashlet
    // @see screenshots 5.2.png
    extendsFrom: 'sales_and_servicesCustomPointOfAttentionLvView',

    parentModel: null,

    dashletListModel: null,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    _render: function () {
        // Only render the view when user is admin or the
        // regular user is in Manager: Financial team
        var showDashlet = false;

        if (app.user.get('type') == "user") {
            var myTeams = app.user.get('my_teams');
            _.each(myTeams, function (team) {
                if (team.name == "Manager: Financial") {
                    showDashlet = true;
                }
            });
        } else if (app.user.get('type') == "admin") {
            showDashlet = true;
        }

        if (showDashlet) {
            this._super('_render');
        }
    },
})
