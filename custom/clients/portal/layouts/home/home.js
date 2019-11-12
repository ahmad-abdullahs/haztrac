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
    tabsHTML: '',
    initialize: function (options) {
        // Add the Tabs at the top.
        this.tabsHTML = '<span class="" title="Dashboard">' +
                '<div class="dropdown-menu scroll headerpane" style="top: 43px;height: 35px;min-height: 25px;">' +
                '<ul class="nav nav-tabs custom-dashlet-tabs" id="tabsUL" role="menu" style="' +
                'white-space: nowrap;' +
                'overflow-x: scroll;' +
                'overflow-y: hidden;' +
                'width: 100%;' +
                'height: 47px;' +
                'position: inherit;">' +
                '</ul>' +
                '</div>' +
                '</span>';
        // the home module doesn't have a proper module on the context because it has a context
        // of mixed module types
        // set the current module to home to get the mega menu to highlight correctly
        app.controller.context.set('module', 'Home');
        // Figure out the modules that are available to the user. omit home because it doesn't exist
        this.module_list = _.without(app.metadata.getModuleNames({filter: 'display_tab', access: 'list'}), 'Home');
        this.module_list = _.union([
            "Accounts",
            "sales_and_services",
            "WPM_Waste_Profile_Module",
            "WT_Waste_Tracking",
            "HT_PO"
        ], this.module_list);
        options.meta.components = [];
        // Add components metadata as specified in the module list
        _.each(this.module_list, function (module) {
            options.meta.components.push({
                layout: 'portal-list',
                context: {limit: 5, module: module}
            });
        }, this);

        this._super('initialize', [options]);

        this.context.get('model').dataFetched = true;
        this.context.get('collection').dataFetched = true;
    },

    /**
     * This _placeComponent is copied from {View.Layouts.Base.DashboardLayout}
     * since we want the HTML for portal home to mirror the HTML for
     * dashboards. This was done so we could reuse the same CSS for both.
     *
     * @param {app.view.Component} component
     * @private
     * @override
     */
    _placeComponent: function (component) {
        var dashboardEl = this.$('[data-section]');
        var css = this.context.get('create') ? ' edit' : '';

        if (dashboardEl.length === 0) {
            dashboardEl = $('<div></div>').attr({
                'class': 'cols row-fluid',
                'style': 'margin-top:50px;',
            });
            this.$el.append(
                    $('<div id="dashboardsList"></div>')
                    .addClass('dashboard' + css)
                    .attr({'data-section': 'true'})
                    .append(dashboardEl)
                    );
            // Append the tabs in the dashboardsList div
            dashboardEl.append(this.tabsHTML);
        } else {
            dashboardEl = dashboardEl.children('.row-fluid');
        }

        dashboardEl.append(component.el);

        // Get Style for tabs
        var style = this.getStyleConfig(component);
        var liButton = $('<li data-identifier="' + component.module + '" class="' + style.liClass + '">' +
                '<a class="ellipsis_inline" tabindex="-1" href="javascript:void(0);" data-route="javascript:void(0);" style="border: 1px solid rgba(0,0,0,0.1);" data-original-title="" title="">' +
                '<i class="' + style.tabIcon + '"></i>' +
                app.lang.getModuleName(component.module) +
                '</a>' +
                '</li>');
        $('#tabsUL').append(liButton);

        if (component.module != 'Accounts') {
            component.$el.hide();
        }

        this.bindOnClick(liButton);
    },

    getStyleConfig: function (component) {
        var liClass = '';
        if (component.module == 'Accounts') {
            liClass = "active";
        }

        var tabIcon = 'fa fa-th';
        if (_.contains(['Cases', 'Bugs', 'HT_PO'], component.module)) {
            tabIcon = 'fa fa-plus';
        }

        return {
            liClass: liClass,
            tabIcon: tabIcon,
        };
    },

    bindOnClick: function (liButton) {
        liButton.on('click', _.bind(function (ele) {
            // Make rest of the tab in-active except for the clicked one
            _.each($('li[data-identifier!=""][data-identifier]'), function (e) {
                if ($(e).data('identifier') != $(ele.currentTarget).data('identifier')) {
                    $(e).removeClass('active');
                } else {
                    // Make the current clicked tab active
                    $(e).addClass('active');
                }
            });
            // Show the appropriate panel for that tab and hide the others
            var panelIdentifier = $(ele.currentTarget).data('identifier');
            _.each($('div.thumbnail'), function (ele) {
                if ($(ele).find('a[href="#' + panelIdentifier + '"]').length) {
                    $(ele).show();
                } else {
                    $(ele).hide();
                }
            });
        }));
    },

})
