'use strict';

angular.module('delivery')
  .factory('VendorCollection', function (VendorModel) {

    var vendorCollection = function(){
      this.collection = [];
    };

    vendorCollection.prototype.addVendor = function(model) {
      var vendorModel = new VendorModel();
      vendorModel.setVendor(model);
      this.collection.push(vendorModel);
    };

    return vendorCollection;
  });




