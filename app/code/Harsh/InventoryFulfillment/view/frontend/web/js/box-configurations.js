define([
    'uiComponent',
    'ko',
    'Harsh_InventoryFulfillment/js/model/box-configurations',
    'Harsh_InventoryFulfillment/js/model/sku',
    'jquery',
    'mage/validation'
],function(
    Component,
    ko,
    boxConfigurationsModel,
    skuModel,
    $
){
    'use strict';

    return Component.extend({
        defaults: {
            boxConfigurationsModel: boxConfigurationsModel
        },
        initialize(){
            this._super();

            console.log('the boxConfigurations component has been loaded. ')

            skuModel.isSuccess.subscribe((value) => {
                console.log('SKU isSuccess new value', value);
            });
            skuModel.isSuccess.subscribe((value) => {
                console.log('SKU isSuccess old value', value);
            }, null, 'beforeChange');
        },
        handleAdd() {
            boxConfigurationsModel.add();
        },
        handleDelete(index) {
            boxConfigurationsModel.delete(index);
        },
        handleSubmit() {
            $('.box-configurations form input').removeAttr('aria-invalid');
            if ($('.box-configurations form').valid()) {
                boxConfigurationsModel.isSuccess(true);
            } else {
                boxConfigurationsModel.isSuccess(false);
            }
        }
    });
});