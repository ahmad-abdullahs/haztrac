({
    extendsFrom: 'LoginView',
    events: {
        'click [name=login_button]': 'login',
        'keypress': 'handleKeypress'
    },
    initialize: function (options) {
        this._super('initialize', [options]);
        this._render();
        $(document).attr('title', 'HAZTRAC');
    },
    _render: function () {
        this._super('_render');
    },
    login: function () {
        this._super('login');
    },

    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})