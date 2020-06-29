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
 * This is the base field and all of other fields extend from it.
 *
 * @class View.Fields.Base.BaseField
 * @alias SUGAR.App.view.fields.BaseBaseField
 * @extends View.Field
 */
({
    extendsFrom: 'BaseField',
    iconVisibility: false,

    // Make sure the name of function e.g showEPAPreview should be distinct otherwise 
    // event will not be bunded or binded to some wrong function...
    events: {
        'click a[name="advance-text-preview"]': 'showEPAPreview',
    },

    initialize: function (options) {
        this.iconVisibility = false;
        this._super("initialize", [options]);
    },

    _render: function () {
        if (!_.isEmpty(this.model.get(this.name)) && this.def['eye-icon'] != false) {
            this.iconVisibility = true;
        }
        this._super("_render");
    },

    showEPAPreview: function (ele) {
        var id = _.uniqueId('pre');
        // Show alert 
        app.alert.show('fetching_related_record', {
            level: 'process',
            title: app.lang.getAppString('LBL_LOADING')
        });

        var bean = app.data.createBean(this.module, {id: this.model.get('id')});
        bean.byPassHint = true;
        // Name of custom preview
        bean.customPreviewMeta = 'preview-epa-details';
        app.events.trigger("preview:custom_subpanel:meta", 'preview-epa-details');
        app.events.trigger("preview:render", bean, this.context.get("collection"), false, id, false);
        app.events.trigger('preview:pagination:hide');

        // Dismiss alert
        app.alert.dismiss('fetching_related_record');

        ele.preventDefault();
    },

})
