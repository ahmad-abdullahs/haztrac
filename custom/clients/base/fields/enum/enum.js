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
 * @class View.Fields.Base.EnumField
 * @alias SUGAR.App.view.fields.BaseEnumField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'EnumField',
    fieldTag: 'input.select2',
    appendValueTag: 'input[name=append_value]',
    isFetchingOptions: false,
    items: null,
    _keysOrder: null,
    initialize: function () {
        this._super('initialize', arguments);
    },

    _render: function () {
        this._super('_render');
        if (this.def.highlight) {
            var $el = this.$(this.fieldTag);
            $el.siblings('div').children('a').attr('style', 'background-color:' + this.def.backcolor + '; color:' + this.def.textcolor);
        }

        // Adding code for adding Create New Item Button
        if (this.view.name == 'record' || this.view.name == 'create') {
            var self = this;
            this.$(this.fieldTag).on('select2-open', function () {
                $(".select2-results:not(:has(a))").prepend('<a href="javascript:void(0);" style="padding: 6px;height: 20px;display: inline-table;width: 100%;text-align:center;" class="dd-add-new-option" data-name="' + self.def.name + '">Add New Item</a>');
                self.bindAddOptionHandler();
            });
        }
    },

    bindAddOptionHandler: function () {
        var self = this;
        $('.select2-results').find('.dd-add-new-option').each(function (e) {
            $(this).on('click', function (e) {
                if ($(this).data('name') === self.def.name) {
                    self.openAddOptionPopup();
                }
            });
        }, this);
    },

    openAddOptionPopup: function () {
        this.$(this.fieldTag).select2('close');
        /**add class content-overflow-visible if client has touch feature*/
        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }

        /**
         * Check whether the view already exists in the layout.
         * If not we will create a new view and will add to the components list of the record layout
         * */
        var addOptionPopupView = this.view.layout.getComponent('add-option-popup');
        if (!addOptionPopupView) {
            /** Prepare the context object for the add-option-popup view */
            var context = this.context.getChildContext({
                module: this.module,
            });

            context.prepare();
            context.originalModel = this.model;

            /** Create a new view object */
            addOptionPopupView = app.view.createView({
                context: context,
                name: 'add-option-popup',
                layout: this.view.layout,
                module: context.module,
                fieldDef: this.def,
                parent: this
            });

            /** add the new view to the components list of the record layout */
            this.view.layout._components.push(addOptionPopupView);
            this.view.layout.$el.append(addOptionPopupView.$el);
        }

        /** triggers an event to show the pop up add-option-popup view */
        this.view.layout.trigger("app:view:add-option-popup");
    },
})
