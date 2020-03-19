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
        this._super('initialize', [options]);
        app.events.on('data:sync:complete', function (method, model, options) {
            this.$el.find('div.vis_action_hidden').addClass('hide');
        }, this);
    },
})
