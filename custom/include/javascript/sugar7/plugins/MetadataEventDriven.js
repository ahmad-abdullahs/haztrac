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
 * Plugin provide way for fields to handle events specified in metadata.
 * You can specify those events in metadata as:
 *
 * <pre><code>
 * events: {
 *     handler: "fire:some:event";
 * }
 * </code></pre>
 *
 * The default behavior triggers event on `this.view.context` and
 * `this.view.layout` if they exist.
 */
(function (app) {
    app.events.on('app:init', function () {
        app.plugins.register('MetadataEventDriven', ['field'], {
            events: {
                'click a[name=advance-relate-preview-list]': 'showPreview'
            },

            showPreview: function (ele) {
                var href = $(ele.delegateTarget).find('a:last').prop('href');
                href = href.replace("#", "").split("/");
                var id = _.uniqueId('pre');

                if (href.length > 2) {
                    // Show alert 
                    app.alert.show('fetching_related_record', {
                        level: 'process',
                        title: app.lang.getAppString('LBL_LOADING')
                    });

                    var bean = app.data.createBean(href[href.length - 2], {id: href[href.length - 1]});
                    bean.byPassHint = true;
                    app.events.trigger("preview:render", bean, app.controller.context.get('collection'), false, id, false);
                    app.events.trigger('preview:pagination:hide');

                    // Dismiss alert
                    app.alert.dismiss('fetching_related_record');
                }
                ele.preventDefault();
            },
            /**
             * Triggers event.
             * @param {Event} domEvent Original DOM event.
             * @param {String} metadataEvent Name of event to trigger.
             */
            triggerMetadataEvent: function (domEvent, metadataEvent) {
                if (this.view.context) {
                    this.view.context.trigger(metadataEvent, this.model);
                }
                if (this.view.layout) {
                    this.view.layout.trigger(metadataEvent, this.model);
                }
            }
        });
    });
})(SUGAR.App);
