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
        this.plugins = _.union(this.plugins || [], ['WasteProfilePlugin']);
        this._super('initialize', [options]);
        this.fieldsDataChangeBinding();
        app.api.call('read', app.api.buildURL('getWasteProfileNum'), {}, {
            success: function (data) {
                self.model.set('waste_profile_num_c', data);
            },
            error: function (e) {
                throw e;
            }
        });
    }
})
