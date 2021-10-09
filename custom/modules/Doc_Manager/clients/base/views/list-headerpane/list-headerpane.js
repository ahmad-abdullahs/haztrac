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
 * @class View.Views.Base.ListHeaderpaneView
 * @alias SUGAR.App.view.views.BaseListHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'ListHeaderpaneView',
    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    bindDataChange: function () {
        var self = this;

        this.context.on('button:import_document_button:click', function () {
            app.drawer.open({
                layout: 'upload-onlyoffice-file',
                context: {
                    url: 'onlyoffice/index_upload_only.php',
                }
            }, _.bind(function (context, model) {
                // comes here when its is closed
                // Reload the Document Manager records view.
                app.router.refresh();
            }, self));
        }, this);

        this._super('bindDataChange');
    },
})
