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
 * @class View.Layouts.Base.ConfigDrawerLayout
 * @alias SUGAR.App.view.layouts.BaseConfigDrawerLayout
 * @extends View.Layout
 */
({
    plugins: ['Stage2CssLoader'],

    css: [
        'hint-preview',
        'hint-config'
    ],

    events: {
        'click .restoreDefaults': 'restoreDefaults',
    },

    initialize: function(view) {
        var that = this;
        this._super('initialize', arguments);
        var ctx = this.context;

        this.currentModule = "Accounts"; //Default module we always start with

        this.hintConfig = app.metadata.getModule(this.currentModule, 'config');
        this.configKey = 'hintConfig';

        this.modulesMetaData = [{
            module: 'accounts',
            'basicFields': app.hint.getAccountBasicPanelFields(),
            'expandedFields': app.hint.getAccountExpandedPanelFields()
        }, {
            module: 'contacts',
            'basicFields': app.hint.getPeopleBasicPanelFields('Contacts'),
            'expandedFields': app.hint.getPeopleExpandedPanelFields('Contacts')
        }, {
            module: 'leads',
            'basicFields': app.hint.getPeopleBasicPanelFields('Leads'),
            'expandedFields': app.hint.getPeopleExpandedPanelFields('Leads')
        }];

        app.events.on('hint:config:save', this._saveConfig, this);

        app.events.on('hint:config:fieldRemoved', function(fieldRemoved) {
            _.each(that.modulesMetaData, function(moduleMetaData) {

                if (moduleMetaData.module.toLowerCase() == that.currentModule.toLowerCase()) {

                    moduleMetaData.basicFields = _.without(moduleMetaData.basicFields, _.findWhere(moduleMetaData.basicFields, {
                        name: fieldRemoved.name
                    }));

                    moduleMetaData.expandedFields = _.without(moduleMetaData.expandedFields, _.findWhere(moduleMetaData.expandedFields, {
                        name: fieldRemoved.name
                    }));
                }
            });
            this.render();
        }, this);

        app.events.on('hint:config:fieldAdded', function(fieldAdded) {
            var that = this;
            _.each(this.modulesMetaData, function(metadata) {
                if (metadata.module == that.currentModule.toLowerCase()) {

                    var existsInBasicPanel = _.find(metadata.basicFields, function(field) {
                        return field == fieldAdded
                    });

                    var existsInExtendedPanel = _.find(metadata.expandedFields, function(field) {
                        return field == fieldAdded
                    });

                    if (!existsInBasicPanel && !existsInExtendedPanel) {
                        metadata.expandedFields.push(fieldAdded);
                    }

                }
            })
            this.render();
        }, this);
    },

    restoreDefaults: function(event) {
        var that = this;
        event.preventDefault();
        this.modulesMetaData = [{
            module: 'accounts',
            'basicFields': app.hint.getAccountDefaultBasicPanelFields(),
            'expandedFields': app.hint.getAccountDefaultExpandedPanelFields()
        },
        {
            module: 'contacts',
            'basicFields': app.hint.getPeopleDefaultBasicPanelFields('Contacts'),
            'expandedFields': app.hint.getPeopleDefaultExpandedPanelFields('Contacts')
        }, {
            module: 'leads',
            'basicFields': app.hint.getPeopleDefaultBasicPanelFields('Leads'),
            'expandedFields': app.hint.getPeopleDefaultExpandedPanelFields('Leads')
        }];

        this.render();

        app.events.trigger('hint:config:defaults:restored', { module: this.currentModule, metadata: that._getMetadataForModule(that.currentModule) });
    },

    _getMetadataForSaving: function(module) {
        var basicPanelFields = [];
        var expandedPanelFields = [];

        //Get all the fields from the dom and their order.
        $("div#" + module.toLowerCase() + "-basic-panel").find("div.configurable > div.row-fluid").each(function(index) {
            basicPanelFields.push($(this).data('name'));
        });

        $("div#" + module.toLowerCase() + "-expanded-panel").find("div.configurable > div.row-fluid").each(function(index) {
            expandedPanelFields.push($(this).data('name'));
        });

        return { 'basic': basicPanelFields, 'expanded': expandedPanelFields };
    },

    /**
     * @inheritdoc
     */
    _saveConfig: function(el) {

        if (typeof ($('.hint-config-save').attr("disabled")) !== "undefined") {
            return;
        }

        $('.hint-config-save').attr("disabled", "disabled");
        var that = this;
        var modulesToSave = ['Accounts', 'Contacts', 'Leads'];

        var metadataToSave = {};
        _.each(modulesToSave, function(module) {

            metadataToSave[module] = that._getMetadataForSaving(module);

        });

        /**
         * We need to save each configuration in a serial call so we don't blow up the metadata hash.  This is a platform limitation that
         * we must work around.
         */
        async.forEachSeries(modulesToSave, function(module, callback) {
            var url = app.api.buildURL(module, 'config');
            var attributes = {};
            attributes[that.configKey] = metadataToSave[module];

            // In order to save the different modules in a row this is necessary,
            // otherwise we'll get an error about the metadata being out of sync.
            var apiOptions = {
                skipMetadataHash: true
            };

            app.api.call('create', url, attributes, {
                success: _.bind(function() {
                    callback();
                }, this),
                error: _.bind(function(err) {
                    callback(err);
                }, this)
            }, apiOptions
            );
        },
            function(err) {
                if (err) {
                    console.log("Error saving configuration");
                } else {
                    if (app.drawer.count()) {
                        // close the drawer and return to the admin page
                        app.drawer.close(that.context, that.context.get('model'));

                        var backUrl = app.api.buildURL(that.module)
                        app.router.navigate(that.module, { trigger: true });

                        //We always require a hash sync and hard refresh
                        app.sync();
                        app.utils.hardRefresh();

                    } else {
                        app.router.navigate(that.module, { trigger: true });
                    }
                }
            }
        );

        return;
    },

    /**
     * @param currentModule
     * @private
     */
    _hidePanelsForOtherModules: function(currentModule) {
        var lowerCaseModule = '#' + currentModule.toLowerCase(),
            basicPanelToShow = lowerCaseModule + '-basic-panel',
            expandedPanelToShow = lowerCaseModule + '-expanded-panel',
            directionsPanelToShow = lowerCaseModule + '-directions';

        $('.hint-config-container').hide();
        $('.directions-container').hide();

        $(basicPanelToShow).show();
        $(expandedPanelToShow).show();
        $(directionsPanelToShow).show();
    },

    /**
     * Given our metadata and an array of sorted fields, return a copy of the metadata sorted with the same order
     * as the ordered fields.  O(n) time complexity.
     *
     * @private
     */
    _sortMetadataFields: function(metadataFields, sortedFields) {
        if (!sortedFields) {
            return metadata;
        }

        //Restructure to a hashmap for easy sorting
        var metadataFieldsByKey = {};
        for (var z = 0; z < metadataFields.length; z++) {
            var key = metadataFields[z].name;
            metadataFieldsByKey[key] = metadataFields[z];
        }

        var results = [];
        for (var x = 0; x < sortedFields.length; x++) {
            var currentField = sortedFields[x];

            if (typeof (metadataFieldsByKey[currentField]) !== 'undefined') {
                results.push(metadataFieldsByKey[currentField]);
            }
        }

        return results;
    },
    /**
     * Event handler for the sortstop "drop" event.  We need to resort the backing data
     * with what the dom is showing otherwise when we switch tabs or call any other render functionality
     * we'll loose the state.
     *
     * @param {jQuery.Event} evt The jQuery sortstop event
     * @param {Object} ui The jQuery Sortable UI Object
     * @private
     */
    _onDragStop: function(evt, ui) {
        var that = this;
        var sortedMetadata = that._getMetadataForSaving(this.currentModule);

        _.each(that.modulesMetaData, function(moduleMetaData) {

            if (moduleMetaData.module.toLowerCase() == that.currentModule.toLowerCase()) {
                var allMetadataFields = moduleMetaData.basicFields.concat(moduleMetaData.expandedFields);
                moduleMetaData.basicFields = that._sortMetadataFields(allMetadataFields, sortedMetadata['basic']);
                moduleMetaData.expandedFields = that._sortMetadataFields(allMetadataFields, sortedMetadata['expanded']);
            }
        });

    },

    /**
     *
     *
     * @private
     */
    _getMetadataForModule: function(module) {

        var that = this;
        return _.find(this.modulesMetaData, function(moduleMetaData) {

            return moduleMetaData.module.toLowerCase() == module.toLowerCase();
        });
    },

    _render: function() {
        var that = this;
        this._super('_render');

        that._hidePanelsForOtherModules(this.currentModule);

        //This will ensure that our panels are drag and drop enabled.
        $('.panel.configurable').sortable({
            items: 'div.row-fluid',
            // allow drag to only go in Y axis direction
            axis: 'y',
            // make the "helper" row (the row the user actually drags around) a clone of the original row
            helper: 'clone',
            // adds a slow animation when "dropping" a group, removing this causes the row
            // to immediately snap into place wherever it's sorted
            revert: 150,
            // the CSS class to apply to the placeholder underneath the helper clone the user is dragging
            placeholder: 'ui-state-highlight',
            // the cursor to use when dragging
            cursor: 'move',
            //All items to move to a different panel
            connectWith: ".panel.configurable",
            // handler for when dragging stops; the "drop" event
            stop: _.bind(this._onDragStop, this),
        });

        //Listen to tab changes for the tab events (module changed)
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("href") // activated tab
            var module = target.substring(1).charAt(0).toUpperCase() + target.substring(2);

            that._hidePanelsForOtherModules(module);
            that.currentModule = module;
            app.events.trigger('hint:config:module:changed', { module: module, metadata: that._getMetadataForModule(module) });
        });
    },
});
