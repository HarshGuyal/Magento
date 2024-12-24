define(['uiComponent',
    'ko',
    'Harsh_InventoryFulfillment/js/model/box-configurations',
    'Harsh_InventoryFulfillment/js/model/sku'],
    function (
        Component,
        ko,
        boxConfigurationsModel,
        skuModel) {
        'use strict'

        return Component.extend({
            defaults: {
                sku: skuModel.sku(),
                data: null,
                numberOfBoxes: ko.observable(0),
                totalWeight : ko.observable(0),
                billableWeight : ko.observable(0)
            },
            initialize() {
                this._super();
                this.data = boxConfigurationsModel.boxConfigurations()[0];
                this.data.numberOfBoxes.subscribe((newValue) => {
                    console.log('Updated numberOfBoxes:', newValue);
                    this.numberOfBoxes(newValue);
                });
                this.data.totalWeight.subscribe((newValue) => {
                    console.log('Updated numberOfBoxes:', newValue);
                    this.totalWeight(newValue);
                });
                this.data.billableWeight.subscribe((newValue) => {
                    console.log('Updated numberOfBoxes:', newValue);
                    this.billableWeight(newValue);
                });
                console.log('Review Submit is loaded');
            },
            getUpdatedNumberOfBoxes() {
                return this.numberOfBoxes();
            },
            getTotalWeight(){
                return this.totalWeight();
            },
            getBillableWeight(){
                return this.billableWeight();
            }
        })
    })