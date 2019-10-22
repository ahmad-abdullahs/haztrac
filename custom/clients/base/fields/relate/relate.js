/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 *
 * @class View.Fields.Base.RelateField
 * @alias SUGAR.App.view.fields.BaseRelateField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'RelateField',
    iconVisibility: false,
    bannedFields: [],
    initialize: function (options) {
        this.bannedFields = ['assigned_user_name', 'modified_by_name', 'created_by_name'];
        this.iconVisibility = false;
        this.events = _.extend({}, this.events, {
            'click a[name=advance-relate-preview]': 'showPreview',
        });
        this._super("initialize", [options]);
    },

    _render: function () {
        if (!_.contains(this.bannedFields, this.name)) {
            var fieldIdName = this.fieldDefs.id_name;
            if (!_.isEmpty(fieldIdName)) {
                var id = this.model.get(fieldIdName);
                if (!_.isEmpty(id)) {
                    this.iconVisibility = true;
                }
            }
        }
        this._super("_render");
    },

    showPreview: function (ele) {
        var href = this.href;
        href = href.replace("#", "").split("/");
        var id = _.uniqueId('pre');
        // Show alert 
        app.alert.show('fetching_related_record', {
            level: 'process',
            title: app.lang.getAppString('LBL_LOADING')
        });

        var bean = app.data.createBean(href[0], {id: href[1]});
        bean.byPassHint = true;
        app.events.trigger("preview:render", bean, this.context.get("collection"), false, id, false);
        app.events.trigger('preview:pagination:hide');

        // Dismiss alert
        app.alert.dismiss('fetching_related_record');

        ele.preventDefault();
    },
})
