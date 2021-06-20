({
    extendsFrom: 'BaseField',

    events: {
        'click .removeRecord:not(.disabled)': 'deleteRow',
        'click .addRecord:not(.disabled)': 'addRow',
    },

    fieldIds: [],
    previewData: [],
    modelFields: {},
    isFirst: true,
    enablePlusButton: false,
    addClass: 'addRecord',
    isPreview: false,

    dateOptions: {
        hash: {
            dateOnly: true
        }
    },

    initialize: function (options) {
        this.previewData = [];
        this.isPreview = false;
        this._super('initialize', [options]);
    },

    format: function (value) {
        this.previewData = JSON.parse(value || "[]");
        return this._super("format", [value]);
    },

    getCurrentNewRowUid: function () {
        // The row with the + icon is the new row.
        return this.$('.' + this.addClass).data('uid');
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    render: function () {
        // Remove the fields which we have on the view, because everytime it render, It create new fields.
        this.unsetOldFields();
        // Empty the fieldIds, we will have new fields as we are going to render it.
        this.fieldIds = [];
        this._super('render');
        this.renderFieldsMetaAndValues();

        var sortableItems;
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

        this.updateRowIndexing();
    },

    _onDragStart: function (evt, ui) {
//        console.log('_onDragStart : ', this, evt, ui);
    },

    _onDragStop: function (evt, ui) {
//        console.log('_onDragStop : ', this, evt, ui);

        // This function will go over each row one by one, get the line_number value (This line_number value is the index
        // of that data object in this.value array), extract that object from the index and push it to the new array for
        // re-ordering the rows. 
        // Finally set the value and render the field.
//        var newValue = [];
//        _.each(this.$('tbody > tr.ui-sortable-handle'), function (ele) {
//            var obj = this.value[$(ele).attr('line_number')];
//            newValue.push(obj);
//        }, this);
//
//        newValue = JSON.stringify(newValue);
//        this.model.set(this.name, newValue);
//        this.render();

        var line_number = 1;
        _.each(this.$('tbody > tr.ui-sortable-handle').find('input[name*=transporter_name__]'), function (ele) {
            if ($(ele).val() && $(ele).attr('name').split('__')[1]) {
                this.model.set('transporter_line_number__' + $(ele).attr('name').split('__')[1], line_number, {
                    silent: true
                });
                line_number++;
            }
        }, this);
        this.updateJSON();
    },

    _onGroupDragTriggerOver: function (evt, ui) {
//        console.log('_onGroupDragTriggerOver : ', this, evt, ui);
    },

    _onGroupDragTriggerOut: function (evt, ui) {
//        console.log('_onGroupDragTriggerOut : ', this, evt, ui);
    },

    unsetOldFields: function () {
        if (!_.isUndefined(this.fieldIds) || !_.isNull(this.fieldIds)) {
            _.each(this.fieldIds, function (id) {
                _.each(this.def.fields, function (field) {
                    var field_name = field.name + "__" + id;
                    if (!_.isUndefined(this.model.get(field_name))) {
                        this.model.unset(field_name, {silent: true});
                        this.model.off('change:' + field_name);
                    }
                }, this);
            }, this);
        }
    },

    renderFieldsMetaAndValues: function () {
        var field = this.model.get(this.name) || "[]";
        var newRowObj = {};
        var rowExist = false;

        // Insert row by row.
        var fieldObj = JSON.parse(field);
        _.each(fieldObj, function (rowObj, index) {
            if (!this.isRowEmpty(rowObj)) {
                rowExist = true;
                this.insertRow(rowObj, false, (index + 1));
            }
        }, this);

        // If no row exist then make the first row as the primary row.
        if (!rowExist) {
            this.model.set(this.name, '[]', {silent: true});
            newRowObj[this.name + '_primary_account'] = "1";
            var parentCtx = this.context && this.context.parent;
            if (this.view instanceof app.view.views.BaseCreateView &&
                    parentCtx.get('module') === 'Accounts' && this.module !== 'Accounts') {
                newRowObj[this.name + '_name_id'] = parentCtx.get('model').get('id');
                newRowObj[this.name + '_name'] = parentCtx.get('model').get('name');
                this.enablePlusButton = true;
            }
        }

        if ((this.action === 'edit' || -1 !== _.indexOf(['edit', 'list-edit'], this.tplName))) {
            this.insertRow(newRowObj, true);
        }

        this.renderInnerFields();

        // If data is already populated in the row at time of new record creation
        // enable the [+] button for users to add another row.
        if (this.enablePlusButton && this.fieldIds[0]) {
            this.$('.' + this.addClass + '[data-uid=' + this.fieldIds[0] + ']').removeClass('disabled');
//            this.model.set(this.name + '_name_id__' + this.fieldIds[0], parentCtx.get('model').get('id'));
//            this.model.set(this.name + '_name__' + this.fieldIds[0], parentCtx.get('model').get('name'));
            this.updateJSON();
        }
    },

    isRowEmpty: function (rowObj) {
        var empty = true;
        _.each(rowObj, function (value, key) {
            if (!_.isEmpty(value)) {
                empty = false;
                return;
            }
        });

        return empty;
    },

    insertRow: function (rowObj, isNew, index) {
        var labelsOnTop = false;
        if (this.isFirst) {
            labelsOnTop = true;
            this.isFirst = false;
        }
        var fieldTemplate = this.getRowTemplate(rowObj, isNew, labelsOnTop, index);
        this.$('.' + this.name + '-to-insert').append(fieldTemplate);
        return fieldTemplate;
    },

    getRowTemplate: function (rowObj, isNew, labelsOnTop, index) {
        var uid = _.uniqueId();
        if (isNew) {
            uid = uid + "_new";
        }
        var modelFields = [];
        var template = this.name + '-row';
        _.each(this.def.fields, function (fieldDef) {
            var extendedObj = {};
            if (isNew) {
                extendedObj.isNew = isNew;
            }
            var innerFieldName = fieldDef.name + "__" + uid;
            extendedObj.name = innerFieldName;
            fieldDef.fuid = uid;
            this.model.set(innerFieldName, rowObj[fieldDef.name]);
            if (this.action == 'detail' && fieldDef.css_class.indexOf('_name') !== -1 && fieldDef.css_class.indexOf('ellipsis_inline') == -1) {
                fieldDef.css_class = fieldDef.css_class + ' ellipsis_inline';
            } else if (this.action == 'edit' && fieldDef.css_class.indexOf('_name') !== -1) {
                fieldDef.css_class = fieldDef.css_class.replace('ellipsis_inline', '');
            }
            if (fieldDef.id_name) {
                extendedObj.id_name = fieldDef.id_name + "__" + uid;
                this.model.set(extendedObj.id_name, rowObj[fieldDef.id_name]);
            }
            if (fieldDef.name == (this.name + "_name") && isNew) {
                this.model.on('change:' + innerFieldName, this.checkPlusButton, this);
            } else {
                if (fieldDef.name == this.name + '_name') {
                    this.model.on('change:' + innerFieldName, _.bind(this.updateName, this, innerFieldName), this);
                } else {
                    this.model.on('change:' + innerFieldName, _.bind(this.updateJSON, this, _.clone(fieldDef)), this);
                }
            }

            if (fieldDef.default != false) {
                modelFields.push(_.extend({}, fieldDef, extendedObj));
            }
        }, this);

        var fieldAction = (this.action === 'edit' || -1 !== _.indexOf(['edit', 'list-edit'], this.tplName)) ? "edit" : "detail";
        if (this.tplName === 'preview') {
            fieldAction = "preview";
            this.isPreview = true;
        }

        var modelRowTemplate = app.template.getField(this.type, template, this.module);
        var fieldTemplate = modelRowTemplate({
            view: this.view,
            model: this.model,
            fieldAction: fieldAction,
            isNew: isNew,
            labelsOnTop: labelsOnTop,
            modelFields: modelFields,
            uid: uid,
            isPreview: this.isPreview,
            rowIndex: index, // for row numbering on the detail view
        });

        this.fieldIds.push(uid);
        return fieldTemplate;
    },

    updateName: function (innerFieldName, model) {
        var value = model.get(innerFieldName) || '';
        var uid = (innerFieldName.split('__'))[1];
        if (uid) {
            if (_.isEmpty(value)) {
                var fieldsToCheck = ['_name__', '_name_id__'];
                var keepRow = false;
                _.each(fieldsToCheck, function (field) {
                    var val = model.get(this.name + field + uid) || '';
                    if (!_.isEmpty(val)) {
                        keepRow = true;
                    }
                }, this);
                if (keepRow) {
                    this.updateJSON();
                } else {
                    this.deleteRowFromUid(uid);
                }
            } else {
                this.updateJSON();
            }
        }
    },

    checkPlusButton: function (model, value) {
        var changedFields = _.keys(model.changed);
        var obj = this.parseFieldNames(changedFields);
        var nruid = this.getCurrentNewRowUid();
        if (value) {
            if (obj.isNew) {
                this.$('.' + this.addClass + '[data-uid=' + obj.id + ']').removeClass('disabled');
            }
        } else {
            this.$('.' + this.addClass + '[data-uid=' + obj.id + ']').addClass('disabled');
        }
        if (obj.id == nruid && value) {
            this.addRowFromUid(obj.id);
        }
        this.updateJSON(model, value);
    },

    updateJSON: function (fieldMeta, model, value) {
        var jsonField = [];
        var nruid = this.getCurrentNewRowUid();
        _.each(this.fieldIds, function (uid, key) {
            var obj = {};
            var isEmpty = false;
            _.each(this.def.fields, function (fieldDef, _key) {
                var fieldName = fieldDef.name + "__" + uid;

                if (fieldDef.short_name == 'transporter_line_number') {
                    // To keep the line number ordering...
                    obj[fieldDef.name] = this.model.get(fieldName) || (key + 1);
                } else {
                    obj[fieldDef.name] = this.model.get(fieldName) || "";
                }

                if (fieldDef.id_name) {
                    var fname = fieldDef.id_name + "__" + uid;
                    var val = this.model.get(fname) || "";
                    if (_.isEmpty(val)) {
                        isEmpty = true;
                    }
                    obj[fieldDef.id_name] = val;
                }
            }, this);
            if (uid != nruid || this.enablePlusButton) {
                jsonField.push(obj);
            }
        }, this);

        jsonField = _.sortBy(jsonField, 'transporter_line_number');

        this.model.set(this.name, JSON.stringify(jsonField), {silent: true});
        this.previewData = jsonField;

        this.updateRowIndexing();
    },

    updateRowIndexing: function (fieldNames) {
        _.each(this.$('div[name*=transporter_row_index]'), function (ele, index) {
            $(ele).html(index + '.');
        });
    },

    parseFieldNames: function (fieldNames) {
        var retObj = {};
        retObj.fields = [];
        retObj.isNew = false;
        _.each(fieldNames, function (name) {
            if (name.indexOf("__") !== -1) {
                var parts = name.split("__");
                var secPart = parts.length > 1 ? parts[1].split("_") : parts[0].split("_");
                var thrdPart = secPart[1] || false;
                if (thrdPart) {
                    retObj.isNew = true;
                }
                retObj.fields.push(parts[0]);
                retObj.id = parts[1];
            }
        }, this);
        return retObj;
    },

    renderInnerFields: function () {
        var self = this;
        self.modelFields = {};
        this.$('span[sfuuid]').each(function () {
            var sfId = $(this).attr('sfuuid');
            try {
                var fieldToRender = self.view.fields[sfId];
                // Added for preview eye ball icon
                fieldToRender.iconVisibility = true;
                // This piece of code is added to avoid the autopopulation of Account field 
                // when the contact is created on top of any Account record, it starts auto populating the 
                // Account id in every account field on [+] button click
                if (self.view instanceof app.view.views.BaseCreateView) {
                    fieldToRender.noAutoPopulate = true;
                }

                if (self.tplName != "preview") {
                    self.view.editableFields.push(fieldToRender);
                }

                self.view._renderField(fieldToRender);
                self.modelFields[sfId] = fieldToRender;
            } catch (e) {
            }
        });
    },

    deleteRow: function (evt) {
        var el = evt.currentTarget;
        var uid = $(el).data('uid');
        this.deleteRowFromUid(uid);
    },

    deleteRowFromUid: function (uid) {
        this.removeFieldsFromDOM(uid);
        this.unbindDataChangesFromFields(uid);
        this.updateJSON();
    },

    addRow: function (evt) {
        var el = evt.currentTarget;
        var uid = $(el).data('uid');
        this.addRowFromUid(uid);
    },

    addRowFromUid: function (uid) {
        this.insertRow({}, true);
        this.renderInnerFields();
        this.changeAddButtonToRemove(uid);
    },

    changeAddButtonToRemove: function (uid) {
        this.$('.btn[data-uid=' + uid + ']').removeClass(this.addClass);
        this.$('.btn[data-uid=' + uid + ']').addClass('removeRecord');
        this.$('.btn[data-uid=' + uid + '] > i').removeClass('fa-plus');
        this.$('.btn[data-uid=' + uid + '] > i').addClass('fa-minus');
    },

    removeFieldsFromDOM: function (uid) {
        _.each(this.def.fields, function (fieldDef) {
            var innerFieldName = fieldDef.name + "__" + uid;
            var field = this.view.getField(innerFieldName);
            // This check is added because it throws undefined error for default = false field.
            // Since they have the attribute in model but they are not the actual fields.
            if (field) {
                delete this.modelFields[field.sfId];
            }
        }, this);
        this.fieldIds = _.without(this.fieldIds, uid);
        this.fieldIds = _.without(this.fieldIds, uid.toString());
        this.$('.' + this.name + '_row[data-uid=' + uid + ']').remove();
    },

    unbindDataChangesFromFields: function (uid) {
        _.each(this.def.fields, function (fieldDef) {
            var innerFieldName = fieldDef.name + "__" + uid;
            this.model.off('change:' + innerFieldName);
        }, this);
    },

    dispose: function () {
        _.each(this.fieldIds, function (uid) {
            this.unbindDataChangesFromFields(uid);
        }, this);
        this.fieldIds = [];
        this.modelFields = {};
        this.isFirst = true;
        this._super('dispose');
    },
})