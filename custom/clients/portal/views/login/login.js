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
 * Login form view.
 *
 * @class View.Views.Portal.LoginView
 * @alias SUGAR.App.view.views.PortalLoginView
 * @extends View.Views.Base.LoginView
 */
({
    extendsFrom: 'LoginView',

    initialize: function (options) {
        this._super('initialize', [options]);
        $(document).attr('title', 'HAZTRAC');
    },
})
