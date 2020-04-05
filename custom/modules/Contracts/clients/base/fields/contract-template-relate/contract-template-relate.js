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
    extendsFrom: 'RelateField',
    initialize: function (options) {
        this._super("initialize", [options]);
    },

    /**
     * Handles update of related fields.
     *
     * @param {Object} model The source model attributes.
     */
    updateRelatedFields: function (model) {
        var newData = {},
                self = this;
        _.each(this.def.populate_list, function (target, source) {
            source = _.isNumber(source) ? target : source;
            if (!_.isUndefined(model[source]) && app.acl.hasAccessToModel('edit', this.model, target)) {
                var before = this.model.get(target),
                        after = model[source];

                if (before !== after) {
                    newData[target] = model[source];
                }
            }
        }, this);

        if (_.isEmpty(newData)) {
            return;
        }

        // if this.def.auto_populate is true set new data and doesn't show alert message
        if (!_.isUndefined(this.def.auto_populate) && this.def.auto_populate == true) {
            // if we have a currency_id, set it first to trigger the currency conversion before setting
            // the values to the model, this prevents double conversion from happening
            if (!_.isUndefined(newData.currency_id)) {
                this.model.set({currency_id: newData.currency_id});
                delete newData.currency_id;
            }
//            var generator_type_c = newData.generator_type_c;
//            delete newData.generator_type_c;
            //++
            $.when(this.model.set(newData)).then(function () {
                self.context.trigger('render:on-autopopulate:multirow:fields');
                // We have done it this way because otherwise it was triggering the setValue dependency...
//                this.model.set('generator_type_c', generator_type_c, {'silent': true})
            });
            return;
        }

        // load template key for confirmation message from defs or use default
        var messageTplKey = this.def.populate_confirm_label || 'TPL_OVERWRITE_POPULATED_DATA_CONFIRM',
                messageTpl = Handlebars.compile(app.lang.get(messageTplKey, this.getSearchModule())),
                fieldMessageTpl = app.template.getField(
                        this.type,
                        'overwrite-confirmation',
                        this.model.module),
                messages = [],
                relatedModuleSingular = app.lang.getModuleName(this.def.module);

        _.each(newData, function (value, field) {
            var before = this.model.get(field),
                    after = value;

            if (before !== after) {
                var def = this.model.fields[field];
                messages.push(fieldMessageTpl({
                    before: before,
                    after: after,
                    field_label: app.lang.get(def.label || def.vname || field, this.module)
                }));
            }
        }, this);

        app.alert.show('overwrite_confirmation', {
            level: 'confirmation',
            messages: messageTpl({
                values: new Handlebars.SafeString(messages.join(', ')),
                moduleSingularLower: relatedModuleSingular.toLowerCase()
            }),
            onConfirm: function () {
                // if we have a currency_id, set it first to trigger the currency conversion before setting
                // the values to the model, this prevents double conversion from happening
                if (!_.isUndefined(newData.currency_id)) {
                    self.model.set({currency_id: newData.currency_id});
                    delete newData.currency_id;
                }
                self.model.set(newData);
            }
        });
    },
})
