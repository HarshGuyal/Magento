define([
    'ko',
    'Harsh_InventoryFulfillment/js/ko/extenders/numeric'
], function(
    ko
) {
    const boxConfiguration = () => {
        const divisor = 139;
        const data = {
            length: ko.observable().extend({numeric: true}),
            width: ko.observable().extend({numeric: true}),
            height: ko.observable().extend({numeric: true}),
            weight: ko.observable().extend({numeric: true}),
            unitsPerBox: ko.observable().extend({numeric: true}),
            numberOfBoxes: ko.observable().extend({numeric: true}),
        }; 

        data.dimensionalWeight = ko.computed(()=>{
            const result = data.length() * data.width() * data.height() / divisor;
            return Math.round(result * data.numberOfBoxes());
        })
        data.totalWeight = ko.computed(()=>{
            const result = data.numberOfBoxes() * data.weight();
            return Math.round(result);
        })

        data.billableWeight = ko.computed(()=>{
            const result = data.totalWeight() > data.dimensionalWeight() ? data.totalWeight() : data.dimensionalWeight();
            return Math.round(result);
        })
        return data;
    };
    return {
        boxConfigurations: ko.observableArray([boxConfiguration()]),
        isSuccess: ko.observable(false),
        add: function() {
            this.boxConfigurations.push(boxConfiguration());
        },
        delete: function(index) {
            this.boxConfigurations.splice(index, 1);
        },
        numberOfBoxes: function(){
            return ko.computed(() => {
                return this.boxConfigurations().reduce(function(runningTotal,boxConfiguration){
                    return runningTotal + (boxConfiguration.numberOfBoxes() || 0);
                },0);
            });
        },
        totalWeight: function(){
            return ko.computed(() =>{
                return this.boxConfigurations().reduce(function(runningTotal,boxConfiguration){
                    return runningTotal + (boxConfiguration.totalWeight() || 0);
                },0);
            })
        },
        billableWeight: function(){
            return ko.computed(() =>{
                return this.boxConfigurations().reduce(function(runningTotal,boxConfiguration){
                    return runningTotal + (boxConfiguration.billableWeight() || 0);
                },0);
            })
        }
    };
});