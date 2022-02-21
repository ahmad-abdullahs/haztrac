/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',

    initialize: function (options) {
        app.view.View.prototype.initialize.call(this, options);
        this.fieldDef = options.fieldDef;
        this.parentField = options.parent;
        if (this.layout) {
            this.layout.on('app:view:add-option-popup', function () {
                // Populate all the fields from parent model to context model.
                this.context.get('model').set(this.context.originalModel.attributes);
                this.render();

                this.$('.modal').modal({
                    backdrop: 'static'
                });
                this.$('.modal').modal('show');

                $('.datepicker').css('z-index', '999');
                app.$contentEl.attr('aria-hidden', true);
                $('.modal-backdrop').insertAfter($('.modal'));
            }, this);
        }
        var createModel = this.context.get('model');
        createModel.on('change:add_option_value', this.prepareKey, this);
        this.bindDataChange();
    },

    prepareKey: function () {
        let opVal = this.context.get('model').get('add_option_value');
        let opKey = opVal.replace(/['"]+/g, '').trim();
        this.context.get('model').set('add_option_key', opKey);
    },

    /**Overriding the base saveButton method*/
    saveButton: function () {
        // This event is triggered on the model because if we trigger it on the app level 
        // then there come the issue.
        // If the create view is open on top of the record view then both the views
        // starts listening the app event and trigger the edit.
        // Now calling on the model level, this will not be the issue becuase each view has
        // its own model.
        this.context.originalModel.trigger('editClicked');

        var createModel = this.context.get('model');

        var opVal = createModel.get('add_option_value');
        var opKey = createModel.get('add_option_key');

        this.addOption(opVal, opKey);

        this.saveComplete();
    },

    addOption: function (text, key) {
        var roleKeys = app.lang.getAppListKeys(this.fieldDef.options);

        if (!_.contains(roleKeys, key)) {
            app.alert.show('adding_option', {
                level: 'warning',
                title: 'Adding the New Option, Please wait until the Option is added and success message is delivered.'
            });
            this.parentField.items[key] = text;
            this.render();

            app.api.call('create', app.api.buildURL('DropdownListKey/add'), {
                "list_name": this.fieldDef.options,
                "item_key": key,
                "item_value": text,
                "lang": "en_us",
            }, {
                success: function (data) {
                    app.metadata.sync(function () {
                        app.alert.dismiss('adding_option');
                        app.alert.show('new_option_added', {
                            level: 'info',
                            autoClose: true,
                            messages: 'New Option (' + text + ') is added to the list.',
                        });
                    });
                },
                error: function (e) {
                    throw e;
                }
            });
        } else {
            app.alert.show('option_already_exist', {
                level: 'info',
                autoClose: true,
                messages: 'Option already exist.',
            });
        }
    },

    /**Overriding the base cancelButton method*/
    cancelButton: function () {
        this._super('cancelButton');
        app.$contentEl.removeAttr('aria-hidden');
        this._disposeView();
    },

    /**Overriding the base saveComplete method*/
    saveComplete: function () {
        //reset the form
        this.$('.modal').modal('hide').find('form').get(0).reset();
        this.context.get('model').set({add_option_value: '', add_option_key: ''});
        //reset the `Save` button
        this.disableButtons(false);
        app.$contentEl.removeAttr('aria-hidden');
        this._disposeView();
    },

    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {
            name: 'add-option-popup'
        }));

        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
})