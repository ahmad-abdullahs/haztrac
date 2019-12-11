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
 * @class View.Fields.Base.RadioenumField
 * @alias SUGAR.App.view.fields.BaseRadioenumField
 * @extends View.Fields.Base.EnumField
 */
({
    // On list-edit template,
    // we want the radio buttons to be replaced by a select so each method must call the EnumField method instead.
    extendsFrom: 'RadioenumField',
    plugins: ["ListEditable"],
    fieldTag: "input",
    setDisabled: function (disable) {
        this._super('setDisabled', [disable]);
        disable = _.isUndefined(disable) ? true : disable;
        if (disable) {
            this.$el.find('input').attr('disabled', true);
        } else {
            this.$el.find('input').attr('disabled', false);
        }
    },
})
