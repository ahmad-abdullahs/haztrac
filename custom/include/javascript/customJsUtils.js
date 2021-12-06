
(function (app) {
    app.events.on('app:init', function () {
        app.utils = _.extend(app.utils, {
            /**
             * Check if the value is empty or not
             * This function is added for the purpose of checking the number too
             * _.isEmpty return true if we check _.isEmpty(20)
             * So to avoid the confusion always check empty with custom util function
             */
            isEmpty: function (value) {
                if (value == '' || _.isNull(value) || _.isUndefined(value)) {
                    return true;
                }
                return false;
            },
        });
    });
})(SUGAR.App);