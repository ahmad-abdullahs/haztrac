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
 * @class View.Views.Base.RecordlistView
 * @alias SUGAR.App.view.views.BaseRecordlistView
 * @extends View.Views.Base.FlexListView
 */
({
    extendsFrom: 'CustomRecordlistView',

    addActions: function ()
    {
        this._super("addActions");
        if (this.name == 'recordlist') {
            this.addPrintStatus();
        }
    },

    addPrintStatus: function () {
        if (this.leftColumns[0] && _.isArray(this.leftColumns[0].fields)) {
            this.leftColumns[0].fields.push({
                type: 'print-status'
            });
        }
    },

    addFavorite: function () {},
})