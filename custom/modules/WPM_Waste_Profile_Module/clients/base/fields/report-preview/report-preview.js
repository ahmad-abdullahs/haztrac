({
    extendsFrom: 'RowactionField',

    /**
     * @inheritdoc
     */
    rowActionSelect: function (evt) {
        var urlParams = $.param({
            'entryPoint': 'WPM_Waste_Profile_Preview',
            'report_id': this.model.id
        });

        var url = window.location.href;
        url = url.split('#');
        window.open('https://docs.google.com/viewer?url=' + encodeURIComponent(url[0] + '?' + urlParams) + '&embedded=true&chrome=false&dov=1');
    }
})