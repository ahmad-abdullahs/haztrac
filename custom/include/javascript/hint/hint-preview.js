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
 * Extends `clients/base/layouts/preview/preview.js` in a way that allows 
 * a safe uninstall. The purpose of this extension is to add custom views
 * to the existing preview layout so the users would be able to view
 * enriched data more easily.
 */
(function(app) {
    /**
     * Check the type of the main layout.
     * 
     * @param {String} layoutName The name of the expected layout.
     * @returns {Boolean} True if the expected layout is rendered.
     */
    function isGivenLayout(layoutName) {
        return app.controller.layout && app.controller.layout.name === layoutName;
    }

    /**
     * Will try to lookup and return a view based on a hierarchy tree,
     * where the last item is the name of the target view.
     * 
     * @param {View.Layout} rootCmp A layout representing the root element.
     * @param {Array} hierarchyPath A path through the component hierarchy tree.
     * Given a root element and the navigation path we should be able to
     * access the target component.
     * @returns {View.Layout/View.View/undefined} Returns the target view or undefined if not found.
     */
    function getView(component, hierarchyPath) {
        while (component && hierarchyPath.length) {
            component = component.getComponent(hierarchyPath.shift());
        }
        return component;
    }

    /**
     * Will attempt to get the preview layout. There may be 2 preview layouts simultaneously
     * (one on the base layout and one in a create drawer). In order to get the relevant layout
     * we will assume that the drawer is active and get the layout from it. If we don't succeed,
     * it means that we have the preview layout on the base layout.
     * 
     * @returns {View.Layout/undefined} A preview layout or undefined if not found.
     */
    function getPreview() {
        var previewCmpPath = ['sidebar', 'preview-pane', 'preview'];
        return getView(app.drawer, ['create'].concat(previewCmpPath)) ||
            getView(app.controller.layout, previewCmpPath);
    }

    /**
     * Will add a child component meta to the preview indicated.
     * 
     * @param {View.Layout} preview The parent of the components to be added.
     * @param {Object} cmp The definition of a component to be added.
     * @param {String/undefined} type The type of the component, optional, defaults to 'view'.
     */
    function addViewToPanelMeta(preview, cmp, type) {
        var component = {
            context: {
                forceNew: true
            }
        };
        component[type || 'view'] = cmp;
        preview._componentsMeta.push(component);
    }

    /**
     * Checks if the model is enriched by hint.
     * 
     * @param {Data.Bean} model The model used to populate the preview.
     * @returns {Boolean} True if it's enriched.
     */
    function isEnrichedModel(model) {
        var enrichedModules = ['Leads', 'Contacts', 'Accounts'];
        return _.contains(enrichedModules, model.module);
    }

    /**
     * Checks if the preview has been triggered from a module which may be related
     * to a hint enriched module. This may happen if a record view has a subpanel
     * related to a module enriched by hint. The given modules may hold such subpanel entries.
     *
     * @param {Data.Bean} model The model to populate the preview with.
     * @returns {Boolean} True if the given model appears in the subpanel
     * of the active record view.
     */
    function isTriggeredOnSubpanel(model) {
        var hasModelFromSubpanel = false;
        var recordModel = app.controller.layout.model;
        var moduleLink = model.link && model.link.name;

        if (moduleLink && isGivenLayout('record') && recordModel) {
            var relatedCollection = recordModel.getRelatedCollection(moduleLink);
            var relatedModel = relatedCollection && relatedCollection.get(model.cid);
            hasModelFromSubpanel = !!relatedModel;
        }

        return hasModelFromSubpanel;
    }

    /**
     * Checks if the preview has been triggered from a list view. Have to consider
     * the case when the user opens a merge preview, since the underlieing active
     * layout is still the list view.
     *
     * @param {Data.Bean} preview The preview being subjct of the render event.
     * @returns {Boolean} True if the preview meant to be rendered on a list view.
     */
    function isTriggeredOnListview(preview) {
        return isGivenLayout('records') && !isInMergeView(preview);
    }

    /**
     * Checks if the given preview exists in scope of a merge duplicate process.
     * 
     * @param {View.Layout} preview The active preview layout.
     * @returns {Boolean} True of the merge duplicates layout is opened.
     */
    function isInMergeView(preview) {
        return preview.options.type === 'merge-duplicates-preview';
    }

    /**
     * Checks if the base layout is the create layout.
     * Create layout may exist in scope of a drawer, but in case the user hits
     * refresh Sugar reloads and renders the create layout as it is, without drawer.
     * @returns {Boolean} True if the create layout is opened.
     */
    function isCreateLayout() {
        return !!(getView(app.drawer, ['create']) || isGivenLayout('create'));
    }

    /**
     * Checks if preview is triggered from an enriched record view. Since by default preview
     * is not available on a record view, we check if the appropriate preview id has been set.
     * For more details about preview id please check the `hint-dashboardtitle` field.
     * 
     * @param {Data.Bean} model The model to populate the preview with.
     * @returns {Boolean} True if the preview has been triggered by the Hint dashboard button.
     */
    function isEnrichedRecordView(model) {
        var isEnrichedRecord = isGivenLayout('record') && isEnrichedModel(model);
        var dashBoardHeaderPath = ['sidebar', 'dashboard-pane', 'dashboard', 'dashboard-headerpane'];
        var dashBoardHeader = getView(app.controller.layout, dashBoardHeaderPath);

        if (isEnrichedRecord && dashBoardHeader) {
            var dashboardTitle = _.findWhere(dashBoardHeader.fields, { type: 'hint-dashboardtitle' });
            isEnrichedRecord = dashboardTitle && dashboardTitle.getHintState(dashboardTitle.hintStateKey);
        }

        return isEnrichedRecord;
    }

    /**
     * Checks if the hint preview should be rendered instead of default preview. There are four cases, when
     * hint preview should be applied (for each case we need to have a hint enriched model):
     * 1. Preview is triggered from the create layout.
     * 2. Preview is triggered through a global search result.
     * 3. Preview is triggered from a regular list view.
     * 4. Preview is triggered from a subpanel of a module which is not enriched by hint.
     * 5. Preview is triggered from an enriched record view.
     * 
     * @param {View.Layout} preview The active preview layout.
     * @param {Data.Bean} model The model used to populate the given preview, but returned through an event.
     * The difference is that it holds extra information compared to the model directly accessible through preview.
     * @returns {Boolean} True if the hint preview should be rendered.
     */
    function isHintPreview(preview, model) {
        var doesHintApply = false;
        if (isEnrichedModel(model)) {
            doesHintApply = isCreateLayout() || isGivenLayout('search') ||
                isTriggeredOnListview(preview) || isTriggeredOnSubpanel(model) || isEnrichedRecordView(model);
        }
        return doesHintApply;
    }

    /**
     * In case of Accounts we need to display any related accounts, but only on list view.
     * 
     * @returns {Boolean} True if related contacts should be displayed.
     */
    function shouldShowRelatedContacts(model) {
        return model.module === 'Accounts' && isGivenLayout('records');
    }

    /**
     * Will add metadata to the preview so the preview would be able to
     * render components specific to the hint data-enrichment.
     * 
     * @param {View.Layout} preview The active preview layout.
     * @param {Data.Bean} model The model used to populate the preview layout.
     */
    function addHintPreviewComponents(preview, model) {
        preview._componentsMeta = [];
        addViewToPanelMeta(preview, 'hint-preview-header');
        preview._componentsMeta.push({
            view: 'stage2-preview',
        });

        if (!isCreateLayout()) {
            if (shouldShowRelatedContacts(model)) {
                addViewToPanelMeta(preview, {
                    type: 'hint-panel-header',
                    icon: 'user',
                    title: 'LBL_HINT_CONTACTS_TITLE'
                });
                addViewToPanelMeta(preview, 'stage2-related-contacts');
            }
            addViewToPanelMeta(preview, 'hint-news-panel', 'layout');
            addViewToPanelMeta(preview, {
                type: 'hint-panel-header',
                icon: 'history',
                title: 'LBL_HINT_HISTORY_TITLE'
            });
            addViewToPanelMeta(preview, 'stage2-history');
        }
    }

    /**
     * Will add back the default metadata to the preview layout.
     * This needs to be done after a non-enriched module's record
     * is previewed after an enriched model has been.
     * 
     * @param {String} moduleName Module name to be supplied for the getLayout method to work correctly.
     * @param {View.Layout} preview The active preview layout.
     */
    function addDefaultPreviewComponents(moduleName, preview) {
        preview._componentsMeta = app.metadata.getLayout(moduleName, 'preview').components;
    }

    /**
     * Event listener which is triggered by the `preview:render` event.
     * In case an active preview layout is found and the model also has been changed,
     * it will check which kind of preview should be rendered (default or hint).
     * This listener is executed before the default listener from the original preview;
     * by modifying the metadata we can indicate which components need to be rendered.
     * 
     * @param {Data.Bean} model The model used to populate the active preview layout.
     */
    function togglePreview(model, collection) {
        var preview = getPreview();

        if (!preview || !preview._isActive()) {
            return;
        }

        var hasComponents = !_.isEmpty(preview._components);
        var isSameModel = model == preview.context.get('model');
        var modelChanged = preview.context.get('module') !== model.module;

        if (!isSameModel && (!hasComponents || modelChanged)) {
            if (isHintPreview(preview, model)) {
                addHintPreviewComponents(preview, model);
            } else {
                addDefaultPreviewComponents(model.module, preview);
            }
        }
    }

    app.events.on('preview:render', togglePreview);
})(SUGAR.App);
