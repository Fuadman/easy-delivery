'use strict';

angular.module('delivery')
  .service('ProductService', function ProductService(ProductCollection, ProductModel, Restangular) {
    var productService = {};

    productService.getProductList = function () {
      return Restangular.all('products').getList();
    };

    productService.getProductsByCategory = function (cid) {
      return Restangular.all('products').getList({category_id: cid});
    };

    productService.getProductsByVendor = function (bid) {
      return Restangular.all('products').getList({vid: bid});
    };

    productService.getProductsByCategoryAndVendor = function (cid, bid) {
      return Restangular.all('products').getList({category_id: cid, vid: bid});
    };

    productService.parse = function (data) {
      var productCollection = new ProductCollection();
      for (var i = 0; i < data.length; i++) {
        productCollection.addProduct(data[i]);
      }
      return productCollection;
    };

    productService.getProductById = function (pid) {
      return Restangular.one('products', pid).get();
    };

    productService.parseObject = function (model) {
      var productModel = new ProductModel();
      productModel.setProduct(model);
      return productModel;
    };

    return productService;
  });
