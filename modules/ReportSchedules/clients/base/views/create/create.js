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
 * @class View.Views.Base.ScheduleReports.CreateView
 * @alias SUGAR.App.view.views.BaseScheduleReportsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',

    /**
     * Check for possible duplicates before creating a new record
     * @param callback
     */
    initiateSave: function(callback) {
        this.disableButtons();
        async.waterfall([
            _.bind(this.validateSubpanelModelsWaterfall, this),
            _.bind(this.validateModelWaterfall, this),
            _.bind(this.dupeCheckWaterfall, this),
            _.bind(this.createRecordWaterfall, this),
            _.bind(this.linkUserWaterfall, this)
        ], _.bind(function(error) {
            this.enableButtons();
            if (error && error.status == 412 && !error.request.metadataRetry) {
                this.handleMetadataSyncError(error);
            } else if (!error && !this.disposed) {
                this.context.lastSaveAction = null;
                callback();
            }
        }, this));
    },

    /**
     * Waterfall function
     * @param callback
     */
    linkUserWaterfall: function(callback) {
        if (this.context.get('copiedFromModelId')) {
            this.copyExistingUsers();
        } else {
            this.linkCurrentUser();
        }
        callback(false);
    },

    /**
     * Link to current user
     */
    linkCurrentUser: function() {
        var user = app.data.createRelatedBean(this.model, app.user.get('id'), 'users');
        user.save(null, {relate: true});
    },

    /**
     * Copy existing users
     */
    copyExistingUsers: function() {
        var bulkRequest;
        var bulkUrl;
        var bulkCalls = [];
        var bean = this.context.parent.get('model');
        var collection = bean.getRelatedCollection('users');
        _.each(collection.models, function(model) {
            bulkUrl = app.api.buildURL('ReportSchedules/' + this.model.get('id') + '/link/users/' + model.get('id'));
            bulkRequest = {
                url: bulkUrl.substr(4),
                method: 'POST',
                data: {}
            };
            bulkCalls.push(bulkRequest);
        }, this);
        if (bulkCalls.length) {
            app.api.call('create', app.api.buildURL(null, 'bulk'), {requests: bulkCalls}, {});
        }
    }
})
