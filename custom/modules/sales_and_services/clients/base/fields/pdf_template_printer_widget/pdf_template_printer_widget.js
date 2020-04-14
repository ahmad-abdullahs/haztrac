({
    extendsFrom: 'BaseField',
    events: {
        'click .removeRecord:not(.disabled)': 'deleteRow',
        'click .addRecord:not(.disabled)': 'addRow',
    },
    fieldIds: [],
    modelFields: {},
    isFirst: true,
    dontShowFirstRow: true,
    enablePlusButton: false,
    addClass: 'addRecord',
    initialize: function (options) {
        this._super('initialize', [options]);
        // This event is fired from the custom/modules/sales_and_services/clients/base/fields/templatepdfs-panel/templatepdfs-panel.js file
        // When user checked or unchecked the Pdf Template, it listens the event and re-render the whole field
        // So, in short the params/data received by this listner is rendered.
        app.events.on('pdf_template_printer_widget:re-render', this.reRenderField, this);
    },

    reRenderField: function (param) {
        this.model.set(this.name, param);
        this.render();
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

    },
    _onDragStart: function (evt, ui) {
        // console.log('_onDragStart : ', this, evt, ui);
    },
    _onDragStop: function (evt, ui) {
        // console.log('_onDragStop : ', this, evt, ui);
        var line_number = 1;
        _.each(this.$('tbody > tr.ui-sortable-handle').find('input[name*=pdf_template_printer_widget_name__]'), function (ele) {
            if ($(ele).val() && $(ele).attr('name').split('__')[1]) {
                this.model.set('pdf_template_printer_widget_line_number__' + $(ele).attr('name').split('__')[1], line_number, {
                    silent: true
                });
                line_number++;
            }
        }, this);
        this.updateJSON();
    },
    _onGroupDragTriggerOver: function (evt, ui) {
        // console.log('_onGroupDragTriggerOver : ', this, evt, ui);
    },
    _onGroupDragTriggerOut: function (evt, ui) {
        // console.log('_onGroupDragTriggerOut : ', this, evt, ui);
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

        if (!rowExist) {
            this.model.set(this.name, '[]', {silent: true});
        }

        if ((this.action === 'edit' || -1 !== _.indexOf(['edit', 'list-edit'], this.tplName))) {
            // Don't show the first empty row unless added.
            if (this.dontShowFirstRow) {
            } else {
                this.dontShowFirstRow = false;
                this.insertRow(newRowObj, true);
            }
        }

        this.renderInnerFields();
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

            if (fieldDef.default != false) {
                modelFields.push(_.extend({}, fieldDef, extendedObj));
            }
        }, this);

        var fieldAction = (this.action === 'edit' || -1 !== _.indexOf(['edit', 'list-edit'], this.tplName)) ? "edit" : "detail";

        var modelRowTemplate = app.template.getField(this.type, template, this.module);
        var fieldTemplate = modelRowTemplate({
            view: this.view,
            model: this.model,
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
                var fieldsToCheck = ['_role__'];
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
        this.view.layout.jsonFieldStructure = {};
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
            }, this);
            if (uid != nruid || this.enablePlusButton) {
                jsonField.push(obj);
                this.view.layout.jsonFieldStructure[obj['pdf_template_printer_widget_name_id']] = obj;
            }
        }, this);

        jsonField = _.sortBy(jsonField, 'pdf_template_printer_widget_line_number');
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