'use strict';

angular.module('delivery')
  .factory('VendorModel', function () {

    var vendorModel = function(){
      this.id = 0;
      this.name = '';
      this.description = '';
      this.address = '';
      this.category = '';

      this.setVendor = function(object) {
        this.id = object.vid;
        this.name = object.name;
        this.description = object.description;
        this.address = object.address;
        this.category = object.category;
      };
    };

    return vendorModel;
  });