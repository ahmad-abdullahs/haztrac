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
 * @class View.Views.Base.Quotes.ProductCatalogView
 * @alias SUGAR.App.view.views.QuotesProductCatalogView
 * @extends View.View
 */
// This view is used for showing up the dashlet on right side of the drawer for bundled tree.
// While creating the sales and services you see this bundled dashlet.
// @see screenshots 3.png
({
    plugins: ['CanvasDataRenderer'],

    events: {
        'keyup .product-catalog-search-term': 'onSearchTermChange'
    },

    /**
     * The JSTree Object reference
     */
    jsTree: undefined,

    /**
     * The data for the JSTree Object
     */
    jsTreeData: undefined,

    /**
     * If we are actively fetching data from the server
     */
    isFetchActive: false,

    /**
     * Holds placeholder text for the search input
     */
    searchText: undefined,

    /**
     * Holds the previous search term to prevent duplicate fetches
     */
    previousSearchTerm: undefined,

    /**
     * Keeps track of how many fetches are active
     */
    activeFetchCt: undefined,

    /**
     * Keeps track of the MouseWheel event name for phaser create and dispose
     */
    wheelEventName: undefined,

    /**
     * The PhaserIO game object reference
     */
    phaser: undefined,

    /**
     * Flag if the Phaser Lib has finished loading
     */
    phaserReady: undefined,

    /**
     * Flag if the data has finished loading
     */
    dataLoaded: undefined,

    /**
     * The current search filter term the user is searching for
     */
    currentFilterTerm: undefined,

    /**
     * The main Tree-level module to use when fetching data for the dashlet
     */
    treeModule: undefined,

    /**
     * The config settings and variables for the hierarchy tree
     */
    treeConfig: undefined,

    /**
     * The SpriteSheet object containing id, imagePath, and dataPath
     */
    spriteSheetManifest: undefined,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);

        this.activeFetchCt = 0;
        this.searchText = this.getSearchTextPlaceholder();

        this.dataLoaded = false;
        this.phaserReady = false;

        this.initializeProviderModules();
        this.treeConfig = this.getTreeStateConfigSettings();
        this.spriteSheetManifest = this.getSpriteSheetManifestObject();

        this.context.on('phaserio:ready', function () {
            this.phaserReady = true;
            this.checkBuildPhaser();
        }, this);
    },

    /**
     * Returns the placeholder string for the Search text input
     * @return {string}
     */
    getSearchTextPlaceholder: function () {
        return app.lang.get('LBL_SEARCH_CATALOG_PLACEHOLDER', 'Quotes');
    },

    /**
     * Initializes any modules needed for data fetching
     */
    initializeProviderModules: function () {
        this.treeModule = 'ProductTemplates';
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function () {
        var sidebarLayout;

        this._super('bindDataChange');

        // adding PC Dashlet just return
        if (this.isConfig) {
            return;
        }

        var viewDetails = this.closestComponent('record') ?
                this.closestComponent('record') :
                this.closestComponent('create');

        if (!_.isUndefined(viewDetails)) {
            // need to trigger on app.controller.context because of contexts changing between
            // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
            // app.controller.context is the only consistent context to use
            app.controller.context.on(viewDetails.cid + ':productCatalogDashlet:add:complete',
                    this._onProductDashletAddComplete, this);
        }

        $(window).on('resize', _.bind(this._resizePhaserCanvas, this));

        sidebarLayout = this.closestComponent('sidebar');
        if (sidebarLayout) {
            sidebarLayout.on('sidebar:state:changed', this.onSidebarStateChanged, this);
        }
    },

    /**
     * Handles when the sidebar is toggled open or closed.
     *
     * @param {string} sidebarState The state of the sidebar: 'open' or 'close'
     */
    onSidebarStateChanged: function (sidebarState) {
        if (sidebarState === 'open' && this.phaser) {
            this.checkBuildPhaser();
        }
    },

    /**
     * Gets the search term from the text input
     */
    onSearchTermChange: _.debounce(function (evt) {
        var term = $(evt.target).val().trim();

        if (term !== this.previousSearchTerm) {
            this.previousSearchTerm = term;
            this.loadData({
                searchTerm: term
            });
        }
    }, 500),

    /**
     * @inheritdoc
     */
    loadData: function (options) {
        var callbacks;
        var url;
        var term = options && options.searchTerm;
        var method = 'read';
        var payload = {};

        url = this.treeModule + '/bundledtree';

        if (term) {
            method = 'create';
            payload.filter = term;
            this.currentFilterTerm = term;
        } else {
            this.currentFilterTerm = undefined;
        }

        this.$('.product-catalog-no-results').addClass('hidden');

        url = app.api.buildURL(url, method);

        this.toggleLoading(true);

        callbacks = {
            context: this,
            success: this._onCatalogFetchSuccess,
            complete: _.bind(function () {
                if (this.disposed) {
                    return;
                }
                // when complete, remove the spinning refresh icon from the cog
                // and add back the cog icon
                this.toggleLoading(false);
            }, this)
        };

        this.activeFetchCt++;
        app.api.call(method, url, payload, null, callbacks);
    },

    /**
     * Toggles the spinning Loading icon on the header bar
     *
     * @param {boolean} startLoading If we should start the spinning icon or hide it
     */
    toggleLoading: function (startLoading) {
        if (startLoading) {
            this.$('.loading-icon').show();
        } else {
            this.$('.loading-icon').hide();
        }
    },

    /**
     * Handles the ProductTemplates/tree endpoint response
     * and parses data to be used by the tree
     *
     * @param response
     * @protected
     */
    _onCatalogFetchSuccess: function (response) {
        this.jsTreeData = response;
        this.activeFetchCt--;

        if (this.disposed) {
            return;
        }

        if (this.activeFetchCt === 0) {
            if (this.jsTreeData.records.length === 0) {
                this.$('.product-catalog-no-results').removeClass('hidden');
            } else {
                this.$('.product-catalog-no-results').addClass('hidden');
                this.$('.product-catalog-search-term').removeClass('hidden');
            }
        }

        this.dataLoaded = true;

        if (_.isUndefined(this.phaser)) {
            this.checkBuildPhaser();
        } else {
            this.phaser.events.onSetTreeData.dispatch(this.jsTreeData);
        }
    },

    /**
     * Checks if data has been loaded and Phaser is ready to be run
     */
    checkBuildPhaser: function () {
        if (this.dataLoaded && this.phaserReady) {
            this._createPhaser();
        }
    },

    /**
     * @inheritdoc
     */
    render: function () {
        this._super('render');

        this.checkBuildPhaser();
    },

    /**
     * When the DOM MouseEvent wheel scroll happens,
     * this function handles it and passes the delta info to Phaser
     *
     * @param {MouseEvent} mouseEvent The mouse scroll wheel event
     * @protected
     */
    _onMouseWheelChange: function (mouseEvent) {
        var delta = mouseEvent.type === 'mousewheel' ?
                mouseEvent.originalEvent.wheelDelta / 20 :
                mouseEvent.originalEvent.deltaY;

        mouseEvent.preventDefault();
        this.phaser.events.onScrollWheel.dispatch(delta);
    },

    /**
     * Event listener for when the Phaser "Tree" State triggers its onTreeReady event
     */
    onPhaserTreeReadyHandler: function () {
        this.phaser.events.onSetTreeData.dispatch(this.jsTreeData);
    },

    /**
     * Wraps getting spritesheets
     *
     * @return {{atlasJSONHash: (*|{imagePath: string, id: string, dataPath: string}[])}}
     */
    getSpriteSheetManifestObject: function () {
        return {
            atlasJSONHash: this._getSpriteSheets()
        };
    },

    /**
     * Returns an array of SpriteSheet location objects and ids for each spritesheet
     *
     * @return {{imagePath: string, id: string, dataPath: string}[]}
     * @protected
     */
    _getSpriteSheets: function () {
        return [{
                id: 'prodCatTS',
                imagePath: 'custom/modules/sales_and_services/clients/base/views/product-catalog/product-catalog-ss.png',
                dataPath: 'custom/modules/sales_and_services/clients/base/views/product-catalog/product-catalog-ss.json'
            }];
    },

    /**
     * Returns the Hex-value color to use for the node
     *
     * @param {string} itemType The Item type of the node
     * @param {Object} node The Phaser node we need an icon name
     * @return {string}
     * @protected
     */
    _getTreeNodeTextColor: function (itemType, node) {
        var textColor = '';
        if (itemType === 'category') {
            textColor = this.treeConfig.categoryColor;
        } else if (itemType === 'product' || itemType === 'parent' || itemType === 'showMore') {
            textColor = this.treeConfig.itemColor;
        }

        return textColor;
    },

    /**
     * Returns the icon name to use for the node
     *
     * @param {string} itemType The Item type of the node
     * @param {Object} node The Phaser node we need an icon name
     * @return {string}
     * @protected
     */
    _getTreeNodeIconName: function (itemType, node) {
        var iconName = '';
        if (itemType === 'category') {
            iconName = node.state === 'closed' ?
                    this._getTreeIconClosedStateName() :
                    this._getTreeIconOpenStateName();
        } else if (itemType === 'product') {
            iconName = 'list-alt';
        } else if (itemType === 'showMore') {
            iconName = 'empty';
        }

        if (node.is_bundle_product_c == 'parent') {
            iconName = 'file-archive';
        }

        return iconName;
    },

    /**
     * Returns the open icon name for the open state of a folder
     *
     * @return {string}
     * @protected
     */
    _getTreeIconOpenStateName: function () {
        return 'folder-open-o';
    },

    /**
     * Returns the closed icon name for the closed state of a folder
     *
     * @return {string}
     * @protected
     */
    _getTreeIconClosedStateName: function () {
        return 'folder';
    },

    /**
     * Extensible function to allow Icon Height to be tweaked based on the icon or node
     *
     * @param {string} iconName
     * @param {Object} node The Phaser node we need an icon height
     * @return {number}
     * @protected
     */
    _getTreeIconHeight: function (iconName, node) {
        return iconName === 'list-alt' ? 12 : this.treeConfig.iconHeight;
    },

    /**
     * Extensible function to allow Icon Height to be tweaked based on the icon or node
     *
     * @param {string} iconName
     * @param {Object} node The Phaser node we need an icon height
     * @return {number}
     * @protected
     */
    _getTreeIconWidth: function (iconName, node) {
        return this.treeConfig.iconWidth;
    },

    /**
     *
     * @param {string} itemType The Item type of the node
     * @param {string} iconName The name of the icon
     * @param {Object} node The Phaser node we need an icon name
     * @return {string} The ID of the SpriteSheet to use
     * @protected
     */
    _getTreeNodeSpriteSheetId: function (itemType, iconName, node) {
        return 'prodCatTS';
    },

    /**
     * Handles when any item on the stage is clicked.
     * This is inside the Phaser conxtext, not the view
     *
     * @param {Phaser.Image|Phaser.Text} target The Phaser text or icon that was clicked
     * @protected
     */
    _onTreeNodeItemClicked: function (target) {
        var isIcon = target instanceof Phaser.Image;

        if (target._itemType === 'category' || target._itemType === 'showMore') {
            this.game._view._onTreeNodeCategoryClicked(target, isIcon);
        } else {
            if (isIcon) {
                this.game._view._onTreeNodeIconClicked(target);
            } else {
                this.game._view._onTreeNodeNameClicked(target);
            }
        }
    },

    /**
     * Handles when a Product Category or "Show More" is clicked
     * This is the View context, not Phaser
     *
     * @param {Phaser.Image|Phaser.Text} target The Phaser text or icon that was clicked
     * @param {boolean} isIcon If the `target` is an image/icon or Text
     * @protected
     */
    _onTreeNodeCategoryClicked: function (target, isIcon) {
        var changeYDelta;
        var isVisible;
        var icon = isIcon ? target : target.parent._icon;
        var isShowMore = target._itemType === 'showMore';
        var openName = this._getTreeIconOpenStateName();
        var closedName = this._getTreeIconClosedStateName();
        var newFrameName = icon.frameName === closedName ? openName : closedName;
        var currentState = this.phaser.state.getCurrentState();

        if (isIcon) {
            icon = target;
            target = _.find(target.parent.children, function (item) {
                return item instanceof Phaser.Text && item._itemId === target._itemId;
            });
        } else {
            icon = _.find(target.parent.children, function (item) {
                return item instanceof Phaser.Image && item._itemId === target._itemId;
            });
        }

        if (target._isFetching) {
            return;
        }

        if (isShowMore || newFrameName === openName) {
            currentState._getMoreRecords(target, icon, isShowMore);
        } else {
            icon.frameName = newFrameName;
            // subtract the group height from the game world height and update
            currentState.gameWorldHeight -= target.parent.childGroup.height;
            currentState._updateGameWorldSize();
        }

        if (target.parent.childGroup) {
            isVisible = !target.parent.childGroup.visible;
            target.parent.childGroup.visible = isVisible;
            changeYDelta = target.parent.childGroup.height;

            if (!isVisible) {
                changeYDelta = -changeYDelta;
            }

            target.parent._events.onChangeY.dispatch(changeYDelta, target.parent);
        }
    },

    /**
     * When a tree item's icon gets clicked
     *
     * @param {Phaser.Image} target The icon that was clicked
     * @protected
     */
    _onTreeNodeIconClicked: function (target) {
        this._fetchRecord(target._itemId, {
            success: _.bind(this._openItemInDrawer, this)
        });
    },

    setDateTimeFormate: function (value) {
        if (!value) {
            return value;
        }
        value = app.date(value, app.date.convertFormat(this.getUserDateTimeFormat()), true);
        if (!value.isValid()) {
            return;
        }
        return value.format();
    },

    /**
     * @param {Function} getUserDateTimeFormat
     * @Description : function to get user date and time format
     */
    getUserDateTimeFormat: function () {
        return app.user.getPreference('datepref') + ' ' + app.user.getPreference('timepref');
    },
    /**
     * @param {Function} _render
     * @Description : This function is override to set default date to next month (same day and time) for start date
     */
    getExpectedCloseDate: function () {
        var today = new Date();
        var value = new Date(new Date(today).setMonth(today.getMonth() + 1));
        return this.setDateTimeFormate(app.date(value).format(app.date.convertFormat(this.getUserDateTimeFormat())));
    },

    /**
     * When a tree item's name gets clicked
     *
     * @param {Phaser.Text} target The text label that was clicked
     * @protected
     */
    _onTreeNodeNameClicked: function (target) {
        this._fetchRecord(target._itemId, {
            success: _.bind(function (data) {
                var _id = _.clone(data.id);
                this._massageDataBeforeSendingToRecord(data);
                var _self = this;

//                var clickedTarget = _.find(target.game._view.jsTreeData.records, function (record) {
//                    return record.id == _id;
//                }, this);

//                if (_.isUndefined(clickedTarget)) {
//                    clickedTarget = data;
//                    clickedTarget.id = _id;
//                }

//                data.is_bundle_product_c = clickedTarget.is_bundle_product_c;
//                if (clickedTarget.is_bundle_product_c == 'parent') {
//                    data.date_closed = (this.getExpectedCloseDate()).substring(0, 10);
//                }
                if (data.is_bundle_product_c == 'parent') {
                    data.date_closed = (this.getExpectedCloseDate()).substring(0, 10);
                }
                data.unit_of_measure_c = data.product_uom_c;

                var viewDetails = this.closestComponent('record') ?
                        this.closestComponent('record') :
                        this.closestComponent('create');
                // need to trigger on app.controller.context because of contexts changing between
                // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
                // app.controller.context is the only consistent context to use
                if (!_.isUndefined(viewDetails)) {
                    app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', data);
                }

                if (data.is_bundle_product_c == 'parent') {
                    var productTemplates = App.data.createBean('ProductTemplates', {id: _id});
                    productTemplates.fetch();
                    var productTemplatesRelatedColl = productTemplates.getRelatedCollection('product_templates_product_templates_1');
                    productTemplatesRelatedColl = productTemplatesRelatedColl.fetch({
                        relate: true,
                        success: function (coll) {
                            _.each(coll.models, function (model) {
                                _self._massageDataBeforeSendingToRecord(model.attributes);

                                var viewDetails = _self.closestComponent('record') ?
                                        _self.closestComponent('record') :
                                        _self.closestComponent('create');
                                // need to trigger on app.controller.context because of contexts changing between
                                // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
                                // app.controller.context is the only consistent context to use
                                if (!_.isUndefined(viewDetails)) {
                                    // To add the relationship between the revenuelineitems
                                    model.attributes.revenuelineitems_revenuelineitems_1revenuelineitems_ida = data.id;
                                    app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', model.attributes);
                                }
                            })
                        }
                    })
                }

            }, this)
        });
    },

    /**
     * Returns an EventHub object containing any event Signals the tree will use
     *
     * @return {EventHub} The Event Hub to use with Phaser
     */
    getPhaserEventHub: function () {
        var EventHub = function () {};
        EventHub.prototype = {

            /**
             * Event called outside Phaser to pass tree data into Phaser for parsing/rendering
             */
            onSetTreeData: new Phaser.Signal(),

            /**
             * Event dispatched by Phaser when the Tree State has finished it's create function
             * and is ready for data
             */
            onTreeReady: new Phaser.Signal(),

            /**
             * Event called outside Phaser to pass mouse scroll wheel data into Phaser
             * to know how much to move the camera up or down
             */
            onScrollWheel: new Phaser.Signal(),

            /**
             * Event called outside Phaser to trigger re-drawing UI
             */
            onResize: new Phaser.Signal(),

            /**
             * Handles disposing any Signal events and listeners
             */
            destroy: function () {
                for (var eventName in this) {
                    if (this.hasOwnProperty(eventName) && _.isFunction(this[eventName].dispose)) {
                        this[eventName].dispose();
                    }
                }
            }
        };
        return EventHub;
    },

    /**
     * Returns the canvas ID name Phaser should use
     *
     * @return {string}
     * @protected
     */
    _getPhaserCanvasId: function () {
        return 'product-catalog-canvas-' + this.cid;
    },

    /**
     * Returns the Phaser game config
     *
     * @return {Object}
     */
    getPhaserGameConfig: function () {
        var elIdName = this._getPhaserCanvasId();
        var $el = this.$('#' + elIdName);
        var gameConfig = {
            height: 260,
            parent: elIdName,
            renderer: Phaser.CANVAS,
            transparent: true,
            width: $el.width()
        };

        return this._getPhaserGameConfig(gameConfig);
    },

    /**
     * Extensible function to tweak anything in the game config before sending it to Phaser
     *
     * @param {Object} gameConfig
     * @return {Object}
     * @protected
     */
    _getPhaserGameConfig: function (gameConfig) {
        return gameConfig;
    },

    /**
     * This function creates the actual PhaserIO game object
     *
     * @protected
     */
    _createPhaser: function () {
        var gameConfig = this.getPhaserGameConfig();
        var EventHub = this.getPhaserEventHub();
        var states;

        // remove the phaser console log
        window.PhaserGlobal = {
            hideBanner: true
        };

        if (this.phaser) {
            this.phaser.events.destroy();
            this.phaser.destroy();
        }

        this.phaser = new Phaser.Game(gameConfig);

        this.phaser._view = this;

        this.wheelEventName = 'onwheel' in document.createElement('div') ? 'wheel' : // Modern browsers support "wheel"
                document.onmousewheel !== undefined ? 'mousewheel' : // Webkit and IE support at least "mousewheel"
                'DOMMouseScroll'; // let's assume that remaining browsers are older Firefox

        this.$('.product-catalog-container-' + this.cid).off(this.wheelEventName);
        this.$('.product-catalog-container-' + this.cid).on(
                this.wheelEventName,
                _.bind(this._onMouseWheelChange, this)
                );

        this.phaser.events = new EventHub();
        this.phaser.events.onTreeReady.add(this.onPhaserTreeReadyHandler, this);

        states = this.getStates();
        _.each(states, function (state, index) {
            this.phaser.state.add(index, state);
        }, this);

        this.phaser.state.start('boot');
    },

    /**
     * Gets the states needed to be added to Phaser
     *
     * @return {Object} The states to add to Phaser
     */
    getStates: function () {
        var states = {
            boot: this._getBootState(),
            load: this._getLoadState(),
            tree: this._getTreeState()
        };

        return this._getAdditionalStates(states);
    },

    /**
     * Returns the Phaser.State object for the Boot state
     *
     * @protected
     */
    _getBootState: function () {
        return {
            /**
             * Preload is called as the BootState initializes and lets us set any flags we need later.
             * This is the place for setting any Phaser variables we might need at runtime.
             */
            preload: function () {
                this.game.hasTreeData = false;
            },

            /**
             * After the BootState is done preloading, this function calls the LoadState
             */
            create: function () {
                this.game.state.start('load');
            }
        };
    },

    /**
     * Returns the Phaser.State object for the Load state
     *
     * @protected
     */
    _getLoadState: function () {
        return {
            /**
             * Preload is called as the LoadState initializes and lets us load any assets we'll use later.
             * This would also be the place to add preloading progressbar
             */
            preload: function () {
                // loop over anything in the manifest and load it
                _.each(this.game._view.spriteSheetManifest, function (itemsToLoad, key) {
                    if (!_.isEmpty(itemsToLoad)) {
                        _.each(itemsToLoad, function (item) {
                            switch (key) {
                                case 'json':
                                case 'image':
                                    this.game.load[key](item.id, item.path);
                                    break;

                                case 'atlasJSONHash':
                                case 'bitmapFont':
                                    this.game.load[key](item.id, item.imagePath, item.dataPath);
                                    break;
                            }
                        }, this);
                    }
                }, this);
            },

            /**
             * After the LoadState is done preloading assets, this function calls the TreeState
             */
            create: function () {
                this.game.state.start('tree');
            }
        };
    },

    getTreeStateConfigSettings: function () {
        var config = {
            categoryColor: '#000000',
            itemColor: '#167DE5',
            itemFont: '12px open sans',
            iconTextPadding: 5,
            iconWidth: 16,
            iconHeight: 16,
            iconWidthHalf: this.iconWidth >> 1,
            iconScale: 0.25,
            iconStartX: 5,
            iconYOffset: 8,
            itemRowYPadding: 21,
            childRowYPadding: 10,
            containerRowStartY: 0,
            showMoreNode: {
                data: app.lang.get('LBL_SHOW_MORE'),
                type: 'showMore'
            },
            showMoreNodeIconName: 'folder-open-o',
            scrollBarBkgdBorderLineSize: 1,
            scrollBarBkgdWidth: 15,
            scrollBarBkgdBorderColor: 0xE8E8E8,
            scrollBarBkgdFill: 0xFAFAFA,
            scrollBarBkgdFillIE: 0xF0F0F0,
            scrollThumbWidth: 8,
            scrollThumbHeight: 16,
            scrollThumbFillColor: 0xC1C1C1,
            scrollThumbFillHoverColor: 0x7D7D7D,
            scrollThumbTopBottomPadding: 3
        };

        return this._getTreeStateConfigSettings(config);
    },

    /**
     * Extensible function if anything needs to be added or removed from cfg
     *
     * @param cfg
     * @return {Object}
     * @protected
     */
    _getTreeStateConfigSettings: function (cfg) {
        return cfg;
    },

    /**
     * Returns the Phaser.State object for the Tree state
     *
     * @protected
     */
    _getTreeState: function () {
        var treeConfig = this.treeConfig = this.getTreeStateConfigSettings();
        var treeState = {
            isLoading: false,
            groups: undefined,
            rootGroup: undefined,
            dashletHeight: undefined,
            gameWorldHeight: undefined,
            gameWorldWidth: undefined,
            cameraY: undefined,
            GroupEventHub: undefined,
            scrollBarImg: undefined,
            scrollBarThumbImg: undefined,
            scrollThumbHoverImg: undefined,
            scrollThumbImg: undefined,
            previousScrollThumbY: 0,
            scrollPercentHeight: 0,
            scrollThumbHoverInTween: undefined,
            scrollThumbHoverOutTween: undefined,
            maxScrollY: undefined,
            useScrollbar: true,
            isLangRTL: false,

            /**
             * Preload is called as the TreeState initializes and lets us setup any vars we need for the state
             */
            preload: function () {
                var $el = this.game._view.$('#' + this.game._view._getPhaserCanvasId());

                this.groups = [];
                this.gameWorldHeight = 0;
                this.gameWorldWidth = $el.width();
                this.dashletHeight = $el.height();
                this.cameraY = 0;
                this.isLoading = false;
                this.isLangRTL = app.lang.direction === 'rtl';

                this.game.events.onSetTreeData.add(this._setTreeData, this);
                this.game.events.onScrollWheel.add(this._onScrollWheel, this);
                this.game.events.onResize.add(this._onResize, this);

                this.GroupEventHub = function () {
                    return {
                        onChangeY: new Phaser.Signal(),
                        destroy: function () {
                            for (var eventName in this) {
                                if (this.hasOwnProperty(eventName) && _.isFunction(this[eventName].dispose)) {
                                    this[eventName].dispose();
                                }
                            }
                        }
                    };
                };

                // use scrollbar as long as we're not using firefox or safari or ie
                this.useScrollbar = !(this.game.device.firefox || this.game.device.safari || this.game.device.ie);

                if (this.game.hasTreeData) {
                    this._setTreeData(this.game.treeData);
                }
            },

            /**
             * After preload is done, create runs and lets us let the Sugar.App know our tree is ready
             */
            create: function () {
                this._updateGameWorldSize();
                this.game.events.onTreeReady.dispatch();
            },

            /**
             * Handles the Mouse ScrollWheel event being passed from the DOM to Phaser.
             * The yDelta value gets added to `this.cameraY` so that the next game "tick" event
             * that happens during the state's `update` function, we can move the
             * game's camera object up or down.
             *
             * @param yDelta
             * @private
             */
            _onScrollWheel: function (yDelta) {
                // update the camera position by the yDelta
                this.game.camera.y += yDelta;

                // only need to update scrollbar if it exists
                if (this.scrollBarThumbImg) {
                    this._updateScrollThumbToCamera();
                }
            },

            /**
             * Re-orients the scroll thumb to the camera position in the world.
             * This allows the camera and thumb to stay in sync after a Show More event.
             *
             * @private
             */
            _updateScrollThumbToCamera: function () {
                var percentCameraGameHeightDiff = this.game.camera.y / this.gameWorldHeight;
                var newScrollY = percentCameraGameHeightDiff * this.dashletHeight;

                // update the scrollbar thumb
                this.scrollBarThumbImg.cameraOffset.y = newScrollY;

                // make sure we're not out of bounds
                this._checkBounds(this.scrollBarThumbImg);
            },

            /**
             * Handles the Phaser onResize event and updates the game world and scrollbar
             * @private
             */
            _onResize: function () {
                this._updateGameWorldSize();
            },

            /**
             * This event is triggered when a user clicks to expand or collapse a Group.
             * yDelta will be positive (the group needs to expand) or negative (the group is being hidden)
             *
             * @param {number} yDelta The amount to change the Y value of Groups
             * @private
             */
            _onChangeY: function (yDelta) {
                var rowIndex;
                var groups;
                var groupLen;

                if (this.parent.parent instanceof Phaser.Stage) {
                    // once we hit the "rootGroup" group level
                    // just return and break out of this event loop
                    return;
                }

                // we need to move all groups that come after this group
                // get the next index for any items we need to move after this group
                rowIndex = this._rowIndex + 1;

                // get all of the Phaser.Groups at "this" level (this.parent.children)
                groups = _.filter(this.parent.children, function (child) {
                    return child instanceof Phaser.Group;
                });

                // get the length of the groups
                groupLen = groups.length;

                // loop over each group after "this" group and move it up/down by the yDelta
                for (rowIndex; rowIndex < groupLen; rowIndex++) {
                    groups[rowIndex].y += yDelta;
                }

                // update the parent group with the correct yOffset to apply to its children
                this.parent._yOffset += yDelta;

                // cause the event to "bubble" up to the next level
                this.parent._events.onChangeY.dispatch(yDelta, this);
            },

            /**
             * Sets the main tree data and starts building the levels and nodes.
             * This is called when the page loads and when a user types in to search for data.
             *
             * @param treeData
             * @private
             */
            _setTreeData: function (treeData) {
                var groupIndex = 0;
                var elIdName = this.game._view._getPhaserCanvasId();
                var $el = this.game._view.$('#' + elIdName);

                this.dashletHeight = $el.height();
                this.gameWorldWidth = $el.width();
                this.gameWorldHeight = 0;
                this.cameraY = 0;
                this.game.camera.y = 0;

                if (this.rootGroup) {
                    if (this.rootGroup.childGroup) {
                        this.rootGroup.childGroup._events.destroy();
                        this.rootGroup.childGroup.destroy();
                    }

                    this.rootGroup._events.destroy();
                    this.rootGroup.destroy();
                }

                this.rootGroup = this.game.add.group();
                this.rootGroup.name = 'rootGroup';
                this.rootGroup._groupIndex = -1;
                this.rootGroup._events = new this.GroupEventHub();
                this.rootGroup._events.onChangeY.add(this._onChangeY, this.rootGroup);
                this.rootGroup.childGroup = this._createGroupObject(-1, 0);

                _.each(treeData.records, function (node, index) {
                    this._createLevel(this.rootGroup.childGroup, node, groupIndex, index);
                }, this);

                if (treeData.next_offset !== -1) {
                    this._createLevel(this.rootGroup.childGroup, this.showMoreNode, groupIndex, treeData.next_offset);
                }

                this._updateGameWorldSize();
                // reset the camera back to the top 0 position
                this.game.camera.y = 0;
            },

            /**
             * Creates a Phaser.Group and sets some default properties
             *
             * @private
             * @return {Phaser.Group} group The newly created group
             */
            _createGroupObject: function (groupIndex, rowIndex) {
                var group = this.game.add.group();

                // set the group's name and some other indexes to help keep track
                // of where this group exists in its parents hierarchy
                group.name = 'group-' + groupIndex + '-' + rowIndex;
                group._groupIndex = groupIndex;
                group._rowIndex = rowIndex;
                group._yOffset = 0;

                // add an Events hub on this group to pass events
                group._events = new this.GroupEventHub();
                group._events.onChangeY.add(this._onChangeY, group);

                return group;
            },

            /**
             * Creates a "level" including category and any children
             *
             * @param {Phaser.Group} parentGroup The parent group to add this category and children to
             * @param {Object} node The JSON Object data from the tree for this node level
             * @param {number} groupIndex The Group level index from rootGroup
             * @param {number} rowIndex The specific row level index of this node inside its Group
             *                  groups pushing this group down
             * @private
             */
            _createLevel: function (parentGroup, node, groupIndex, rowIndex) {
                var group = this._createGroupObject(groupIndex, rowIndex);
                var groupYOffset = parentGroup._yOffset || 0;

                // create the group's icon and text label
                this._createNode(group, node, groupIndex, rowIndex);

                // update the overall game world height
                this.gameWorldHeight += this.itemRowYPadding;

                // add this new group to the parent
                parentGroup.add(group);

                if (parentGroup._groupIndex !== -1 && parentGroup.parent._groupIndex !== -1) {
                    group.parentGroup = parentGroup.parent;
                } else {
                    group.parentGroup = parentGroup;
                }

                if (node.type === 'showMore') {
                    group.parentGroup._nextOffset = rowIndex;
                }

                if (this.isLangRTL) {
                    group.x = 0;
                } else {
                    group.x = groupIndex === 0 ? 0 : this.iconWidth + this.iconStartX;
                }
                group.y = this.containerRowStartY + (this.itemRowYPadding * rowIndex) + groupYOffset;
            },

            /**
             * This function creates the actual Icon and Text label and adds them to the Group
             *
             * @param {Phaser.Group} group
             * @param {Object} node The JSON Object data from the tree for this node level
             * @param {number} groupIndex The Group level index from rootGroup
             * @param {number} rowIndex The specific row level index of this node inside its Group
             * @private
             */
            _createNode: function (group, node, groupIndex, rowIndex) {
                var icon;
                var text;
                var iconName;
                var textColor;
                var itemType = node.type;
                var itemId = node.id;
                var itemName = node.data;
                var startX;
                var startY;
                var gameView = this.game._view;
                var iconSpriteSheetId;

                textColor = gameView._getTreeNodeTextColor(itemType, node);
                iconName = gameView._getTreeNodeIconName(itemType, node);
                iconSpriteSheetId = gameView._getTreeNodeSpriteSheetId(itemType, iconName, node);

                startX = this.iconStartX + 8;
                startY = this.iconYOffset;

                if (this.isLangRTL) {
                    startX = this.gameWorldWidth - (startX * (groupIndex + 1)) - (this.iconWidthHalf * groupIndex);
                }

                // create the icon
                icon = this.game.add.image(
                        startX,
                        startY,
                        iconSpriteSheetId,
                        iconName
                        );
                icon.height = gameView._getTreeIconHeight(iconName, node);
                icon.width = gameView._getTreeIconWidth(iconName, node);
                icon.anchor.setTo(0.5, 0.5);
                icon._itemName = itemName;
                icon._itemId = itemId;
                icon._itemType = itemType;
                icon._tween = this.game.add.tween(icon).to({
                    angle: 360
                }, 3600, null, false, 0, -1);

                icon.inputEnabled = true;
                icon.events.onInputDown.add(gameView._onTreeNodeItemClicked, this);
                icon.input.useHandCursor = true;

                if (this.isLangRTL) {
                    startX -= this.iconWidth - this.iconTextPadding;
                } else {
                    startX = this.iconStartX + this.iconWidth + this.iconTextPadding;
                }

                text = this.game.add.text(
                        startX,
                        0,
                        node.data,
                        {
                            font: this.itemFont,
                            fill: textColor
                        }
                );

                if (this.isLangRTL) {
                    text.anchor.setTo(1, 0);
                }

                text._itemName = itemName;
                text._itemId = itemId;
                text._itemType = itemType;

                text.inputEnabled = true;
                text.events.onInputDown.add(gameView._onTreeNodeItemClicked, this);
                text.input.useHandCursor = true;

                group.name = group.name + '-' + itemName;
                group._itemName = itemName;
                group._itemId = itemId;
                group._itemType = itemType;
                group._icon = icon;
                group._text = text;
                group.add(icon);
                group.add(text);
            },

            /**
             * Handles fetching more records for the target root item
             *
             * @param {Phaser.Image|Phaser.Text} target The Phaser text or icon that was clicked
             * @param {Phaser.Image} icon The icon image object for the clicked item
             * @private
             */
            _getMoreRecords: function (target, icon, isShowMore) {
                var offset;
                var itemId = target._itemId;

                if (isShowMore && target.parent.parentGroup && target.parent.parentGroup._nextOffset !== -1) {
                    offset = target.parent.parentGroup._nextOffset;
                    itemId = target.parent.parentGroup._itemId;
                }

                if (_.isUndefined(target.parent.childGroup) || (!_.isUndefined(offset) && offset !== -1)) {
                    icon.frameName = 'refresh';
                    icon._tween.start();
                    target._isFetching = true;
                    icon._isFetching = true;

                    this.game._view._fetchMoreRecords(
                            itemId,
                            offset,
                            isShowMore,
                            _.bind(this._setMoreRecordsData, this, target, icon, isShowMore)
                            );
                } else {
                    icon.frameName = this.game._view._getTreeIconOpenStateName();
                    // add the group height to the game world height and update
                    this.gameWorldHeight += target.parent.childGroup.height;
                    this._updateGameWorldSize();
                }
            },

            /**
             * Updates Phaser's bounds and world size with the current gameWorldHeight
             *
             * @private
             */
            _updateGameWorldSize: function () {
                var $el = this.game._view.$('#product-catalog-canvas-' + this.game._view.cid);

                this.dashletHeight = $el.height();
                this.gameWorldWidth = $el.width();

                this.scrollPercentHeight = this.dashletHeight / this.gameWorldHeight;

                this.game.world.setBounds(0, 0, this.gameWorldWidth, this.gameWorldHeight);
                this.game.world.resize(this.gameWorldWidth, this.gameWorldHeight);
                this.game.camera.setBoundsToWorld();

                this.scrollThumbHeight = Math.floor(this.scrollPercentHeight * this.dashletHeight);

                if (this.useScrollbar) {
                    // only need to worry about this stuff if we're using scrollbar
                    if (this.scrollPercentHeight < 1) {
                        // the gameWorldHeight is greater than dashletHeight so we need a scrollbar
                        this.drawScrollbar();

                        this.scrollCheckTimerEvent = this.game.time.events.repeat(500, 40, this._checkScrollbar, this);
                    } else if (this.scrollBarThumbImg) {
                        // we no longer need a scrollbar, and this.scrollBarImg exists, so we need to remove it
                        this.scrollBarImg.destroy();
                        this.scrollThumbImg.destroy();
                        this.scrollBarThumbImg.destroy();
                    }
                }
            },

            /**
             * TimerEvent handler to check and see if the game world width has changed since last time
             * @private
             */
            _checkScrollbar: function () {
                var $el;

                if (this.game._view.disposed) {
                    this.game.time.events.remove(this.scrollCheckTimerEvent);
                    this.scrollCheckTimerEvent = null;
                    return;
                }

                $el = this.game._view.$('#product-catalog-canvas-' + this.game._view.cid);
                if ($el.width() !== this.gameWorldWidth) {
                    this.game.time.events.remove(this.scrollCheckTimerEvent);
                    this.scrollCheckTimerEvent = null;

                    this._updateGameWorldSize();
                }
            },

            /**
             * Draws the Scrollbar line and rectangle
             */
            drawScrollbar: function () {
                var scrollX = this.isLangRTL ? this.scrollBarBkgdWidth : this.gameWorldWidth - this.scrollBarBkgdWidth;
                var xOffset = this.game.device.ie ? 0 : 4;

                if (this.scrollBarImg) {
                    this.scrollBarImg.destroy();
                    this.scrollThumbImg.destroy();
                    this.scrollBarThumbImg.destroy();
                }

                // draw the scrollbar background image
                this.scrollBarImg = this.game.add.image(scrollX, 0, this._drawScrollBkgdBar());
                this.scrollBarImg.fixedToCamera = true;

                // draw the parent scroll thumb container
                this.scrollBarThumbImg = this.game.add.image(scrollX + xOffset, 0);

                // draw the scroll thumb image
                this.scrollThumbImg = this.game.add.image(
                        0,
                        this.scrollThumbTopBottomPadding,
                        this._drawScrollThumb(this.scrollThumbFillColor)
                        );

                // draw the scroll thumb hover image
                this.scrollThumbHoverImg = this.game.add.image(
                        0,
                        this.scrollThumbTopBottomPadding,
                        this._drawScrollThumb(this.scrollThumbFillHoverColor)
                        );

                // add the scroll thumb and hover image to the main scrollbar thumb
                this.scrollBarThumbImg.addChild(this.scrollThumbImg);
                this.scrollBarThumbImg.addChild(this.scrollThumbHoverImg);

                this.scrollThumbHoverInTween = this.game.add.tween(this.scrollThumbHoverImg).to({alpha: 1}, 100);
                this.scrollThumbHoverOutTween = this.game.add.tween(this.scrollThumbHoverImg).to({alpha: 0}, 100);

                this.scrollThumbHoverImg.alpha = 0;

                this.scrollBarThumbImg.inputEnabled = true;
                this.scrollBarThumbImg.input.enableDrag();
                // only allow the thumb vertical drag
                this.scrollBarThumbImg.input.allowHorizontalDrag = false;
                this.scrollBarThumbImg.events.onDragStart.add(this._checkDragThumbBounds, this);
                this.scrollBarThumbImg.events.onDragUpdate.add(this._checkDragThumbBounds, this);
                this.scrollBarThumbImg.events.onDragStop.add(this._checkDragThumbBounds, this);
                this.scrollBarThumbImg.fixedToCamera = true;

                this.scrollBarThumbImg.events.onInputOver.add(function () {
                    this.scrollThumbHoverInTween.start();
                }, this);
                this.scrollBarThumbImg.events.onInputOut.add(function () {
                    this.scrollThumbHoverOutTween.start();
                }, this);

                this.maxScrollY = this.dashletHeight - this.scrollThumbHeight;

                if (this.game.camera.y !== 0) {
                    this._updateScrollThumbToCamera();
                }
            },

            /**
             * Draws the scrollbar background well
             *
             * @return {Phaser.Texture}
             * @private
             */
            _drawScrollBkgdBar: function () {
                var bar = this.game.make.graphics();
                var bkgdFill = this.game.device.ie ? this.scrollBarBkgdFillIE : this.scrollBarBkgdFill;

                bar.lineStyle(this.scrollBarBkgdBorderLineSize, this.scrollBarBkgdBorderColor, 1);
                bar.beginFill(bkgdFill, 1);
                bar.drawRect(0, 0, this.scrollBarBkgdWidth, this.dashletHeight);
                return bar.generateTexture();
            },

            /**
             * Draws the actual scrollbar thumb
             *
             * @return {Phaser.Texture}
             * @private
             */
            _drawScrollThumb: function (fillColor) {
                var thumb = this.game.make.graphics();
                thumb.lineStyle(0);
                thumb.beginFill(fillColor, 1);

                if (this.game.device.ie) {
                    thumb.drawRect(0, 0, this.scrollBarBkgdWidth, this.scrollThumbHeight);
                } else {
                    thumb.drawRoundedRect(
                            0,
                            0,
                            this.scrollThumbWidth,
                            this.scrollThumbHeight - this.scrollThumbTopBottomPadding - this.scrollThumbTopBottomPadding,
                            5
                            );
                }

                return thumb.generateTexture();
            },

            /**
             * Checks the bounds of `sprite` to make sure the Y value
             * is between 0 and the height of the dashlet
             *
             * @param {Phaser.Image} image The Phaser Image to check bounds
             * @private
             */
            _checkBounds: function (image) {
                if (image.cameraOffset.y < 0) {
                    image.cameraOffset.y = 0;
                }
                if (image.cameraOffset.y > this.maxScrollY) {
                    image.cameraOffset.y = this.maxScrollY;
                }
            },

            /**
             * Handles checking bounds of the scrollbar thumb
             * @param image
             * @private
             */
            _checkDragThumbBounds: function (image) {
                var scrollbarDashletDiff;

                this._checkBounds(image);

                if (this.previousScrollThumbY !== image.cameraOffset.y) {
                    // only update camera if scroll thumb changed Y pos

                    // get the percent difference between how far down the scrollbar has moved
                    // and the height of the dashlet
                    scrollbarDashletDiff = image.cameraOffset.y / this.dashletHeight;
                    // multiply that percent diff by the total game world height
                    this.game.camera.y = scrollbarDashletDiff * this.gameWorldHeight;

                    // set the previous to the current camera offset
                    this.previousScrollThumbY = image.cameraOffset.y;
                }
            },

            /**
             * Handles when a user clicks a new category or Show More
             *
             * @param {Phaser.Image|Phaser.Text} target The Phaser text or icon that was clicked
             * @param {Phaser.Image} icon The icon image object for the clicked item
             * @param {boolean} isIcon If the `target` is an image/icon or Text
             * @param {Object} data The server data with records and offset
             * @private
             */
            _setMoreRecordsData: function (target, icon, isShowMore, data) {
                var childGroup;
                var triggerParent;
                var groupIndex = target.parent._groupIndex;
                var isVisible;
                var changeYDelta;
                var nextRowIndex = 0;

                target._isFetching = false;
                icon._isFetching = false;

                if (isShowMore) {
                    // in the case where a user searches for a term, the root group is the parentGroup
                    // and there is no childGroup on that parentGroup
                    childGroup = target.parent.parentGroup.childGroup || target.parent.parentGroup;
                    // set the next row index to whatever the offset is
                    nextRowIndex = target.parent.parentGroup._nextOffset;
                    // the correct parent to trigger changeY on
                    triggerParent = target.parent.parentGroup;
                } else {
                    childGroup = target.parent.childGroup;
                    // only increment the group's index if this is not a "Show More" group situation
                    groupIndex++;
                    // the correct parent to trigger changeY on
                    triggerParent = target.parent;
                }

                if (!childGroup) {
                    childGroup = this._createGroupObject(groupIndex, 0);

                    target.parent.childGroup = childGroup;
                    target.parent.add(childGroup);
                }

                childGroup._previousHeight = childGroup.height;

                _.each(data.records, function (node, index) {
                    this._createLevel(childGroup, node, groupIndex, nextRowIndex + index);
                }, this);

                if (data.next_offset !== -1) {
                    this._createLevel(childGroup, this.showMoreNode, groupIndex, data.next_offset);
                }

                icon.frameName = this.showMoreNodeIconName;
                icon.angle = 0;
                icon._tween.stop();

                if (isShowMore) {
                    // shrink game world as we remove Show More later
                    this.gameWorldHeight -= this.itemRowYPadding;

                    // remove the parent container for the text from its parent
                    target.parent.parent.remove(target.parent);
                    // remove the icon and text from the parent
                    target.parent.remove(icon);
                    target.parent.remove(target);
                    icon.destroy();
                    target.destroy();
                } else {
                    childGroup.y = this.itemRowYPadding;
                    childGroup._nextOffset = data.next_offset;
                }

                isVisible = childGroup.visible;
                changeYDelta = childGroup.height - childGroup._previousHeight;

                if (!isVisible) {
                    changeYDelta = -changeYDelta;
                }

                triggerParent._events.onChangeY.dispatch(changeYDelta, triggerParent);

                this._updateGameWorldSize();
            },
        };

        return $.extend({}, treeConfig, treeState);
    },

    /**
     * Extensible function to add any additional states needed
     *
     * @param {Object} states
     * @return {Object}
     * @protected
     */
    _getAdditionalStates: function (states) {
        return states;
    },

    /**
     * Fetches additional records from the database for a given node id and offset
     *
     * @param {string} id The parent hash id for the record
     * @param {int} offset
     * @param callback
     * @protected
     */
    _fetchMoreRecords: function (id, offset, isShowMore, callback) {
        var callbacks;
        var method = 'create';
        var url = app.api.buildURL(this.treeModule + '/bundledtree', method);
        var payload = {};

        if (!_.isUndefined(id)) {
            payload.root = id;
        }

        if (!_.isUndefined(offset)) {
            payload.offset = offset;
        }

        if (isShowMore && !_.isUndefined(this.currentFilterTerm)) {
            payload.filter = this.currentFilterTerm;
        }

        this.toggleLoading(true);

        callbacks = {
            context: this,
            success: callback,
            complete: _.bind(function () {
                this.activeFetchCt--;
                // when complete, remove the spinning refresh icon from the cog
                // and add back the cog icon
                this.toggleLoading(false);
            }, this)
        };

        this.activeFetchCt++;
        app.api.call(method, url, payload, null, callbacks);
    },

    /**
     * Fetchs a Record given the ID, and sends the response data to `callbacks.success`
     *
     * @param {string} id The ProductTemplate ID Hash to fetch
     * @param {Object} callbacks The callback object with any success/error/complete handler functions
     * @protected
     */
    _fetchRecord: function (id, callbacks) {
        var module = this.getFetchRecordModule();
        var url = app.api.buildURL(module + '/' + id, 'read');
        app.api.call('read', url, null, null, callbacks);
    },

    /**
     * Returns the module name to use for fetching records
     * before sending them to the drawer or record
     *
     * @return {string}
     */
    getFetchRecordModule: function () {
        return this.treeModule;
    },

    /**
     * Sends the ProductTemplate data item to the Quote
     *
     * @param {Object} data The ProductTemplate data
     * @protected
     */
    _sendItemToRecord: function (data) {
        console.log('_sendItemToRecord data : ', data);
        this._massageDataBeforeSendingToRecord(data);

        var viewDetails = this.closestComponent('record') ?
                this.closestComponent('record') :
                this.closestComponent('create');
        // need to trigger on app.controller.context because of contexts changing between
        // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
        // app.controller.context is the only consistent context to use
        if (!_.isUndefined(viewDetails)) {
            app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', data);
        }
    },

    /**
     * Allows `data` to be manipulated and updated before sending to the record
     *
     * @param {Object} data The data we're sending to the Record
     * @protected
     */
    _massageDataBeforeSendingToRecord: function (data) {
        data.position = 0;
        data._forcePosition = true;

        // copy Template's id and name to where the QLI expects them
        data.product_template_id = data.id;
        data.product_template_name = data.name;

        // remove ID/etc since we dont want Template ID to be the record id
        delete data.id;
        delete data.status;
        delete data.date_entered;
        delete data.date_modified;
        delete data.pricing_formula;
    },

    /**
     * Sends the ProductTemplate data item to a Drawer layout
     *
     * @param {Object} data The ProductTemplate data
     * @protected
     */
    _openItemInDrawer: function (data) {
        var model = app.data.createBean('ProductTemplates', data);
        var viewDetails = this.closestComponent('record') ?
                this.closestComponent('record').cid :
                this.closestComponent('create').cid;

        model.viewId = viewDetails;
        app.drawer.open({
            layout: 'product-catalog-dashlet-drawer-record',
            context: {
                module: 'ProductTemplates',
                model: model
            }
        });
    },

    /**
     * Handles when sending ProductTemplate data has been complete and we can enable the tree again
     *
     * @protected
     */
    _onProductDashletAddComplete: function () {
        this.isFetchActive = false;
        this.$('#product-catalog-container-' + this.cid).removeClass('disabled');
    },

    /**
     * Resizes the Phaser Canvas width and height when the window is resized
     *
     * @protected
     */
    _resizePhaserCanvas: function () {
        var $el = this.$('.product-catalog-container-' + this.cid);

        if (this.phaser && $el.length && this.phaser.scale) {
            this.phaser.scale.setGameSize($el.width(), $el.height());
            this.phaser.events.onResize.dispatch();
        }
    },

    /**
     * @inheritdoc
     */
    _dispose: function () {
        var sidebarLayout = this.closestComponent('sidebar');
        if (sidebarLayout) {
            sidebarLayout.off('sidebar:state:changed', null, this);
        }
        this.context.off('phaserio:ready', null, this);

        // If Phaser exists, destroy it
        if (this.phaser) {
            this.phaser.events.destroy();
            // async the phaser destroy event so it
            // has a chance to finish its update before destroy
            _.delay(_.bind(function () {
                this.phaser.destroy();
            }, this), 25);

        }

        // any cleanup
        this.$('.product-catalog-container-' + this.cid).off(this.wheelEventName);
        // remove window resize event
        $(window).off('resize');
        if (app.controller && app.controller.context) {
            if (this.isConfig) {
                this._super('_dispose');
                return;
            }

            var viewDetails = this.closestComponent('record') ?
                    this.closestComponent('record') :
                    this.closestComponent('create');

            if (!_.isUndefined(viewDetails)) {
                app.controller.context.off(viewDetails.cid + ':productCatalogDashlet:add:complete', null, this);
            }
        }
        this._super('_dispose');
    }
})
