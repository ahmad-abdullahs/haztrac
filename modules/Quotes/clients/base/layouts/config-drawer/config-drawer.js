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
 * @class View.Layouts.Base.Quotes.ConfigDrawerLayout
 * @alias SUGAR.App.view.layouts.BaseQuotesConfigDrawerLayout
 * @extends View.Layouts.Base.ConfigDrawerLayout
 */
({
    /**
     * @inheritdoc
     */
    extendsFrom: 'BaseConfigDrawerLayout',

    /**
     * Checks Quotes ACLs to see if the User is a system admin, admin,
     * or if the user has a developer role for the Quotes module
     *
     * @inheritdoc
     */
    _checkModuleAccess: function() {
        var acls = app.user.getAcls().Quotes;
        var isSysAdmin = (app.user.get('type') === 'admin');
        var isAdmin = !_.has(acls, 'admin');
        var isDev = !_.has(acls, 'developer');

        return (isSysAdmin || isAdmin || isDev);
    },

    /**
     * Checks if there's actually config in the metadata for the current module
     * todo: remove this function once config data is actually in the application.
     *
     * @return {boolean}
     * @private
     */
    _checkConfigMetadata: function() {
        //todo: remove this function once config data is actually in the application.
        return true;
    },

    /**
     * @inheritdoc
     */
    loadData: function() {
        if (this._checkModuleAccess()) {
            app.api.call(
                'read',
                app.api.buildURL('Quotes', 'config'),
                null,
                {
                    success: _.bind(this.onConfigSuccess, this)
                }
            );
        }
    },

    /**
     * Success handler for when loadData returns
     *
     * @param {Object} data The server response
     */
    onConfigSuccess: function(data) {
        this.context.set(data);
    }
})
