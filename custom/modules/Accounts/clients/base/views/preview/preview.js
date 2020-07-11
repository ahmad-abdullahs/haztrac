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
 * @class View.Views.Base.PreviewView
 * @alias SUGAR.App.view.views.BasePreviewView
 * @extends View.Views.Base.RecordView
 */
({
    extendsFrom: 'PreviewView',

    /*
     * Add hide class to the fields in preview which are hidden due to the 
     * visibility dependency for instance: custom/Extension/modules/ProductTemplates/Ext/Vardefs/dependencies.php
     */
    initialize: function (options) {
        this.dataView = 'preview';
        if (options.context.get('model').customPreviewMeta) {
            this.dataView = options.context.get('model').customPreviewMeta;
        }

        // Use preview view if available, otherwise fallback to record view
        var previewMeta = app.metadata.getView(options.module, this.dataView);
        var recordMeta = app.metadata.getView(options.module, 'record');

        if (_.isEmpty(previewMeta) || _.isEmpty(previewMeta.panels)) {
            this.dataView = 'record';
        }

        this._super('initialize', [options]);
        this.meta = _.extend(this.meta, this._previewifyMetadata(_.extend({}, recordMeta, previewMeta)));
        this.action = 'detail';
        this._delegateEvents();

        /**
         * An array of the {@link #alerts alert} names in this view.
         *
         * @property {Array}
         * @protected
         */
        this._viewAlerts = [];

        /**
         * A collection of alert messages to be used in this view. The alert methods
         * should be invoked by Function.prototype.call(), passing in an instance of
         * a sidecar view. For example:
         *
         *     // ...
         *     this.alerts.showInvalidModel.call(this);
         *     // ...
         *
         * FIXME: SC-3451 will refactor this `alerts` structure.
         * @property {Object}
         */
        this.alerts = {
            showInvalidModel: function () {
                if (!this instanceof app.view.View) {
                    app.logger.error('This method should be invoked by Function.prototype.call(), passing in as argument' +
                            'an instance of this view.');
                    return;
                }
                var name = 'invalid-data';
                this._viewAlerts.push(name);
                app.alert.show(name, {
                    level: 'error',
                    messages: 'ERR_RESOLVE_ERRORS'
                });
            },
            showNoAccessError: function () {
                if (!this instanceof app.view.View) {
                    app.logger.error('This method should be invoked by Function.prototype.call(), passing in as argument' +
                            'an instance of this view.');
                    return;
                }
                // dismiss the default error
                app.alert.dismiss('data:sync:error');
                // display no access error
                app.alert.show('server-error', {
                    level: 'error',
                    messages: 'ERR_HTTP_404_TEXT_LINE1'
                });
                // discard any changes before redirect
                this.handleCancel();
                // redirect to list view
                var route = app.router.buildRoute(this.module);
                app.router.navigate(route, {trigger: true});
            }
        };

        app.events.on('data:sync:complete', function (method, model, options) {
            // Execute after 1 seconds (1000 milliseconds):
            setTimeout(_.bind(function () {
                if (this.$el) {
                    this.$el.find('div.vis_action_hidden').addClass('hide');
                }
            }, this), 250);
        }, this);
    },

})
