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
    initialize: function(view) {
        this._super('initialize', arguments);
        this.currentModule = "Accounts";
        this.availableFields = this.getAllAvailableFields(this.currentModule);

        //Determines which fields should be 'checked' by default
        this.defaultPanelFields = app.hint.getVisibleFieldsFromAllPannelsForDefaultSelection(this.currentModule);

        var self = this;
        app.events.on('hint:config:module:changed', function(data) {
            self.currentModule = data.module;
            self.availableFields = self.getAllAvailableFields(data.module);
            self.defaultPanelFields = data.metadata.basicFields.concat(data.metadata.expandedFields);
            self.render();
        });

        app.events.on('hint:config:defaults:restored', function(data) {
            self.availableFields = self.getAllAvailableFields(self.currentModule);
            self.defaultPanelFields = data.metadata.basicFields.concat(data.metadata.expandedFields);
            self.render();
        });
    },

    events: {
        'click .fieldSelector': 'fieldToggled'
    },

    /**
     * The following guard is made for users of Hint version less than 5.1.
     * Name and website are duplicates from the main panel, but below 5.1
     * they could be enabled on the extended panel through Layout configuration.
     * 
     * @param {Array} allFields The full list of field definitions for the field selector.
     * @returns {Array} The list of field definitions for the field selector without some duplicate fields.
     */
    excludeMainPanelFields: function(allFields) {
        var excludedFields = ['name', 'website'];
        return _.reduce(excludedFields, function(fields, fieldName) {
            return _.without(fields, _.findWhere(fields, { name: fieldName }));
        }, allFields);
    },

    /**
     *
     * @param module
     * @returns {*[]}
     */
    getAllAvailableFields: function(module) {
        var results = [];
        var fields = app.hint.getModuleFieldsAvailableForSelection(module);
        var selectableFields = this.excludeMainPanelFields(fields);

        _.each(selectableFields, function(field) {
            field.disabled = this.isFieldDisabled(module, field.name);

            if (!field.label || field.label === "") {
                console.log("Missing field for label: " + field.name);
                return;
            }

            results.push(field);
        }, this);

        return results;
    },

    /**
     * These are default fields that should not be selectable, should move this to metadata
     * @param module
     * @param field
     */
    isFieldDisabled: function(module, field) {
        var disabledFields = {
            'Accounts': [],
            'Contacts': ['full_name', 'title', 'hint_photo_c', 'account_name', 'hint_account_website_c', 'picture', 'hint_education_2_c'],
            'Leads': ['full_name', 'title', 'hint_photo_c', 'account_name', 'picture', 'hint_education_2_c']
        };
        return disabledFields[module] && _.contains(disabledFields[module], field);
    },

    /**
     *
     * @param module
     * @returns {Array}
     */
    getHintFieldsFromMeadata: function(module) {
        var hintFields = [];
        var allFields = App.metadata.getModule(module).fields

        _.each(allFields, function(field) {
            if (field.name && field.name.match(/^hint_[\w]*_c/gi)) {
                field.label = app.lang.get(field.vname, module);
                hintFields.push(field);
            }
        });

        return hintFields;
    },

    _render: function() {
        this._super('_render');

        //Select our default fields...
        _.each(this.defaultPanelFields, function(field) {
            $('.field-container-' + field.name).prop('checked', true);
        });
    },

    /**
     *
     * @param el
     */
    fieldToggled: function(el) {
        var fieldName = el.currentTarget.id;
        var fullField = _.find(this.availableFields, function(f) {
            return f.name == fieldName;
        })

        if (el.currentTarget.checked) {
            app.events.trigger('hint:config:fieldAdded', fullField);
        } else {
            app.events.trigger('hint:config:fieldRemoved', fullField);
        }
    }
});
