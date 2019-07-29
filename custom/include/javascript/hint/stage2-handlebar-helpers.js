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
 * Handlebars helpers.
 *
 * These functions are to be used in handlebars templates.
 * @class Handlebars.helpers
 * @singleton
 */
(function(app) {

    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

    // Listen to message from child window so we know when to close
    eventer(messageEvent, function(e) {
        if (e.data === 'stage2-tour-end') {
            $("#hintTour").fadeOut(1500);
            $('body').remove('#hintTour');
        }
    }, false);

    // Make sure the hint tour would invoke only once.
    var addHintiFrameOnce = (function() {
        var executed = false;
        return function() {
            if (!executed) {
                executed = true;
                app.api.call('GET', app.api.buildURL('stage2/params'), null, {
                    success: function(data) {
                        if (data && data.serviceUrl) {
                            var t = '<iframe id="hintTour" src="https://s3-us-west-2.amazonaws.com/hint-package/tour.html" frameborder="0" style="z-index:2000;overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe>';
                            $('body').append(t);
                            $('#hintTour').fadeIn(1500, function() {
                                $('#hintTour').focus();
                            });
                            app.user.lastState.set('hintWelcomeTour', true);
                            app.user.lastState.preserve('hintWelcomeTour');
                        }
                    },
                    error: function(err) {
                        // This happens when hint get uninstalled and cache get cleared.
                        app.user.lastState.set('hintWelcomeTour', true);
                    }
                });
            }
        };
    })();

    app.events.on("app:init", function() {

        Handlebars.registerHelper("toUpperCase", function(str) {
            if (!str) {
                return str;
            }
            return str.toUpperCase();
        });

        // greater than
        Handlebars.registerHelper('hint_gt', function(a, b) {
            var next = arguments[arguments.length - 1];
            return (a > b) ? next.fn(this) : next.inverse(this);
        });

    });

    /**
     * Lookup a specific layout recursively. Recommended to call it with
     * app.controller.layout._components initially.
     * @param {string} module Current module
     * @param {string} view Current view
     * @param {Null/Object} layout The target layout
     * @param {Array} components List of child components
     */
    function getActiveLayout(module, view, layout, components) {
        _.each(components, function(cmp) {
            if (cmp.module === module && cmp.type === view) layout = cmp;
        });

        if (!layout) {
            _.each(components, function(cmp) {
                var shouldSearchDeeper = !layout && cmp._components && cmp._components.length > 0;
                if (shouldSearchDeeper) layout = getActiveLayout(module, view, layout, cmp._components);
            });
        }

        return layout;
    }

    function setAccountNameChangeListener(module, view) {
        if (module === 'Contacts' && view === 'create') {
            var createView,
                createLayout = app.drawer.getComponent('create');

            if (!createLayout) { // Create layout without an actual drawer
                var mainComponents = app.controller.layout._components;
                createLayout = getActiveLayout(module, view, null, mainComponents);
                createView = createLayout.layout;
            } else { // We have a standard create drawer
                createView = createLayout.getComponent('sidebar').getComponent('main-pane');
            }

            createLayout.model.on('change:account_name', function() {
                var hintModel = _.first(createView.collection.models);
                app.events.trigger('preview:close');
                app.events.trigger('preview:render', hintModel);
                app.events.trigger('hint:user-input', true);
            });
        }
    }

    app.events.on('app:view:change', function(view) {
        var _module = app.controller.context.get('module');

        setAccountNameChangeListener(_module, view);
        if (!app.user.lastState.get('hintWelcomeTour')) {
            if (_module === 'Leads' || _module === 'Contacts' || _module === 'Accounts' || _module === 'Home') {
                if ($('body').has('#hintTour').length === 0) {
                    addHintiFrameOnce();
                }
            }
        } else {
            if ($('body').has('#hintTour').length > 0) {
                $('body').remove('#hintTour');
            }
        }
    });
})(SUGAR.App); 
