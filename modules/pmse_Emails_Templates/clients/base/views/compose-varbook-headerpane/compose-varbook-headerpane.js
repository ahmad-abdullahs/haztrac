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
    extendsFrom: "HeaderpaneView",

    events: {
        "click [name=done_button]":   "_done",
        "click [name=cancel_button]": "_cancel"
    },

     /**
      * The user clicked the Done button so trigger an event to add selected recipients from the address book to the
      * target field and then close the drawer.
      *
      * @private
      */
     _done: function() {
        var selectedList = this.selectList(this.collection.models);
        !_.isEmpty(selectedList) ? app.drawer.close(selectedList) : this._cancel();
     },

    /**
     * Close the drawer.
     *
     * @private
     */
    _cancel: function() {
        app.drawer.close();
    },

    /**
     * Creates and returns a list of all the fields the User selected for either
     * Current, Old or Both values.
     * If the value is Both there will be 2 models with the values Current and Old
     * for the same field.
     * Current translates to future on the backend.
     *
     * @param {Object} models List of all the modules.
     * @return {Object} selectedList.
     */
    selectList: function(models) {
        var selectedList = [];
        var i;
        var old;
        var future;
        for (i = 0 ; i < models.length; i++) {
            if (models[i].attributes.process_et_field_type === 'none') {
                continue;
            }

            if (models[i].attributes.process_et_field_type == 'both') {
                // Get clones of the model for old and new
                future = models[i].clone();
                old = models[i].clone();

                // Set the field type for the current field
                future.attributes.process_et_field_type = 'future';

                // Set the field type for the old field
                old.attributes.process_et_field_type = 'old';

                // Add them to the stack
                selectedList.push(future);
                selectedList.push(old);
            } else {
                // Since this is one or the other, take it as is
                selectedList.push(models[i]);
            }
        }
        return selectedList;
    }
})
