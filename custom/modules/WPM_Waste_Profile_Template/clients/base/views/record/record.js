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
    extendsFrom: 'RecordView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['WasteProfilePlugin']);
        this._super('initialize', [options]);
        this.fieldsDataChangeBinding();
    },

    _render: function () {
        this._super('_render');
        this.colourTheRows();
    },

    colourTheRows: function () {
        //
        this.$('.LBL_RECORDVIEW_PANEL1[row-num="3"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="1"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="2"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="5"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="6"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="7"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="8"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="9"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL3[row-num="12"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="5"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="6"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="10"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="11"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="14"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="15"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="18"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="19"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="20"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="22"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="24"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="26"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="28"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="30"]').attr('style', 'background-color:#ebedef');
        //
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="32"]').attr('style', 'background-color:#ebedef');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="33"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="34"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="35"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="36"]').attr('style', 'background-color:#f4f4f4');
        this.$('.LBL_RECORDVIEW_PANEL8[row-num="37"]').attr('style', 'background-color:#f4f4f4');
        //
        this.$('.LBL_RECORDVIEW_PANEL6[row-num="0"]').attr('style', 'background-color:#ebedef');
    },
})
