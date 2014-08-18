'use strict';

angular.module('delivery')
  .factory('ProductCollection', function (ProductModel) {

    var productCollection = function(){
      this.collection = [];
    };

    productCollection.prototype.addProduct = function(model) {
      var productModel = new ProductModel();
      productModel.setProduct(model);
      this.collection.push(productModel);
    };

    return productCollection;
  });




