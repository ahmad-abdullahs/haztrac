({
    extendsFrom: 'RelateField',

    events: {
        'click .btn[name=add]': 'addItem',
        'click .btn[name=remove]': 'removeItem'
    },

    isEmpty: false,

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
    },

    /**
     * Called to update value when a selection is made from options view dialog
     * @param model New value for teamset
     */
    setValue: function (model) {
        if (!model) {
            return;
        }

        var index = this._currentIndex,
                record = this.value;
        record[index || 0].id = model.id;
        record[index || 0].name = model.value;

        this._updateAndTriggerChange(record);
    },

    /**
     * Forcing change event on value update since backbone isn't picking up on changes within an object within the array.
     * @param value New value for teamset field
     * @private
     */
    _updateAndTriggerChange: function (value) {
        this.model.unset(this.name, {silent: true}).set(this.name, value);
        this.render();
    },

    /**
     * @inheritdoc
     */
    format: function (value) {
        if (_.isEmpty(value)) {
            value = [{}];
            this.isEmpty = true;
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
    getSearchModule: function () {
        return 'HT_Manifest';
    },

    /**
     * Adds a manifest to the list
     */
    addItem: _.debounce(function (evt) {
        var index = $(evt.currentTarget).data('index');
        //Only allow adding a Team when ones been selected (SP-534)
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
    }, 0)
})