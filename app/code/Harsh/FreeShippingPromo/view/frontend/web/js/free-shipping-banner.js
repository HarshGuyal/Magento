define(['uiComponent',
        'Magento_Customer/js/customer-data',
        'underscore',
        'knockout'

],function(
    Component,
    customerData,
    _,
    ko
){
    'use strict';

    return Component.extend({
        defaults : {
            freeShippingThreshold : 100,
            subtotal : 0.00,
            template : 'Harsh_FreeShippingPromo/free-shipping-banner',
            tracks : {
                subtotal: true
            }
        },
        initialize: function(){
            this._super();

            var self = this;
            var cart = customerData.get('cart');

            console.log(self.freeShippingThreshold);
            

            customerData.getInitCustomerData().done(function(){
                if(!_.isEmpty(cart()) && !_.isUndefined(cart().subtotalAmount)){
                    self.subtotal = parseFloat(cart().subtotalAmount);
                }
            });
            
            cart.subscribe(function(cart){
                if(!_.isEmpty(cart) && !_.isUndefined(cart.subtotalAmount)){
                    self.subtotal = parseFloat(cart.subtotalAmount);
                }
            })

            self.message = ko.computed(function(){
                //subtotal = 0, return messageDefault
                if(_.isUndefined(self.subtotal) || self.subtotal === 0){
                    return self.messageDefault.replace('{{freeShippingThreshold}}',self.freeShippingThreshold);
                }

                //subtotal > 0 or < 100, return messageItemsInCart
                if(self.subtotal > 0 && self.subtotal < self.freeShippingThreshold){
                    var subtotalRemaining = self.freeShippingThreshold - self.subtotal;
                    var FormattedSubtotalRemaining = self.formatCurrency(subtotalRemaining);
                    return self.messageItemsInCart.replace('$XX.XX' ,FormattedSubtotalRemaining);
                }

                //subtotal > 100, return messageFreeShipping
                if(self.subtotal >= self.freeShippingThreshold){
                    return self.messageFreeShipping;
                }
            })
            // window.setTimeout(function(){
            // },2000);
            
        },
        formatCurrency: function(value){
            return '$'+ value.toFixed(2);
        }
    })
})