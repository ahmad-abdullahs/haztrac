({
    /**
     * Places only components that include the Dashlet plugin and places them in the 'main-pane' div of
     * the dashlet layout.
     * @param {app.view.Component} component
     * @private
     */
    _placeComponent: function(component) {
        var dashboardEl = this.$('#ARA_ChildElements');
        dashboardEl.append('<li class="span-12"></li>');

        this.$('#ARA_ChildElements > li').last().append(component.el);
    },
})