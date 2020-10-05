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
 * @class View.Views.Base.KBContentsPreviewView
 * @alias SUGAR.App.view.views.BaseKBContentsPreviewView
 * @extends View.Views.Base.PreviewView
 */
({

    extendsFrom: 'KBContentsPreviewView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['KBContent']);
        this._super('initialize', [options]);
    },

    _previewifyMetadata: function (meta) {
        this.hiddenPanelExists = false; // reset
        _.each(meta.panels, function (panel) {
            if (panel.header) {
                panel.header = false;
                panel.fields = _.filter(panel.fields, function (field) {
                    //Don't show favorite or follow in Preview, it's already on list view row
                    return field.type != 'favorite' && field.type != 'follow';
                });
            }
            //Keep track if a hidden panel exists
            if (!this.hiddenPanelExists && panel.hide) {
                this.hiddenPanelExists = true;
            }
        }, this);
        return meta;
    },

    /**
     * We don't need to initialize KB listeners.
     * @override.
     * @private
     */
    _initKBListeners: function () {}
})
