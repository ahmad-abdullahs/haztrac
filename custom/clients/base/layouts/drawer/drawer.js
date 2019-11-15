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
 * @class View.Layouts.Base.DrawerLayout
 * @alias SUGAR.App.view.layouts.BaseDrawerLayout
 * @extends View.Layout
 */
({
    extendsFrom: 'DrawerLayout',
    afterOpenCallback: null,
    renderedComponent: null,
    initialize: function (options) {
        this.afterOpenCallback = [];
        this._super('initialize', [options]);
    },

    open: function (def, onClose, afterOpen) {
        var component;

        app.shortcuts.saveSession();
        if (!app.triggerBefore('app:view:change')) {
            return;
        }

        this._enterState(this.STATES.OPENING);

        //store the callback function to be called later
        if (_.isUndefined(onClose)) {
            this.onCloseCallback.push(function () {});
        } else {
            this.onCloseCallback.push(onClose);
        }

        //store the open callback function to be called later
        if (_.isUndefined(afterOpen)) {
            this.afterOpenCallback.push(function () {});
        } else {
            this.afterOpenCallback.push(afterOpen);
        }

        //initialize layout definition components
        this._initializeComponentsFromDefinition(def);

        component = _.last(this._components);

        this._updateFragments();

        //scroll both main and sidebar to the top
        this._scrollToTop();

        //open the drawer
        this._animateOpenDrawer(_.bind(function () {
            this._afterOpenActions(def);
        }, this));

        //load and render new layout in drawer
        component.loadData();
        component.render();
        this.renderedComponent = component;
    },

    /**
     * Remove all drawers and reset
     * @param trigger Indicates whether to triggerBefore (defaults to true if anything other than `false`)
     */
    reset: function (triggerBefore) {
        triggerBefore = triggerBefore === false ? false : true;
        if (triggerBefore && !this.triggerBefore("reset", {drawer: this})) {
            return false;
        }

        var $main = app.$contentEl.children().first();

        this._enterState(this.STATES.CLOSING);

        _.each(this._components, function (component) {
            component.dispose();
        }, this);

        this._components = [];
        this.onCloseCallback = [];
        this.afterOpenCallback = [];

        if ($main.hasClass('drawer')) {
            $main.removeClass('drawer inactive').removeAttr('aria-hidden').css('top', '');
            this._removeTabAndBackdrop($main);
        }

        $('body').removeClass('noscroll');
        app.$contentEl.removeClass('noscroll');

        this._enterState(this.STATES.IDLE);
    },

    /**
     * Trigger view change event and return to idle state.
     *
     * @private
     */
    _afterOpenActions: function () {
        var layout = _.last(this._components);

        // Forecasts config route uses the drawer but if user
        // does not have access, initialize is never called so the
        // context on the layout never gets set. Adding check to make
        // sure there actually is a context to use on the layout
        if (layout.context) {
            app.trigger('app:view:change', layout.options.type, _.extend(layout.context.attributes, {drawer: true}));
        }

        this._enterState(this.STATES.IDLE);

        var openCallback = this.afterOpenCallback.pop();
        if (openCallback) {
            openCallback(this.renderedComponent); //execute callback
        }
    },
})
