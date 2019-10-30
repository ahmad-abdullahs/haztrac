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
    extendsFrom: 'BaseView',
    events: {},
    filterCollection: [],
    _currentFilterId: '',
    initialize: function (opts) {
        this.filterCollection = [];
        this._currentFilterId = '';
        this.events = {};

        opts.layout.on('change:filter:tab', this.handleFilterChange, this);
        this._super("initialize", [opts]);
    },

    render: function () {
        if (!_.isUndefined(this.layout._components[0].filters) && !_.isNull(this.layout._components[0].filters)) {
            this._currentFilterId = this.context.get('currentFilterId');
            if (!_.isEmpty(this.layout._components[0].filters.models)) {
                this.filterCollection = this.layout._components[0].filters;
            } else if (!_.isEmpty(this.layout._components[0].filters.collection.models)) {
                this.filterCollection = this.layout._components[0].filters.collection;
                this.filterCollection.models = _.filter(this.layout._components[0].filters.collection.models, function (model) {
                    if (model.get('editable')) {
                        return true;
                    }
                    return false;
                });
            }
            this.addEventListeners(this.filterCollection);
        }

        this._super('render');
    },

    addEventListeners: function (collection) {
        if (!_.isUndefined(collection) && !_.isNull(collection))
            _.each(collection.models, function (model) {
                this.events['click a[data-id="' + model.get('id') + '"]'] = _.bind(function (evt) {
                    var filterID = this.$(evt.currentTarget).data('id');
                    var filterModel = this.filterCollection.get(filterID);

                    this.layout._components[0].trigger('filter:change:filter', this.$(evt.currentTarget).data('id'));
                    this.$el.find('ul > li > a:not(a[data-id="' + filterID + '"]) > i').removeClass('fa-check')
                            .addClass('fa-filter');
                    this.$(evt.currentTarget).find('i').removeClass('fa-filter').addClass('fa-check');
                    $('input.select2.search-filter').val(filterID);
                    this.layout.trigger('change:filter:badge', {
                        'id': filterID,
                        'text': filterModel.get('name'),
                    });
                }, this);
            }, this);
        this.delegateEvents(this.events);
    },

    handleFilterChange: function (id) {
        this.render();
    },

    _render: function () {
        this._super('_render');
    },
})