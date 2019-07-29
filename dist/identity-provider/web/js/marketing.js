MarketingExtras = (function () {

    var url = '';

    function MarketingExtras(marketingUrl)
    {
        url = marketingUrl;
        window.addEventListener("message", receiveContentMessage, false);
    }

    function receiveContentMessage(event)
    {
        if (url && url.substr(0, event.origin.length) === event.origin) {
            var data = JSON.parse(event.data);
            if (data && data.marketing_content_navigate) {
                window.open(data.marketing_content_navigate, '_blank');
            }
        }
    }
    return MarketingExtras;
}());
