var config = {
    "map" : {
        "*" : {
            "fadeInElement" : "Harsh_JsFun/js/fade-in-element",
            "Magento_Review/js/submit-review":"Harsh_JsFun/js/submit-review",
        }
    },
    "paths" : {
        "vue" : [
            "https://cdn.jsdelivr.net/npm/vue@2/dist/vue",
            "Harsh_JsFun/js/vue"
        ]
    },
    "shim": {
        "Harsh_JsFun/js/jquery-log" : ["jquery"]
    },
    "deps": ["Harsh_JsFun/js/every-page"],

    "config":{
        "mixins":{
            "Magento_Ui/js/view/messages":{
                "Harsh_JsFun/js/messages-mixin":true
            }
        }
    }
}   