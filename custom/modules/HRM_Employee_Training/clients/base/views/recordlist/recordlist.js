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
 * @class View.Views.Base.RecordlistView
 * @alias SUGAR.App.view.views.BaseRecordlistView
 * @extends View.Views.Base.FlexListView
 */
({
    extendsFrom: 'RecordlistView',

    contextEvents: {
        "list:editall:fire": "toggleEdit",
        "list:editrow:fire": "editClicked",
        "list:deleterow:fire": "warnDelete",
        "list:duplicate_button:fire": "duplicateClicked",
    },

    /**
     * @override
     * @param {Object} options
     */
    initialize: function (options) {
        this._super("initialize", [options]);
    },

    duplicateClicked: function (collectionModel) {
        var employeeTrainingModel = app.data.createBean(collectionModel.get('_module'), {id: collectionModel.id});
        employeeTrainingModel.fetch({
            'showAlerts': false,
            'success': _.bind(function (employeeTrainingModel) {
                var prefill = app.data.createBean(collectionModel.get('_module'));

                prefill.copy(employeeTrainingModel);
                this._copyNestedCollections(employeeTrainingModel, prefill);
                employeeTrainingModel.trigger('duplicate:before', prefill);
                prefill.unset('id');
                app.drawer.open({
                    layout: 'create',
                    context: {
                        create: true,
                        model: prefill,
                        copiedFromModelId: employeeTrainingModel.get('id')
                    }
                }, function (context, newModel) {
                    if (newModel && newModel.id) {
                        app.router.navigate(collectionModel.get('_module') + '/' + newModel.id, {trigger: true});
                    }
                });

                prefill.trigger('duplicate:field', employeeTrainingModel);

            }, this)
        }, this);
    },

    _copyNestedCollections: function (source, target) {
        var collections, view;

        // only model's that utilize the VirtualCollection plugin support this
        // functionality
        if (!_.isFunction(source.getCollectionFieldNames)) {
            return;
        }

        // avoid using the ambiguous `this` since there are references to many
        // objects in this method: view, field, model, collection, source,
        // target, etc.
        view = this;

        /**
         * Removes the `_action` attribute from a model when cloning it.
         *
         * @param {Data.Bean} model
         * @return {Data.Bean}
         */
        function cloneModel(model) {
            var attributes = _.chain(model.attributes).clone().omit('_action').value();
            return app.data.createBean(model.module, attributes);
        }

        /**
         * Copies all of the models from a collection to the same collection on
         * the target model.
         *
         * @param collection
         */
        function copyCollection(collection) {
            var field, relatedFields, options;

            /**
             * Adds all of the records from the source collection to the same
             * collection on the target model.
             *
             * @param {VirtualCollection} sourceCollection
             * @param {Object} [options]
             */
            function done(sourceCollection, options) {
                var targetCollection = target.get(collection.fieldName);

                if (!targetCollection) {
                    return;
                }

                targetCollection.add(sourceCollection.map(cloneModel));
            }

            field = view.getField(collection.fieldName, source);
            relatedFields = [];

            if (field.def.fields) {
                relatedFields = _.map(field.def.fields, function (def) {
                    return _.isObject(def) ? def.name : def;
                });
            }

            options = {success: done};

            // request the related fields from the field definition if possible
            if (relatedFields.length > 0) {
                options.fields = relatedFields;
            }

            collection.fetchAll(options);
        }

        // get all attributes from the source model that are collections
        collections = _.intersection(source.getCollectionFieldNames(), _.keys(source.attributes));

        _.each(collections, function (name) {
            copyCollection(source.get(name));
        });
    },

})
