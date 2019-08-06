
({
   extendsFrom: 'RecordListView',

    initialize: function(options) {
        
       this._super('initialize', [options]);

       // checking licence configuration ///////////////////////

        var url = App.api.buildURL("bc_Quote", "checkingModuleStatus", {}, {});
      
        App.api.call('GET', url, {}, {
            success: function (data) {
                if(data!='success'){
                    javascript:parent.SUGAR.App.router.navigate("no-access", {trigger: true})
                }
            },
        });

        /////////////////////////////////////////////////////////
 
    },

    _dispose: function() {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})
