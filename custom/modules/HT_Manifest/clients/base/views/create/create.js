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
    extendsFrom: 'CreateWithMultifileView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    bindDataChange: function () {
        this._super('bindDataChange');

        this.model.on("change:accounts_ht_manifest_1_name", _.bind(this.setManifestName, this, "accounts_ht_manifest_1_name"), this);
        this.model.on("change:manifest_no_actual_c", _.bind(this.setManifestName, this, "manifest_no_actual_c"), this);
        this.model.on("change:consolidate_c", _.bind(this.setManifestName, this, "consolidate_c"), this);
    },

    /*
     * Set the manifest name as per the format (Manifest Number | Consolidate | Accounts)
     * @param {type} innerFieldName
     * @param {type} model
     * @param {type} value
     * @returns {undefined}
     */
    setManifestName: function (innerFieldName, model, value) {
        var name = '';
        // Manifest Number | Consolidate | Accounts
        var manifest_no_actual_c = this.model.get('manifest_no_actual_c');
        var consolidate_c = this.model.get('consolidate_c');
        var accounts_ht_manifest_1_name = this.model.get('accounts_ht_manifest_1_name');

        if (manifest_no_actual_c) {
            name = manifest_no_actual_c;
        }
        if (consolidate_c) {
            if (name) {
                name = name + ' | ';
            }
            name = name + 'CONSOLIDATED';
        }
        if (accounts_ht_manifest_1_name) {
            if (name) {
                name = name + ' | ';
            }
            name = name + accounts_ht_manifest_1_name.toUpperCase();
        }

        this.model.set('name', name);
    }

})
