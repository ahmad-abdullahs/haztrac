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
    extendsFrom: 'ImageField',

    format: function(value) {
        return value;
    },

    _render: function() {

        this.model.fileField = this.name;
        app.view.Field.prototype._render.call(this);

        if (!_.isEqual(this.view.name, 'record') &&
            !_.isEqual(this.view.name, 'list') &&
            !_.isEqual(this.view.name, 'create')) {
            //Define default sizes
            this.width = 42;
            this.height = 42;

            if (_.isEqual(this.name, 'hint_account_logo_c')) {
                this.width = this.def.width / 2;
                this.height = 50;
            }
            if (_.isEqual(this.value, '')) {
                template = app.template.getField(this.type, 'module-icon', this._getModuleName());
                if (template) {
                    this.$('.image_field').replaceWith(template({
                        module: this.name === 'hint_account_logo_c' ? 'Accounts' : this._getModuleName(),
                        labelSizeClass: 'label-module-lg',
                        tooltipPlacement: app.lang.direction === 'ltr' ? 'right' : 'left'
                    }));
                }
            } else {
                //Resize widget before the image is loaded
                this.resizeWidth(this.width);
                this.resizeHeight(this.height);
                this.$('.image_field').removeClass('hide');
                //Resize widget once the image is loaded
                this.$('img').addClass('hide').on('load', $.proxy(this.resizeWidget, this));
            }
            return this;

        } else {
            this.$el.parent().addClass('hidden');
            return this;
        }
    },

    /**
     * Gets the record's module name.
     *
     * FIXME: This isn't the right way to do it. The
     * {@link View.Views.Base.HistorySummaryView} view should use a true
     * {@link Data.MixedBeanCollection} so we don't have to do this.
     *
     * @return {string} The module name.
     * @protected
     */
    _getModuleName: function() {
        if (this.view.name === 'history-summary') {
            return this.model.get('_module');
        }
        return this.module;
    },

});
