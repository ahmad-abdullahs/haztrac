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
    /*
     * custom/modules/Opportunities/clients/base/views/archive-service/archive-service.js 
     */
    extendsFrom: 'RecordView',
    initialize: function (options) {
        var previewMeta = app.metadata.getView(options.module, options.name);

        this._super('initialize', [options]);

        this.meta = _.extend(this.meta, previewMeta);
        this.fieldss = [];
        app.view.View.prototype.initialize.call(this, options);
        if (this.meta.panels) {
            _.each(this.meta.panels, function (panel, i) {
                _.each(panel.fields, function (fieldViewMeta, i) {
                    var fieldName = fieldViewMeta.name;
                    var extendedObj = {};
                    var fieldVardef = this.model.fields[fieldName] || {};
                    var fieldMeta = _.extend({}, fieldVardef, fieldViewMeta, extendedObj);
                    this.fieldss.push(fieldMeta);
                }, this);
            }, this);
        }

        this.model.isNotEmpty = true;
        this.meta.useTabsAndPanels = false;
        this.model = this.context.parent.get('model');
    },
    render: function () {
        this._super('render');
    },
    bindDataChange: function () {
        this._super('bindDataChange');
    },
})
