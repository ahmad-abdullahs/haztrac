({
    extendsFrom: 'IntField',

    initialize: function(options) {
        this._super('initialize', [options]);
        this.type = 'int';
    },

    /**
     * @inheritdoc
     */
    unformat: function(value) {
        value = value.replace('S-','');

        var val = '';
        var leadingZero = true;
        for (var i = 0; i < value.length; i++) {
            if (value[i] != '0') {
                leadingZero = false;
            }

            if (!leadingZero) {
                val += value[i];
            }
        }

        return val;
    },

    /**
     * @inheritdoc
     */
    format: function(value) {
        value += '';
        var val = 'S-';

        for (var i = 0; i < (6-value.length); i++) {
            val += '0';
        }

        return val + value;
    },
})