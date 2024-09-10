define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (Component, customerData) {
    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();
            this.inventory_section = customerData.get('inventory_section');
        },

        submitOption: function() {

        }
    });
});
