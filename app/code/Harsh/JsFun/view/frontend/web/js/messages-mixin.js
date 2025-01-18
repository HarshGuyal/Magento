define([],function(){
    'use strict'

    return function(originalMessages){
        return originalMessages.extend({
            defaults : {
                hideTimeout: 3000,
                hideSpeed: 100
            }
        })
    }
})