'use strict';

angular.module('delivery')
  .service('VendorService', function VendorService(VendorCollection, VendorModel, Restangular) {
    var vendorService = {};

    vendorService.getVendorsByCategory = function (cid) {
      return Restangular.all('vendors').getList({cid: cid});
    };

    vendorService.parse = function (data) {
      var vendorCollection = new VendorCollection();
      for (var i = 0; i < data.length; i++) {
        vendorCollection.addVendor(data[i]);
      }
      return vendorCollection;
    };

    return vendorService;
  });
