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
 * @class View.Views.Base.Opportunities.RecentUsedProductView
 * @alias SUGAR.App.view.views.BaseOpportunitiesRecentUsedProductView
 * @extends View.Views.Base.TabbedDashletView
 */
({
    extendsFrom: 'BaseTabbedDashletView',

    className: 'product-catalog-quick-picks',

    events: {
        'click [data-action=page-clicked]': 'getPageNumClicked',
        'click [data-action=tab-switcher]': 'tabSwitcher',
        'click [data-action=page-nav-clicked]': 'onPageNavClicked',
        'click .recent-link': 'onNameClicked',
        'click .recent-records i': 'onIconClicked'
    },

    //declaring global variables
    activeTab: undefined,
    dataFetched: undefined,
    pageNumList: undefined,
    pageNumClicked: undefined,
    paginationLength: undefined,
    isPrevDisabled: undefined,
    isNextDisabled: undefined,
    isPageNumDisabled: undefined,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.plugins = _.without(this.plugins, 'Pagination');
        this.plugins = _.union(this.plugins, 'Tooltip');
        this._super('initialize', [options]);

        this.pageNumClicked = 1;
        this.paginationLength = 0;

        this.activeTab = '';

        this.pageNumList = [];

        this.dataFetched = false;
        this.isPrevDisabled = false;
        this.isNextDisabled = false;
        this.isPageNumDisabled = false;

        this.recentCollection = new Backbone.Collection();
    },

    /**
     * Initialize tabs.
     * @chainable
     * @protected
     */
    _initTabs: function() {
        this._super('_initTabs');
        //Remove Recent used tabs for Opportunity Only mode
        if (app.controller.context.get('module') !== 'Quotes' || this.layout.module === 'Opportunities') {
            if (app.metadata.getModule('Opportunities', 'config').opps_view_by === 'Opportunities') {
                this.tabs = _.without(this.tabs, _.findWhere(this.tabs, {
                    label: 'LBL_DASHLET_PRODUCT_QUICK_PICKS_RECENT_TAB'
                }));
            }
        }
        return this;
    },

    /**
     * Get url for recent/favorites api
     */
    getUrl: function(payloadData) {
        var tab = this.tabs[this.settings.get('activeTab')];
        if (tab.label === 'LBL_DASHLET_PRODUCT_QUICK_PICKS_RECENT_TAB') {
            this.activeTab = 'recent-product';
        } else {
            this.activeTab = 'favorites';
        }

        if (this.layout.module === 'Home') {
            return app.api.buildURL(app.controller.context.get('module'), this.activeTab, null,
                this.activeTab === 'favorites' ? payloadData : null
            );
        } else {
            return app.api.buildURL(this.layout.module, this.activeTab, null,
                this.activeTab === 'favorites' ? payloadData : null
            );
        }
    },

    /**
     * Gets the current pagination number <li> object
     * to be used while showing just three pages with current
     * page at center, in case total pages are more than 4
     */
    getCurrentObj: function() {
        return _.find(this.pageNumList, function(tmpObj) {
            return tmpObj.pageNum === this.pageNumClicked;
        }, this);
    },

    /**
     * {@inheritDoc}
     * @param options gets page number for Pagination in Favorites tab
     */
    loadData: function(options) {
        if (!this.tabs) {
            return;
        }
        var data = {
            results: [],
            // only show one page of results
            // if more results are needed, then the address book should be used
            more: false
        };
        var callbacks = {};
        var url;
        var payloadData = {};

        if (options && options.pageNum !== undefined) {
            this.pageNumClicked = options.pageNum;
        }

        if (this.activeTab === 'favorites') {
            payloadData.pageNum = this.pageNumClicked - 1;
        }
        url = this.getUrl(payloadData);
        this.toggleLoading(true);
        callbacks.success = _.bind(this.onProductFetchSuccess, this);
        callbacks.error = _.bind(function() {
            // don't add any recipients via the select2 callback
            this.dataFetched = true;
            this.toggleLoading(false);
            data.results = [];
        }, this);
        app.api.call('read', url, null, callbacks);
    },

    /**
     * This gets called on callback success of LoadData and fetches records
     * for dashlet rows
     * @param options gets page number for Pagination in Favorites tab
     * @param result response data from the api call
     */
    onProductFetchSuccess: function(result) {
        var favRecords = [];
        var tmpLeftEllipsesObject = {};
        var tmpRightEllipsesObject = {};

        var currentIndex = 0;
        var startIndex = 0;

        //reset global variables
        this.pageNumList = [];
        this.recentCollection.reset();

        this.dataFetched = true;
        this.isNextDisabled = false;
        this.isPrevDisabled = false;
        this.isPageNumDisabled = false;

        this.paginationLength = 0;

        //if some data is returned
        if (result.records.length > 0) {
            //if 'Recent used' is the active tab
            if (this.activeTab === 'recent-product') {
                this.recentCollection.reset(result.records);
            } else { //else 'Favorites' tab is active
                this.paginationLength = result.totalPages;

                this.pageNumClicked = this.pageNumClicked > this.paginationLength ?
                    this.pageNumClicked - 1 : this.pageNumClicked;

                if (this.pageNumClicked === this.paginationLength || this.paginationLength === 1) {
                    this.isNextDisabled = true;
                }
                if (this.pageNumClicked === 1 || this.paginationLength === 1) {
                    this.isPrevDisabled = true;
                }

                this.isPageNumDisabled = this.pageNumClicked === 1 && this.paginationLength === 1 ? true : false;

                tmpLeftEllipsesObject = {
                    isIcon: true,
                    listClass: 'favorite-pagination',
                    subListClass: 'left-ellipsis-icon fa fa-ellipsis-h'
                };

                tmpRightEllipsesObject = {
                    isIcon: true,
                    listClass: 'favorite-pagination',
                    subListClass: 'right-ellipsis-icon fa fa-ellipsis-h'
                };

                //Push details for each list item in the pagination
                for (var page = 0; page < result.totalPages; page++) {
                    this.pageNumList.push({
                        isIcon: false,
                        listClass: 'favorite-pagination',
                        subListClass: 'paginate-num-button btn btn-link btn-invisible',
                        pageNum: page + 1,
                        isActive: this.pageNumClicked === page + 1 && !this.isPageNumDisabled ? true : false
                    });
                }

                //If more than 4 pages then display just 3 pages with ellipsis
                if (result.totalPages > 4) {
                    currentIndex = this.pageNumList.indexOf(this.getCurrentObj());

                    if (currentIndex > 0) {
                        startIndex = currentIndex < this.pageNumList.length - 1 ?
                            currentIndex - 1 : this.pageNumList.length - 3;
                    } else {
                        startIndex = 0;
                    }

                    //Get just three objects with active item in the center
                    this.pageNumList = this.pageNumList.slice(startIndex, startIndex + 3);
                    if (startIndex !== 0) {
                        this.pageNumList.unshift(tmpLeftEllipsesObject);
                    }
                    if (result.totalPages - currentIndex >= 3) {
                        this.pageNumList.push(tmpRightEllipsesObject);
                    }
                }
            }

            //favRecords represents a page displayed on the Favorite tab
            for (var count = 0; count < result.records.length; count++) {
                favRecords[count] = result.records[count];
            }

            this.recentCollection.reset(favRecords);
        }
        _.each(this.recentCollection.models, function(model) {
            var name = model.get('name');
            var shortName = name.length > 25 ? name.substr(0, 25) + '...' : name;
            model.set({
                longName: name,
                shortName: shortName
            });
        }, this);
        this.toggleLoading(false);
        this.render();
    },

    /**
     * Get the page Number clicked in Favorites Tab
     * @param evt
     */
    getPageNumClicked: function(evt) {
        evt.preventDefault();
        var pageId = this.$(evt.target).data('page-id');
        if (this.pageNumClicked === pageId) {
            return;
        }
        this.loadData({
            pageNum: pageId
        });
        this.toggleLoading(false);
        this.render();
    },

    /**
     * Event handler for navigantion button click events in the pagination footer
     * @param evt
     */
    onPageNavClicked: function(evt) {
        evt.preventDefault();
        var $el = this.$(evt.target);
        var currentPageNum = $el.data('page-id');
        if ($el.hasClass('previous-fav') || $el.hasClass('nav-previous')) {
            this.loadData({
                pageNum: currentPageNum - 1
            });
        } else if ($el.hasClass('next-fav') || $el.hasClass('nav-next')) {
            this.loadData({
                pageNum: currentPageNum + 1
            });
        }
        this.toggleLoading(false);
        this.render();
    },

    /**
     * Event handler to handle click on record names
     * @param evt
     */
    onNameClicked: function(evt) {
        evt.preventDefault();
        var recordId = this.$(evt.target).parent().data('record-id');
        var data = this.recentCollection.get(recordId);
        if (data) {
            data = data.toJSON();
            // copy Template's id and name to where the QLI expects them
            data.product_template_id = data.id;
            data.product_template_name = data.name;
            data.created_by = data.created_by && data.created_by.trim();
            data.modified_user_id = data.modified_user_id && data.modified_user_id.trim();
            data.currency_id = data.currency_id && data.currency_id.trim();
            // remove ID/etc since we dont want Template ID to be the record id
            delete data.id;
            delete data.date_entered;
            delete data.date_modified;
            delete data.pricing_formula;
            delete data.my_favorite;

            var viewDetails = this.closestComponent('record') ?
                this.closestComponent('record') :
                this.closestComponent('create');

            if (!_.isUndefined(viewDetails)) {
                app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', data);
            }
        }
    },

    /**
     * @inheritdoc
     */
    tabSwitcher: function(event) {
        this.dataFetched = false;
        this._super('tabSwitcher', [event]);
        //Resetting pageNumClicked on switching back to Favorites tab
        if (this.activeTab === 'favorites') {
            this.pageNumClicked = 1;
        }
        this.loadData();
    },

    /**
     * Toggles the spinning Loading icon on the header bar
     *
     * @param {boolean} startLoading If we should start the spinning icon or hide it
     */
    toggleLoading: function(startLoading) {
        if (startLoading) {
            this.$('.loading-icon').show();
        } else {
            this.$('.loading-icon').hide();
        }
    },

    /**
     * Fetches a Product Template record given the ID, and sends the response data to `callbacks.success`
     *
     * @param {string} id The ProductTemplate ID Hash to fetch
     * @private
     */
    _fetchProductTemplate: function(id) {
        var url = app.api.buildURL('ProductTemplates/' + id);
        app.api.call('read', url, null, null, {
            success: _.bind(this._openItemInDrawer, this)
        });
    },

    /**
     * Gets the record Id for the item corresponding to the clicked icon and passes it to
     * _fetchProductTemplate()
     *
     * @param evt
     */
    onIconClicked: function(evt) {
        var recordId = this.$(evt.target).parent().data('record-id');
        this._fetchProductTemplate(recordId);
    },

    /**
     * Sends the ProductTemplate data item to a Drawer layout
     *
     * @param {Object} data The ProductTemplate data
     * @private
     */
    _openItemInDrawer: function(response) {
        var data = app.data.createBean('ProductTemplates', response);
        var viewDetails = this.closestComponent('record') ?
            this.closestComponent('record').cid :
            this.closestComponent('create').cid;

        data.viewId = viewDetails;
        app.drawer.open({
            layout: 'product-catalog-dashlet-drawer-record',
            context: {
                module: 'ProductTemplates',
                model: data
            }
        });
    }
})
