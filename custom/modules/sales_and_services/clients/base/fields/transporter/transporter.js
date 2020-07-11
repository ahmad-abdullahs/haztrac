({
    extendsFrom: 'RelateField',

    events: {
        'click .btn[name=add]': 'addItem',
        'click .btn[name=remove]': 'removeItem'
    },

    isEmpty: false,

    initialize: function (options) {
        this._super('initialize', [options]);
        // Listen to the save event and unformat the data.
        this.context.on('unformat:transporter:carrier', this.customUnformat, this);
    },

    render: function () {
        this._super('render');

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
//        console.log('_onDragStart : ', this, evt, ui);
    },

    _onDragStop: function (evt, ui) {
//        console.log('_onDragStop : ', this, evt, ui);

        // This function will go over each row one by one, get the line_number value (This line_number value is the index
        // of that data object in this.value array), extract that object from the index and push it to the new array for
        // re-ordering the rows. 
        // Finally set the value and render the field.
        var newValue = [];
        _.each(this.$('tbody > tr.ui-sortable-handle'), function (ele) {
            var obj = this.value[$(ele).attr('line_number')];
            newValue.push(obj);
        }, this);

        newValue = JSON.stringify(newValue);
        this.model.set(this.name, newValue);
        this.render();
    },

    _onGroupDragTriggerOver: function (evt, ui) {
//        console.log('_onGroupDragTriggerOver : ', this, evt, ui);
    },

    _onGroupDragTriggerOut: function (evt, ui) {
//        console.log('_onGroupDragTriggerOut : ', this, evt, ui);
    },

    /**
     * @inheritdoc
     */
    _render: function () {
        this._super('_render');

        var self = this;
        this.$(this.fieldTag).each(function (index, el) {
            var plugin = $(el).data("select2");
            // If there is a plugin but no record index, set it
            if (!_.isUndefined(plugin) && _.isUndefined(plugin.setTransIndex)) {
                plugin.setTransIndex = function () {
                    self._currentIndex = $(this).data("index");
                };
                plugin.opts.element.on("select2-open", plugin.setTransIndex);
            }
        });

        // Add the rounded style to div around the Transporter / Carrier and Ship To / TSDF fields
        if (this.view.name != 'preview') {
            this.addStyleArroundDiv();
        }
    },

    addStyleArroundDiv: function () {
        // parent('div.row-fluid') added to avoid the preview div been selected
        var parentDiv = this.$el.parents().find('div[data-type="transporter"]').parent('div.row-fluid');
        parentDiv.attr('style', 'border: groove;border-color: lightgray;-webkit-border-radius: 10px;margin-bottom: 10px;margin-left: 1px;margin-right: 1px;');

        var transporter = this.$el.parents().find('div.record-cell[data-type="transporter"]');
        transporter.attr('style', 'margin-top: 6px;margin-bottom: -10px;');

        var shipToTSDF = transporter.siblings('div');
        shipToTSDF.attr('style', 'margin-top: 6px;margin-bottom: -10px;');
    },

    /**
     * Called to update value when a selection is made from options view dialog
     * @param model New value for teamset
     */
    setValue: function (model, $el) {
        if (!model) {
            return;
        }

        // This primaryIndex is the true index of the row in the field widget,
        // while _currentIndex is the last row number in the field widget.
        var primaryIndex;
        if ($el) {
            primaryIndex = $el.data('index');
        }
        var index = primaryIndex || this._currentIndex,
                record = this.value;
        record[index || 0].id = model.id;
        record[index || 0].name = model.value;

        var flag = true;
        // Check added to avoid the row addition when some field is set to empty.
        if (model.id) {
            // Add new row when the vale is set to last row
            var obj = record[record.length - 1];
            if (_.has(obj, "id")) {
                _.each(record, function (row, index) {
                    record[index]['add_button'] = false;
                    record[index]['remove_button'] = true;
                }, this);

                this.addItem(this.$el.find('[name=add]'));
                flag = false;
            }
        }

        // This is restricted not to overburden the processing, since _updateAndTriggerChange function 
        // is already called in the addItem function.
        if (flag) {
            this._updateAndTriggerChange(record);
        }
    },

    /**
     * Forcing change event on value update since backbone isn't picking up on changes within an object within the array.
     * @param value New value for teamset field
     * @private
     */
    _updateAndTriggerChange: function (value) {
        this.model.unset(this.name, {silent: true}).set(this.name, JSON.stringify(value));
        this.render();
    },

    /**
     * @inheritdoc
     */
    format: function (value) {
        value = JSON.parse(value || '[]');
        if (_.isEmpty(value)) {
            value = [{}];
            this.isEmpty = true;
        } else {
            this.isEmpty = false;
        }

        if (_.isArray(value) && !_.isEmpty(value)) {
            _.each(value, function (record, index, list) {
                delete record.remove_button;
                delete record.add_button;

                if (index === list.length - 1) {
                    record.add_button = true;
                }

                if (list.length !== 1) {
                    record.remove_button = true;
                }
            });
        }

        return value;
    },

    /**
     * @inheritdoc
     */
    customUnformat: function () {
        // Remove the empty rows on save.
        var value = this.model.get(this.name);
        value = JSON.parse(value || '[]');
        var trimmedValue = [];
        if (!_.isEmpty(value)) {
            _.each(value, function (row) {
                if (_.has(row, "id") && !_.isEmpty(row.id)) {
                    trimmedValue.push(row);
                }
            });
            value = JSON.stringify(trimmedValue);
        } else {
            value = '[]';
        }

        this.model.set(this.name, value);
    },

    /**
     * @inheritdoc
     */
    getSearchModule: function () {
        return 'Accounts';
    },

    /**
     * Adds a manifest to the list
     */
    addItem: _.debounce(function (evt) {
        var index = $(evt.currentTarget).data('index');
        // Only allow adding a Team when ones been selected (SP-534)
        if (!index || this.value[index].id) {
            this.value.push({});
            this._currentIndex++;
            this._updateAndTriggerChange(this.value);
        }
    }, 0),

    /**
     * Removes a manifest to the list
     */
    removeItem: _.debounce(function (evt) {
        var index = $(evt.currentTarget).data('index');
        if (_.isNumber(index)) {
            // Do not remove last team.
            if (index === 0 && this.value.length === 1) {
                return;
            }

            if (this._currentIndex === this.value.length - 1) {
                this._currentIndex--;
            }

            this.value.splice(index, 1);
            this._updateAndTriggerChange(this.value);
        }
    }, 0),

    _onSelect2Change: function (e) {
        var $el = $(e.target);
        var plugin = $el.data('select2');
        var id = e.val;

        if (_.isUndefined(id)) {
            return;
        }

        // For multiselect fields, we update the data-rname attributes
        // so it stays in sync with the id list, and allows us to use
        // 'setValue' method. The use of 'setValue' method is required
        // to re-render the field.
        if (this.def.isMultiSelect) {
            var dataRname = plugin.opts.element.data('rname');
            dataRname = dataRname ? dataRname.split(this._separator) : [];
            var ids = $el.select2('val');

            if (e.added) {
                dataRname.push(e.added.text);
            } else if (e.removed) {
                dataRname = _.without(dataRname, e.removed.text);
            } else {
                return;
            }
            var models = _.map(ids, function (id, index) {
                return {id: id, value: dataRname[index]};
            });

            this.setValue(models);
            return;
        }

        var value = (id) ? plugin.selection.find('span').text() : $el.data('rname');
        var collection = plugin.context;
        var attributes = {};
        if (collection && !_.isEmpty(id)) {
            // if we have search results use that to set new values
            var model = collection.get(id);
            attributes.id = model.id;
            attributes.value = model.get(this.getRelatedModuleField());
            _.each(model.attributes, function (value, field) {
                if (app.acl.hasAccessToModel('view', model, field)) {
                    attributes[field] = attributes[field] || model.get(field);
                }
            });
        } else if (e.currentTarget.value && value) {
            // if we have previous values keep them
            attributes.id = value;
            attributes.value = e.currentTarget.value;
        } else {
            // default to empty
            attributes.id = '';
            attributes.value = '';
        }

        // This $el is passed in the function to get the right index of row in the field widget.
        this.setValue(attributes, $el);
    },
})