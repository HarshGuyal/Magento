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
                data: null,
                numberOfBoxes: boxConfigurationsModel.numberOfBoxes(),
                totalWeight : boxConfigurationsModel.totalWeight(),
                billableWeight : boxConfigurationsModel.billableWeight(),
                checkBox : ko.observable(false),
                buttonUpdate : ko.observable(false),
                boxConfigUpdate : ko.observable(false),
                skuUpdate : ko.observable(false),
                boxConfigurationsIsSuccess: boxConfigurationsModel.isSuccess
            },
            initialize() {
                this._super();
                this.data = boxConfigurationsModel.boxConfigurations()[0];

                // this.data.numberOfBoxes.subscribe((newValue) => {
                //     console.log('Updated numberOfBoxes:', newValue);
                //     this.numberOfBoxes(newValue);
                // });

                // this.data.totalWeight.subscribe((newValue) => {
                //     console.log('Updated totalWeight:', newValue);
                //     this.totalWeight(newValue);
                // });
                // this.data.billableWeight.subscribe((newValue) => {
                //     console.log('Updated billableWeight:', newValue);
                //     this.billableWeight(newValue);
                // });
                this.checkBox.subscribe((newValue) => {
                    console.log('updated checkBox:', newValue);
                    this.isAcceptButtonEnabled();
                });
                boxConfigurationsModel.isSuccess.subscribe((newValue) => {
                    this.boxConfigUpdate(newValue);
                    this.isAcceptButtonEnabled()
                });
                skuModel.isSuccess.subscribe((newValue) =>{
                    this.skuUpdate(newValue);
                    this.isAcceptButtonEnabled()
                });

                console.log('Review Submit is loaded');
            },
            
            isAcceptButtonEnabled() {
                if(this.checkBox() && this.boxConfigUpdate() && this.skuUpdate()){
                    this.buttonUpdate(true);
                }else{
                    this.buttonUpdate(false);
                }
            },
            getUpdatedNumberOfBoxes() {
                return this.numberOfBoxes();
            },
            getTotalWeight(){
                return this.totalWeight();
            },
            getBillableWeight(){
                return this.billableWeight();
            },
            getButtonUpdate(){
                return this.buttonUpdate();
            }
        })
    }
)