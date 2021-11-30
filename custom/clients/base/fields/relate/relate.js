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
        this.bannedFields = ['assigned_user_name', 'modified_by_name', 'created_by_name', 'custom_user_name'];
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
                if (!_.isEmpty(id) && this.def['eye-icon'] != false) {
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

    format: function (value) {

        var parentCtx = this.context && this.context.parent,
                setFromCtx;

        if (value || this.noAutoPopulate) {
            /**
             * Flag to indicate that the value has been set from the context
             * once, so if later the value is unset, we don't set it again on
             * {@link #format}.
             *
             * @type {boolean}
             * @protected
             */
            this._valueSetOnce = true;
        }

        // This check sees if we should populate the field from the context.
        // Note that this is a different condition from if we should populate
        // the field from a parent model.
        //
        // Also note that readonly fields are not automatically populated from
        // the context.
        setFromCtx = value === null && !this.fieldDefs.readonly &&
                !this._valueSetOnce && parentCtx && _.isEmpty(this.context.get('model').link) &&
                this.view instanceof app.view.views.BaseCreateView &&
                parentCtx.get('module') === this.def.module &&
                this.module !== this.def.module;

        if (setFromCtx) {
            this._valueSetOnce = true;
            var model = parentCtx.get('model');
            // FIXME we need a method to prevent us from doing this
            this.def.auto_populate = true;
            // FIXME the setValue receives a model but not a backbone model...
            this.setValue(model.toJSON());
            // FIXME we need to iterate over the populated_ that is causing
            // unsaved warnings when doing the auto populate.
        }

        if (!this.def.isMultiSelect && this.action !== 'edit' && !this.context.get('create')) {
            this._buildRoute();
        }

        var idList = this.model.get(this.def.id_name);
        if (_.isArray(value)) {
            this.formattedRname = value.join(this._separator);
            this.formattedIds = idList.join(this._separator);
        } else {
            this.formattedRname = value;
            this.formattedIds = idList;
        }

        return value;
    },

    openSelectDrawer: function () {
        var layout = 'selection-list';
        var context = {
            module: this.getSearchModule(),
            fields: this.getSearchFields(),
            filterOptions: this.getFilterOptions()
        };

        if (!!this.def.isMultiSelect) {
            layout = 'multi-selection-list';
            _.extend(context, {
                preselectedModelIds: _.clone(this.model.get(this.def.id_name)),
                maxSelectedRecords: this._maxSelectedRecords,
                isMultiSelect: true
            });
        }

        if (this.options.context.get('parentModel')) {
            app.drawer.open({
                layout: layout,
                context: context,
                immediateParentModel: _.clone(this.options.context.get('parentModel')),
            }, _.bind(this.setValue, this));
        } else {
            app.drawer.open({
                layout: layout,
                context: context,
            }, _.bind(this.setValue, this));
        }
    },
})
