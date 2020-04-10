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
 * Module menu provides a reusable and easy render of a module Menu.
 *
 * This also helps doing customization of the menu per module and provides more
 * metadata driven features.
 *
 * @class View.Views.Base.ModuleMenuView
 * @alias SUGAR.App.view.views.BaseModuleMenuView
 * @extends View.View
 */
({
    extendsFrom: 'ModuleMenuView',

    // ++
    menuTierFlag: false,
    menuTierTitle: '',
    menuTierDivision: {
        'HRM_Employee_Training': 'HR Management',
    },

    initialize: function (options) {
        this.menuTierFlag = false;
        this.menuTierTitle = '';
        this._super('initialize', [options]);
    },

    _renderHtml: function () {
        if (this.menuTierDivision[this.module]) {
            this.menuTierFlag = true;
            this.menuTierTitle = this.menuTierDivision[this.module];
        }
        this._super('_renderHtml');
    },

})
