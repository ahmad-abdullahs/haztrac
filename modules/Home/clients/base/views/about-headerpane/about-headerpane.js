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
 * @class View.Views.Base.Home.AboutHeaderpaneView
 * @alias SUGAR.App.view.views.BaseHomeAboutHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'HeaderpaneView',

    /**
     * @override
     *
     * Formats the title with the current server info.
     */
    _formatTitle: function(title) {
        var serverInfo = app.metadata.getServerInfo();
        return app.lang.get(title, this.module, serverInfo) + this._getMarketingVersion(serverInfo.marketing_version);
    },

    /**
     * Gets the marketing version, formatted for presentation on the UI
     * @param {string} ver The marketing version before formatting
     * @return {string}
     * @private
     */
    _getMarketingVersion: function(ver) {
        // If ver is null or undefined, reset it
        ver = ver || '';

        // Clean it up for sanity
        ver = ver.trim();

        // If the version has content, wrap it in parens
        if (ver !== '') {
            ver = ' (' + ver + ')';
        }

        return ver;
    }
})
