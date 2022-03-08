({
    extendsFrom: 'AuditView',

    // Overrided this to format the multienum-relate field for sales and services module
    _renderData: function() {
        var parentModule = this.context.parent.get('module');
        var fields = app.metadata.getModule(parentModule).fields;

        _.each(this.collection.models, function(model) {
            model.fields = app.utils.deepCopy(this.metaFields);

            var before = _.findWhere(model.fields, {name: 'before'});
            _.extend(before, fields[model.get('field_name')], {name: 'before'});

            var after = _.findWhere(model.fields, {name: 'after'});
            _.extend(after, fields[model.get('field_name')], {name: 'after'});

            // FIXME: Temporary fix due to time constraints, proper fix will be addressed in TY-359
            // We can check just `before` since `before` and `after` refer to same field
            if (_.contains(['multienum', 'enum'], before['type']) && before['function']) {
                before['type'] = 'base';
                after['type'] = 'base';
            }

            if (_.contains(['multienum'], before['type']) && model.get('field_name') == 'sales_and_service_assets_and_objects') {
                before['type'] = 'base';
                after['type'] = 'base';
            }

            // FIXME: This method should not be used as a public method (though
            // it's being used everywhere in the app) this should be reviewed
            // when SC-3607 gets in
            model.fields = app.metadata._patchFields(
                this.module,
                app.metadata.getModule(this.module),
                model.fields
            );
        }, this);

        this.filteredCollection = this.collection.models;
        this.filterCollection();
        this.render();
    }
})