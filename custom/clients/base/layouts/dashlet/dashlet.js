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

    setDashletMetadata: function (meta) {
        var metadata = this.model.get("metadata"),
                component = this.getCurrentComponent(metadata, this.index);

        _.each(meta, function (value, key) {
            this[key] = value;
        }, component);

        this.model.set("metadata", app.utils.deepCopy(metadata), {silent: true});
        this.model.trigger("change:layout");
        //auto save
        if (this.model.mode === 'view') {
            this.model.save(null, {
                silent: true,
                //Show alerts for this request
                showAlerts: true,
                success: _.bind(function () {
                    if (this.model) {
                        this.model.unset('updated');
                    } else {
                        // ++
                        // This piece of code is added to refresh the route when 
                        // Financial Detail or Account Details record view dashlet configuration are edited in
                        // the drawer opened on top of Sales and Service List view.
                        // Step 1: Go to Sales and Service list view
                        // Step 2: Click and record, it will be opened in the drawer.
                        // Step 3: Edit Financial Detail or Account Details record view dashlet and Save
                        // Step 4: Issue Reproduced
                        app.router.refresh();
                    }
                }, this)
            });
        }
        return component;
    },

})
