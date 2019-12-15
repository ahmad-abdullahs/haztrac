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
 * @class View.Views.Base.RecordView
 * @alias SUGAR.App.view.views.BaseRecordView
 * @extends View.View
 */
({
    extendsFrom: 'RecordView',

    /**
     * Don't save the last tab state, It's done application wide.
     * @inheritdoc
     */
    getActiveTab: function (options) {
        return false;
    },

    _buildGridsFromPanelsMetadata: function (panels) {
        var alreadyExist = false;
        this._super('_buildGridsFromPanelsMetadata', [panels]);
        _.each(this.options.meta.buttons, function (_buttons, index) {
            if (_.contains(['scroll_top', 'scroll_bottom'], _buttons.name)) {
                alreadyExist = true;
            }

            if (_buttons.name == 'sidebar_toggle' && !alreadyExist) {
                this.options.meta.buttons.splice(index, 0, {
                    'name': 'scroll_top',
                    'type': 'scrolltop'
                });
                this.options.meta.buttons.splice(index + 1, 0, {
                    'name': 'scroll_bottom',
                    'type': 'scrollbottom'
                });
            }
        }, this);
    },
})
