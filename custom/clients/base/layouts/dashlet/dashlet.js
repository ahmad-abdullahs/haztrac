/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Layouts.Base.DashletLayout
 * @alias SUGAR.App.view.layouts.BaseDashletLayout
 * @extends View.Layout
 */
({
    extendsFrom: 'DashletLayout',
    showFilter: false,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    events: function () {
        var prototype = Object.getPrototypeOf(this);
        var parentEvents = _.result(prototype, 'events');

        if (!_.isUndefined(this.options) && this.options.context.parent) {
            if (!_.isUndefined(this.options.meta) && this.options.context.parent.get('module') == "Accounts") {
                if (!_.isUndefined(this.options.meta.components)) {
                    if (!_.isUndefined(this.options.meta.components[0])) {
                        if (this.options.meta.components[0].view.type == "pending-activities" ||
                                this.options.meta.components[0].view.type == "planned-activities") {
                            return _.extend({}, parentEvents, {
                                'click [data-action=date-switcher]': 'dateSwitcher'
                            });
                        }
                    }
                }
            }
        }

        return _.extend({}, parentEvents);
    },

    dateSwitcher: function (event) {
        var pendingActivitiesView = this.getComponent("pending-activities");

        if (pendingActivitiesView) {
            var date = this.$(event.currentTarget).val();
            if (date === pendingActivitiesView.getDate()) {
                return;
            }

            pendingActivitiesView.settings.set('date', date);
            pendingActivitiesView.loadData();
        }
    },

})
