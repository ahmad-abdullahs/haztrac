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
({
    extendsFrom: 'HeaderpaneView',

    initialize: function (options) {
        this._super('initialize', [options]);
        this.context.on('button:cancel_button:click', function () {
            // make the document closed automatically
            app.events.trigger('lockAnnotationOnDrawerClose', {
                'document_id': $('#signDocframe').attr('document_id')
            });
            // close the drawer
            app.drawer.close();
            // Reolad the Manifest preview dashlet on the detail view.
            app.events.trigger('reloadDashlet');
        }, this);
    },

    /**
     * Load template for headerpane.
     * @inheritdoc
     */
    _loadTemplate: function (options) {
        var name = this.name;
        this.name = 'headerpane';
        this._super('_loadTemplate', [options]);
        this.name = name;
    },

})
