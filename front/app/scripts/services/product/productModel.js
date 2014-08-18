'use strict';

angular.module('delivery')
  .factory('ProductModel', function () {

    var productModel = function(){
      this.id = 0;
      this.bid = 0;
      this.name = '';
      this.year = '';
      this.description = '';
      this.picture = '';

      this.setProduct = function(object) {
        this.id = object.pid;
        this.bid = object.bid;
        this.name = object.name;
        this.year = object.year;
        this.description = object.description;
        this.picture = object.picture;
      };
    };

    return productModel;
  });