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
 * Custom RecordlistView used within Subpanel layouts.
 *
 * @class View.Views.Base.SubpanelListView
 * @alias SUGAR.App.view.views.BaseSubpanelListView
 * @extends View.Views.Base.RecordlistView
 */
({
    extendsFrom: 'SubpanelListView',

    /**
     * @override
     * @param {Object} options
     */
    initialize: function (options) {
        this._super("initialize", [options]);

        //Override the recordlist row template
        this.rowTemplate = app.template.getView('subpanel-list.row', 'RevenueLineItems');

        if (this.module == 'RevenueLineItems' && this.context.get('parentModule') == 'sales_and_services') {
            // Call the edit button trigger for subpanel row
            this.context.parent.on('edit:full:subpanel:cstm', this.editClicked, this);
        }
    },

    addFavorite: function () {
        // Don't add the favorite button incase of revenuelineitems subpannel under sales_and_services record view
        if (this.module == 'RevenueLineItems' && (this.context.get('parentModule') == 'sales_and_services'
                || this.context.get('parentModule') == 'Accounts')) {
            return;
        }

        var favoritesEnabled = app.metadata.getModule(this.module, "favoritesEnabled");
        if (favoritesEnabled !== false
                && this.meta.favorite && this.leftColumns[0] && _.isArray(this.leftColumns[0].fields)) {
            this.leftColumns[0].fields.push({type: 'favorite'});
        }
    },

    addActions: function () {
        this._super("addActions");

        // We change the type of cancel button inorder to add the listner in that so, it should 
        // hear the parent record cancel event and cancel all the subpanel rows. 
        if (!_.isUndefined(this.leftColumns[0])) {
            _.each(this.leftColumns[0].fields, function (field) {
                if (field.name == 'inline-cancel' && field.type == 'editablelistbutton') {
                    field.type = 'ears-up-editablelistbutton';
                }
            });
        }
    },

    _render: function () {
        this._super('_render');

        var sortableItems;
        var cssClasses;

        if (this.type == 'subpanel-list') {
            if (this.context.parent.get('module') == 'RevenueLineItems' && this.module == 'RevenueLineItems') {
                sortableItems = this.$('tbody');
                if (sortableItems.length) {
                    _.each(sortableItems, function (sortableItem) {
                        $(sortableItem).sortable({
                            // allow draggable items to be connected with other tbody elements
                            connectWith: 'tbody',
                            // allow drag to only go in Y axis direction
                            axis: 'y',
                            // the items to make sortable
                            items: 'tr.sortable',
                            // make the "helper" row (the row the user actually drags around) a clone of the original row
                            helper: 'clone',
                            // adds a slow animation when "dropping" a group, removing this causes the row
                            // to immediately snap into place wherever it's sorted
                            revert: true,
                            // the CSS class to apply to the placeholder underneath the helper clone the user is dragging
                            placeholder: 'ui-state-highlight',
                            // handler for when dragging starts
                            start: _.bind(this._onDragStart, this),
                            // handler for when dragging stops; the "drop" event
                            stop: _.bind(this._onDragStop, this),
                            // handler for when dragging an item into a group
                            over: _.bind(this._onGroupDragTriggerOver, this),
                            // handler for when dragging an item out of a group
                            out: _.bind(this._onGroupDragTriggerOut, this),
                            // the cursor to use when dragging
                            cursor: 'move'
                        });
                    }, this);
                }

                // wrap in container div for scrolling
                if (!this.$el.parent().hasClass('flex-list-view-content')) {
                    cssClasses = 'flex-list-view-content';
                    if (this.isCreateView) {
                        cssClasses += ' create-view';
                    }
                    this.$el.wrap(
                            '<div class="' + cssClasses + '"></div>'
                            );
                    this.$el.parent().wrap(
                            '<div class="flex-list-view left-actions quote-data-table-scrollable"></div>'
                            );
                }
            }
        }
    },

    _onDragStart: function (evt, ui) {
        // console.log('_onDragStart : ', this, evt, ui);
    },

    _onDragStop: function (evt, ui) {
        // console.log('_onDragStop : ', this, evt, ui);

        // Get the tr name which is moved, slpit its name to get the id out of that.
        // eg. RevenueLineItems_00000000-0000-0000-0000-000000000000
        // var id = $(ui.item[0]).attr('name').split('_')[1];

        // set the line number of the rows and save it, because ordering is important in subpanel.
        var lineNumber = 1;
        _.each(this.$('tbody > tr'), function (tr) {
            var name = $(tr).attr('name').split('_');
            var id = name[1];
            this.collection.get(id).set('line_number', lineNumber).save();
            lineNumber++;
        }, this);
    },

    _onGroupDragTriggerOver: function (evt, ui) {
        // console.log('_onGroupDragTriggerOver : ', this, evt, ui);
    },

    _onGroupDragTriggerOut: function (evt, ui) {
        // console.log('_onGroupDragTriggerOut : ', this, evt, ui);
    },

    /**
     * @override
     * @private
     */
    _dispose: function () {
        this.unbindBeforeRouteUnlink();
        this._super('_dispose');
    }
})
