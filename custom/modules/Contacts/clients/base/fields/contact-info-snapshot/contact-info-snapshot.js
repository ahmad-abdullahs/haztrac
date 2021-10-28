({
    extendsFrom: 'RowactionField',

    /**
     * @inheritdoc
     */
    rowActionSelect: function (evt) {
        var self = this;
        var messageInformation = "<h4>System is taking snapshot of below mentioned fields.</h4>\n\
<ul>\n\
<li>Title</li>\n\
<li>Department</li>\n\
<li>Mobile</li>\n\
<li>Office Phone</li>\n\
<li>Fax</li>\n\
<li>Email Address</li>\n\
<li>Primary Address</li>\n\
<li>Alternate Address</li>\n\
</ul>";
        app.alert.show('taking_snapshot_info', {
            level: 'info',
            title: messageInformation,
        });
        app.alert.show('taking_process', {
            level: 'process',
            title: "Archiving the details.",
        });

        // Make an API call for archiving
        app.api.call('create', app.api.buildURL('TakeSnapShot/add'), {
            "id": self.model.get('id'),
        }, {
            success: function (data) {
                console.log("DATA : ", data);
                app.alert.dismiss('taking_process');
                app.alert.dismiss('taking_snapshot_info');
                app.alert.show('snapshot_success', {
                    level: 'success',
                    autoClose: true,
                    messages: data,
                });
                self.model.fetch();
            },
            error: function (e) {
                throw e;
            }
        });
    }
})