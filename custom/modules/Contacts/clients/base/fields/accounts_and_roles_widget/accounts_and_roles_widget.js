({
    extendsFrom: 'BaseField',
    events: {
        'click .removeRecord:not(.disabled)': 'deleteRow',
        'click .addRecord:not(.disabled)': 'addRow',
        'click .addOption:not(.disabled)': 'addOption',
        'click .saveOption:not(.disabled)': 'saveOption',
        'click .cancelOption:not(.disabled)': 'cancelOption',
    },
    fieldIds: [],
    modelFields: {},
    isFirst: true,
    enablePlusButton: false,
    addClass: 'addRecord',
    isPreview: false,

    initialize: function (options) {
        this.isPreview = false;
        this._super('initialize', [options]);
        app.events.on('refresh:multi-dd:fields', this.refreshDropdownFields, this);
    },

    refreshDropdownFields: function (data){
        var self = this;
        var fieldName = 'accounts_and_roles_widget_role';
        this.$('span[sfuuid]').each(function () {
            var sfId = $(this).attr('sfuuid');
            try {
                var fieldToRender = self.view.fields[sfId];
                if(fieldToRender.name.indexOf(fieldName) !== -1 && data[0].def.options == fieldToRender.def.options){
                    fieldToRender.items[data[2]] = data[1];
                    fieldToRender.render();
                }
            } catch (e) {
                console.log("Error occurred", e);
            }
        });
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
        _.each(fieldObj, function (rowObj) {
            if (!this.isRowEmpty(rowObj)) {
                rowExist = true;
                this.insertRow(rowObj);
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
    insertRow: function (rowObj, isNew) {
        var labelsOnTop = false;
        if (this.isFirst) {
            labelsOnTop = true;
            this.isFirst = false;
        }
        var fieldTemplate = this.getRowTemplate(rowObj, isNew, labelsOnTop);
        this.$('.' + this.name + '-to-insert').append(fieldTemplate);
        return fieldTemplate;
    },
    getRowTemplate: function (rowObj, isNew, labelsOnTop) {
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
            modelFields.push(_.extend({}, fieldDef, extendedObj));
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
        });

        this.fieldIds.push(uid);
        return fieldTemplate;
    },
    updateName: function (innerFieldName, model) {
        var value = model.get(innerFieldName) || '';
        var uid = (innerFieldName.split('__'))[1];
        if (uid) {
            if (_.isEmpty(value)) {
                var fieldsToCheck = ['_primary_account__', '_role__'];
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
        _.each(this.fieldIds, function (uid) {
            var obj = {};
            var isEmpty = false;
            _.each(this.def.fields, function (fieldDef) {
                var fieldName = fieldDef.name + "__" + uid;
                obj[fieldDef.name] = this.model.get(fieldName) || "";
                if (fieldDef.id_name) {
                    var fname = fieldDef.id_name + "__" + uid;
                    var val = this.model.get(fname) || "";
                    if (_.isEmpty(val)) {
                        isEmpty = true;
                    }
                    obj[fieldDef.id_name] = val;
                }

                if (!_.isUndefined(fieldMeta) && !_.isNull(fieldMeta)) {
                    if (fieldMeta.type == "primary-radio" && fieldDef.type == "primary-radio" && fieldMeta.fuid != uid) {
                        obj[fieldDef.name] = "0";
                        this.model.set(fieldName, "0", {silent: true});
                    }
                }
            }, this);
            if (uid != nruid || this.enablePlusButton) {
                jsonField.push(obj);
            }
        }, this);
        this.model.set(this.name, JSON.stringify(jsonField), {silent: true});
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
        this.shiftPrimaryToFirst(uid);
        this.updateJSON();
    },
    shiftPrimaryToFirst: function (uid) {
        var isPrimary = this.model.get(this.name + '_primary_account__' + uid);
        if (isPrimary) {
            var firstUid = _.first(this.fieldIds);
            this.model.set(this.name + '_primary_account__' + firstUid, "1");
        }
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
        this.enablePrimaryOptions(uid);
    },
    addOption: function (evt) {
        evt.preventDefault();
        evt.stopPropagation();
        // Show the input Div
        this.$('[data-name="option-to-add-div"]').toggle();
    },

    saveOption: function (evt) {
        var self = this;
        var optionValue = this.$('[data-name="option-input"]').val();
        optionValue = optionValue.replace(/['"]+/g, '').trim();
        // Check if this is a new option or the existig one?
        // If new then add, if existing discard it.
        var roleField = null;
        _.each(this.modelFields, function (field, index) {
            if (field.name.includes("accounts_and_roles_widget_role") && _.isNull(roleField)) {
                roleField = field;
            }
        });

        var roleKeys = app.lang.getAppListKeys(roleField.items)
        if (!_.contains(roleKeys, optionValue)) {
            // Get all the Role dropdown fields and Add the Option
            var fieldsList = [];
            _.each(this.modelFields, function (field, index) {
                if (field.name.includes("accounts_and_roles_widget_role")) {
                    fieldsList.push(field);
                    field.items[optionValue] = optionValue;
                    field.render();
                }
            });

            app.alert.show('adding_option', {
                level: 'warning',
                title: 'Adding the Role Option, Please wait until the Role is added and success message is delivered.'
            });

            // Make an api call to add the option in the list 
            app.api.call('create', app.api.buildURL('DropdownListKey/add'), {
                "list_name": "contact_role_list",
                "item_key": optionValue,
                "item_value": optionValue,
                "lang": "en_us",
            }, {
                success: function (data) {
//                    self.view.refreshPage = true;
                    app.metadata.sync(function () {
                        app.alert.dismiss('adding_option');
                        app.alert.show('role_option_added', {
                            level: 'info',
                            autoClose: true,
                            messages: 'New Option (' + optionValue + ') is added to the list.',
                        });
                    });
                },
                error: function (e) {
                    throw e;
                }
            });
            // Hide the input Div
            this.$('[data-name="option-to-add-div"]').toggle();
            this.$('[data-name="option-input"]').val('');
        } else {
            app.alert.show('role_option_already_exist', {
                level: 'info',
                autoClose: true,
                messages: 'Option already exist.',
            });
        }
        evt.preventDefault();
    },

    cancelOption: function (evt) {
        // Hide the input Div
        this.$('[data-name="option-to-add-div"]').toggle();
        this.$('[data-name="option-input"]').val('');
        evt.preventDefault();
    },

    changeAddButtonToRemove: function (uid) {
        this.$('.btn[data-uid=' + uid + ']').removeClass(this.addClass);
        this.$('.btn[data-uid=' + uid + ']').addClass('removeRecord');
        this.$('.btn[data-uid=' + uid + '] > i').removeClass('fa-plus');
        this.$('.btn[data-uid=' + uid + '] > i').addClass('fa-minus');
    },
    enablePrimaryOptions: function (uid) {
        this.$('[name=' + this.name + '_primary_account__' + uid + ']').removeAttr('disabled');
        var field = this.view.getField(this.name + '_primary_account__' + uid);
        field.def.isNew = false;
        field.def.disabled = false;
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