define(['vue'],function(Vue){
    'use strict'

    return function (config,element){
        return new Vue({
            el: '#' + element.id,
            data: {
                message: 'This is a test'
            }
        })
    }
    
})