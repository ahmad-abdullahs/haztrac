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
 * @class View.Views.Base.HintConfigHeaderButtonsView
 * @alias SUGAR.App.view.views.BaseHintConfigHeaderButtonsView
 * @extends View.Views.Base.ConfigHeaderButtonsView
 */
({
    extendsFrom: 'ConfigHeaderButtonsView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        var self = this;
        app.api.call('read', this._getSaveConfigURL(), null, {
            success: function(config) {
                config = config || {};
                config.logger = config.logger || {};
                self.model = self.model || app.data.createBean();
                self.model.set('logger_level', config.logger.level || 'alert');
            },
            error: function(err) {
                console.log('Error fetching configuration', err);
            }
        });
    },

    /**
     * @inheritdoc
     */
    cancelConfig: function() {
        this._super('cancelConfig');

        app.router.navigate(this.module, {trigger: true});
    },

    /**
     * @inheritdoc
     */
    showSavedConfirmation: function(onClose) {
        onClose = onClose || function() {};
        var alert = app.alert.show('module_config_success', {
            level: 'success',
            title: app.lang.get('LBL_HINT_CONFIG', 'Administration') + ':',
            messages: app.lang.get('LBL_HINT_CONFIG_SAVED', 'Administration'),
            autoClose: true,
            autoCloseDelay: 5000,
            onAutoClose: _.bind(function() {
                alert.getCloseSelector().off();
                onClose();
            })
        });
        var $close = alert.getCloseSelector();
        $close.on('click', onClose);
        app.accessibility.run($close, 'click');
    },

    /**
     * @inheritdoc
     */
    _saveConfig: function() {
        app.api.call(
            'create',
            this._getSaveConfigURL(),
            this._getSaveConfigAttributes(),
            {
                success: _.bind(function() {
                    this.showSavedConfirmation();
                    if (app.drawer.count()) {
                        // close the drawer
                        app.drawer.close(this.context, this.context.get('model'));
                        // config changed... reload metadata
                        app.sync();
                    }

                    // we navigate anyway
                    app.router.navigate(this.module, {trigger: true});
                }, this),
                error: _.bind(function() {
                    this.getField('save_button').setDisabled(false);
                }, this)
            }
        );
    },

    /**
     * @inheritdoc
     */
    _getSaveConfigURL: function() {
        return app.api.buildURL('hint/config');
    },

    /**
     * @inheritdoc
     */
    _getSaveConfigAttributes: function() {
        return {
            logger: {
                level: this.model.get('logger_level')
            }
        };
    }
})
