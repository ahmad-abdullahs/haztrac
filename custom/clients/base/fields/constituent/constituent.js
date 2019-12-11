({
    extendsFrom: 'BaseField',
    events: {
        'click .removeRecord:not(.disabled)': 'deleteRow',
        'click .addRecord:not(.disabled)': 'addRow',
    },
    fieldIds: [],
    usepaWasteCodes: [],
    modelFields: {},
    isFirst: true,
    addClass: 'addRecord',
    initialize: function (options) {
        this._super('initialize', [options]);
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
    },

    /*
     * Check if the model has the attribute with the field id suffix
     * unset that field and turn off the change listner.
     * @returns {undefined}
     */
    unsetOldFields: function () {
        _.each(this.fieldIds, function (id) {
            _.each(this.def.fields, function (field) {
                var field_name = field.name + "__" + id;
                if (this.model.has(field_name)) {
                    this.model.unset(field_name, {silent: true});
                    this.model.off('change:' + field_name);
                }
            }, this);
        }, this);
    },

    /*
     * Render 1-   All rows one by one.
     *        1.1- First insert the non-empty row.
     *        1.2- Render the inner fields one by one.
     * @returns {undefined}
     */
    renderFieldsMetaAndValues: function () {
        var field = this.model.get(this.name) || "[]",
                newRowObj = {},
                rowExist = false;

        // Insert row by row.
        var fieldObj = JSON.parse(field);
        _.each(fieldObj, function (rowObj) {
            if (!this.isRowEmpty(rowObj)) {
                rowExist = true;
                this.insertRow(rowObj);
            }
        }, this);

        // If no row exist then set field to default empty.
        if (!rowExist) {
            this.model.set(this.name, '[]', {silent: true});
        }

        if ((this.action === 'edit' || -1 !== _.indexOf(['edit', 'list-edit'], this.tplName))) {
            this.insertRow(newRowObj, true);
        }

        this.renderInnerFields();
    },

    /*
     * If a single field has a value in the row, row will not be empty
     * @param {type} rowObj
     * @returns {bool} true if all fields are empty else false.
     */
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

    /*
     * Get the row template and insert it on the dom.
     */
    insertRow: function (rowObj, isNew) {
        var labelsOnTop = false;
        if (this.isFirst) {
            labelsOnTop = true;
            this.isFirst = false;
        }
        var fieldTemplate = this.getRowTemplate(rowObj, isNew, labelsOnTop);
        this.$('.' + this.name + '-to-insert').append(fieldTemplate);
    },

    getRowTemplate: function (rowObj, isNew, labelsOnTop) {
        var uid = _.uniqueId(), template = 'row',
                modelFields = [],
                extendedObj = {};

        if (isNew) {
            uid = uid + "_new";
        }

        _.each(this.def.fields, function (fieldDef) {
            extendedObj = {};
            if (isNew) {
                extendedObj.isNew = isNew;
            }

            var innerFieldName = fieldDef.name + "__" + uid;
            extendedObj.name = innerFieldName;
            fieldDef.fuid = uid;
            this.model.set(innerFieldName, rowObj[fieldDef.name]);

            if (fieldDef.name == this.def.primary_field && isNew) {
                this.model.on('change:' + innerFieldName, this.checkPlusButton, this);
            } else {
                if (fieldDef.name == this.def.primary_field) {
                    this.model.on('change:' + innerFieldName, _.bind(this.updateName, this, innerFieldName), this);
                } else {
                    this.model.on('change:' + innerFieldName, _.bind(this.updateJSON, this, _.clone(fieldDef)), this);
                }
            }

            modelFields.push(_.extend({}, fieldDef, extendedObj));
        }, this);

        var fieldAction = (this.action === 'edit' || -1 !== _.indexOf(['edit', 'list-edit'], this.tplName)) ? "edit" : "detail";

        var modelRowTemplate = app.template.getField(this.type, template, this.module);
        var fieldTemplate = modelRowTemplate({
            view: this.view,
            model: this.model,
            name: this.name,
            fieldAction: fieldAction,
            isNew: isNew,
            labelsOnTop: labelsOnTop,
            modelFields: modelFields,
            uid: uid,
        });

        this.fieldIds.push(uid);
        return fieldTemplate;
    },

    updateName: function (innerFieldName, model) {
        var value = model.get(innerFieldName) || '';
        var uid = (innerFieldName.split('__'))[1];
        if (uid) {
            if (_.isEmpty(value)) {
                var fieldsToCheck = ['_min__', '_max__', '_uom__'];
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
        this.updateJSON();
    },

    updateJSON: function () {
        var jsonField = [];
        this.usepaWasteCodes = [];
        var nruid = this.getCurrentNewRowUid();
        _.each(this.fieldIds, function (uid) {
            var obj = {};
            _.each(this.def.fields, function (fieldDef) {
                var fieldName = fieldDef.name + "__" + uid;
                obj[fieldDef.name] = this.model.get(fieldName) || "";
                if (fieldDef.id_name) {
                    var fname = fieldDef.id_name + "__" + uid;
                    var val = this.model.get(fname) || "";
                    obj[fieldDef.id_name] = val;
                }

                /*USEPA HAZARDOUS WASTE CODES*/
                if (fieldDef.name == this.def.primary_field) {
                    this.usepaWasteCodes.push(this.model.get(fieldName));
                }

            }, this);
            if (uid != nruid) {
                jsonField.push(obj);
            }
        }, this);
        this.model.set(this.name, JSON.stringify(jsonField), {silent: true});
        this.model.trigger('change:quest_usepa_hazardous_waste_c');
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
                self.view.editableFields.push(fieldToRender);
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
            delete this.modelFields[field.sfId];
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

    getCurrentNewRowUid: function () {
        // The row with the + icon is the new row.
        return this.$('.' + this.addClass).data('uid');
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