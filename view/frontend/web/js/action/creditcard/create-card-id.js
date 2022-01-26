define([
    'jquery',
    'mage/storage',
    'Magento_Checkout/js/model/url-builder',
    'mage/url'
], function ($, storage, urlBuilder, mageUrl) {
    return function (data, customer_id) {
        var serviceUrl = 'https://api.plug.com/core/v1/customers/' + customer_id + '/cards';

        return $.ajax({
            method: "POST",
            beforeSend: function(request) {
                request.setRequestHeader("Content-type", 'application/json');
                request.setRequestHeader("Accept", 'application/json');
                request.setRequestHeader("Authorization", 'Basic c2tfdGVzdF83WjRrYWtkUGhtc1FyQUdtOg==');
                request.setRequestHeader("Access-Control-Allow-Origin", '*');
                // request.setRequestHeader("Access-Control-Request-Headers", 'Content-Type, Authorization');
                // Access-Control-Request-Headers: Content-Type, Authorization'
            },
            url: serviceUrl,
            cache: false,
            crossDomain: true,
            data: data
        });
    };
});
