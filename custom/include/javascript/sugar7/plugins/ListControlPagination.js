/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
(function (app) {
    app.events.on('app:init', function () {
        app.plugins.register('ListControlPagination', ['view', 'field'], {
            showAll: false,
            paginateLimit: 5,
            currentSearch: "",
            formatFields: {},
            cursorInSearchBox: false,
            buttonPressed: false,
            onAttach: function () {
                this.events = _.extend({}, this.events, {
                    'click [data-action=show-all]': 'showAllRecords',
                    'blur .custom-list-search': 'searchBoxFocusOut',
                    'keyup .custom-list-search': 'throttledSearch',
                    'paste .custom-list-search': 'throttledSearch',
                    'click .clear-search': 'clearSearch',
                });
                this.on('fieldRendered', this.updateFilterControl, this);
            },
            onDetach: function () {
                this.off('fieldRendered', this.updateFilterControl, this);
            },
            searchBoxFocusOut: function (evt) {
                if (this.buttonPressed) {
                    this.buttonPressed = false;
                    return;
                }
                this.cursorInSearchBox = false;
                this.buttonPressed = false;
            },
            updateFilterControl: function () {
                if (_.isEmpty(this.currentSearch)) {
                    this.$('.clear-search').hide();
                } else {
                    this.$('.clear-search').show();
                }
                var input = this.$('.custom-list-search');
                var length = input.val().length;
                if (this.cursorInSearchBox) {
                    input[0].focus();
                    input[0].setSelectionRange(length, length);
                }
            },
            clearSearch: function (e) {
                this.$('.custom-list-search').val('');
                this.$('.clear-search').hide();
                this.throttledSearch(this.$('.custom-list-search'));
            },
            throttledSearch: _.debounce(function (e) {
                this.cursorInSearchBox = true;
                this.buttonPressed = true;
                var $el = $(e.currentTarget);
                var newSearch = $el.val();
                if (this.currentSearch !== newSearch) {
                    this.currentSearch = newSearch;
                    this.showAllRecords();
                }
            }, 400),
            /**
             * Show All records for this subpanel
             */
            showAllRecords: function () {
                this.showAll = true;
                this._render();
            },
            /**
             * Set collection according to view limit.
             */
            prepareCollectionForView: function () {
                this.viewFilteredCollection = new Backbone.Collection();
                var limit = this.filteredCollection.models.length;
                if (!this.showAll) {
                    limit = this.paginateLimit || 5;
                }
                if (limit >= this.filteredCollection.models.length) {
                    limit = this.filteredCollection.models.length;
                    this.showAll = true;
                }
                var indexC = 1;
                for (var i = 0; i < limit; i++) {
                    var model = this.filteredCollection.models[i];
                    var fulfilFilter = this.checkModelForFilter(model);
                    if (fulfilFilter) {
                        model.set('indexC', indexC);
                        indexC++;
                        this.viewFilteredCollection.add(model);
                    }
                }
            },
            checkModelForFilter: function (model) {
                var currentSearch = this.currentSearch || "";
                currentSearch = currentSearch.toString().toLowerCase();
                var pass = false;
                if (!_.isEmpty(currentSearch)) {
                    _.each(this.columnsMeta, function (fieldMeta) {
                        var name = fieldMeta.name || "";
                        if (model.has(name) && name != 'indexC') {
                            var val = model.get(name) || "";
                            val = val.toString().toLowerCase();
                            var isMatched = this.checkForFrontValue(currentSearch, val, fieldMeta, name, model);
                            if (isMatched) {
                                pass = true;
                            }
                        }
                    }, this);

                } else {
                    pass = true;
                }
                return pass;
            },
            checkForFrontValue: function (currentSearch, val, fieldMeta, name, model) {

                var type = fieldMeta.type || "base";
                var fieldType = this.formatFields[type] || false;
                if (fieldType == false) {
                    this.formatFields[type] = app.view.createField({
                        def: fieldMeta,
                        view: this.view,
                        viewName: this.view.options.viewName,
                        model: model
                    });
                    fieldType = this.formatFields[type];
                }
                var formattedVal = fieldType.format(val) || "";
                if (type == "enum") {
                    var options = fieldMeta.options || "";
                    var appListStrings = app.lang.getAppListStrings(options) || {};
                    formattedVal = appListStrings[model.get(name)] || "";
                }
                formattedVal = formattedVal.toString().toLowerCase();
                return (val.indexOf(currentSearch) !== -1 || formattedVal.indexOf(currentSearch) !== -1);
            },
        });
    });
})(SUGAR.App);