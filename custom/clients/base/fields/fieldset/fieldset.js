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
 * A fieldset is a field that contains one or more child fields.
 * The hbs template sets the placeholders of child fields but the creation of
 * child fields reside in the controller.
 *
 * Accessibility is checked against each child field as well as the fieldset.
 * We do not hide the fieldset in the event that the fieldset is accessible and
 * all child fields are not.
 *
 * Supported properties:
 *
 * - {Array} fields List of fields that are part of the fieldset.
 * - {boolean} show_child_labels Set to `true` to show labels on child fields in
 * the record view.
 * - {boolean} inline Set to `true` to render the fieldset inline.
 * - {boolean} equal_spacing When in inline mode, setting `true` will make the
 * fields inside fieldsets to have equal spacing, rather than being left aligned.
 *
 * Example usage:
 *
 *      array(
 *          'name' => 'date_entered_by',
 *          'type' => 'fieldset',
 *          'label' => 'LBL_DATE_ENTERED',
 *          'fields' => array(
 *              array(
 *                  'name' => 'date_entered',
 *              ),
 *              array(
 *                  'type' => 'label',
 *                  'default_value' => 'LBL_BY',
 *              ),
 *              array(
 *                  'name' => 'created_by_name',
 *              ),
 *          )
 *      )
 *
 * @class View.Fields.Base.FieldsetField
 * @alias SUGAR.App.view.fields.BaseFieldsetField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'FieldsetField',

    initialize: function (options) {
        this._super('initialize', [options]);
        Handlebars.registerHelper('containsSubStr', function (str, substring, options) {
            if (_.isNull(str) || _.isUndefined(str) || _.isNull(substring) || _.isUndefined(substring)) {
                return options.inverse(this);
            }

            str = str.toString();
            var pos = 0;
            var exist = false;

            while ((pos = str.indexOf(substring, pos)) > -1) {
                exist = true;
                break;
            }

            if (exist) {
                return options.fn(this);
            } else {
                return options.inverse(this);
            }
        });
    },

    _render: function () {
        this._super('_render');
    },
})
