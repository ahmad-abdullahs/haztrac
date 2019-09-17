({
    extendsFrom: 'PanelLayout',

    _initPanelState: function () {
        this._super('_initPanelState');

        /**
         * https://community.sugarcrm.com/thread/34150-how-do-i-force-a-subpanel-to-be-open
         * This function will make the RevenueLineItems subpanel under sales_and_services to be expanded always
         * @returns {undefined}
         */

        if (this.module == 'RevenueLineItems') {
            if (!_.isUndefined(this.context.attributes.parentModule)) {
                if (this.context.attributes.parentModule == 'sales_and_services') {
                    this.context.set('collapsed', false);
                }
            }
        }
    },

})