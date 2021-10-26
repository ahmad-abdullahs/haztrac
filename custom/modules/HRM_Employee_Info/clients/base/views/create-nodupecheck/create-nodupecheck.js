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
 * @class View.Views.Base.CreateNodupecheckView
 * @alias SUGAR.App.view.views.BaseCreateNodupecheckView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateNodupecheckView',

    initialize: function (options) {
        var self = this;
        this._super('initialize', [options]);
        app.api.call('read', app.api.buildURL('getEmployeeIdNum'), {}, {
            success: function (data) {
                self.model.set('employee_id_num', data);
            },
            error: function (e) {
                throw e;
            }
        });
    }
})
