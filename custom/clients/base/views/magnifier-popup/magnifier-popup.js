/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',

    initialize: function (options) {
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:magnifier-popup', function () {
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

        this.bindDataChange();
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

        _.each(createModel.changed, function (val, key) {
            this.context.originalModel.set(key, val);
        }, this);

        this.saveComplete();
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
        //reset the `Save` button
        this.disableButtons(false);
        app.$contentEl.removeAttr('aria-hidden');
        this._disposeView();
    },

    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {
            name: 'magnifier-popup'
        }));

        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
})