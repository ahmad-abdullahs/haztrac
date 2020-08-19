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
    extendsFrom: 'BaseField',
    columnsMeta: null,
    columns: null,

    initialize: function (options) {
        this._super('initialize', [options]);
        this.columns = this.def.columns;
        this.columnsMeta = this.getColumnsMeta();
    },

    _render: function () {
        this._super('_render');
        this.renderSubpanelFields();
    },

    /**
     * Render subpanel fields by getting their sfuuid.
     */
    renderSubpanelFields: function () {
        var self = this;
        $('td>span[sfuuid]').each(function () {
            var $this = $(this),
                    sfId = $this.attr('sfuuid');
            var field = self.view.fields[sfId];
            if (field) {
                field.setElement($this || self.$("span[sfuuid='" + sfId + "']"));
                field.listControlField = true;
                try {
                    field.render();
                } catch (e) {
                }
            }
        });
    },

    bindDataChange: function () {
        this._super('bindDataChange');
        this.model.on('data:sync:complete', function () {
            this.render();
        }, this);
    },

    _loadTemplate: function () {
        this._super('_loadTemplate');
        if (this.view.name == 'preview') {
            var template = app.template.getField(this.type, 'preview', this.model.module);
            this.template = template || this.template;

            // Primary team... 
            _.each(this.model.get('team_name'), function (team) {
                if (team.primary) {
                    this.model.set('primary_team_name', team.name);
                }
            }, this);
        }
    },

    /**
     * Get each field meta from model vardefs
     */
    getColumnsMeta: function () {
        var meta = new Array;
        var fieldsDef = app.metadata.getModule(this.module, "fields");
        _.each(this.columns, function (fieldViewMeta) {
            var fieldVardef = App.utils.deepCopy(fieldsDef[fieldViewMeta.name] || {});
            var fieldMeta = _.extend(fieldVardef, fieldViewMeta);
            meta.push(fieldMeta);
        }, this);
        return meta;
    },
})
