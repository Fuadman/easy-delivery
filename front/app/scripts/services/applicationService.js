'use strict';

angular.module('delivery')
  .service('ApplicationService', function ApplicationService($rootScope, LocalStorageService, CategoryService, VendorService, ProductService, APP_EVENTS, LOADER_EVENTS) {
    var appService = {};

    appService.isFirstLogin = function() {
      var userGuide = LocalStorageService.get('user_guide');
      return (userGuide === undefined || !userGuide);
    };






    appService.loadCategories = function() {
      $rootScope.$broadcast(LOADER_EVENTS.openLoader);
      CategoryService.getCategoryList()
        .then(function(res) {
          $rootScope.categories = CategoryService.parse(res);
          $rootScope.$broadcast(APP_EVENTS.showCategories);
        }, function(res) {
          console.log(res);
          //$rootScope.user = UserService.getNewUser();
          //$rootScope.$broadcast(APP_EVENTS.render_page);
        });
    };

    appService.getCategories = function() {
      return $rootScope.categories;
    };








    appService.loadVendorsByCategory = function(bid) {
      $rootScope.$broadcast(LOADER_EVENTS.openLoader);
      VendorService.getVendorsByCategory(bid)
        .then(function(res) {
          $rootScope.vendors = VendorService.parse(res);
          $rootScope.$broadcast(APP_EVENTS.showVendors);
        }, function(res) {
          console.log(res);
          //$rootScope.user = UserService.getNewUser();
          //$rootScope.$broadcast(APP_EVENTS.render_page);
        });
    };

    appService.getVendors = function() {
      return $rootScope.vendors;
    };





    appService.loadProductById = function(pid) {
      $rootScope.$broadcast(LOADER_EVENTS.openLoader);
      ProductService.getProductById(pid)
        .then(function(res) {
          $rootScope.selectedProduct = ProductService.parseObject(res.results[0]);
          $rootScope.$broadcast(APP_EVENTS.productDetails);
        }, function(res) {
          console.log(res);
          //$rootScope.user = UserService.getNewUser();
          //$rootScope.$broadcast(APP_EVENTS.render_page);
        });
    };

    appService.getSelectedProduct = function() {
      return $rootScope.selectedProduct;
    };


    appService.loadProductsByCategory = function(cid) {
      $rootScope.$broadcast(LOADER_EVENTS.openLoader);
      ProductService.getProductsByCategory(cid)
        .then(function(res) {
          $rootScope.products = ProductService.parse(res);
          $rootScope.$broadcast(APP_EVENTS.showProducts);
        }, function(res) {
          console.log(res);
          //$rootScope.user = UserService.getNewUser();
          //$rootScope.$broadcast(APP_EVENTS.render_page);
        });
    };

    appService.loadProductsByVendor = function(bid) {
      $rootScope.$broadcast(LOADER_EVENTS.openLoader);
      ProductService.getProductsByVendor(bid)
        .then(function(res) {
          $rootScope.products = ProductService.parse(res);
          $rootScope.$broadcast(APP_EVENTS.showProducts);
        }, function(res) {
          console.log(res);
          //$rootScope.user = UserService.getNewUser();
          //$rootScope.$broadcast(APP_EVENTS.render_page);
        });
    };

    appService.loadProductsByCategoryAndVendor = function(cid, bid) {
      $rootScope.$broadcast(LOADER_EVENTS.openLoader);
      ProductService.getProductsByCategoryAndVendor(cid, bid)
        .then(function(res) {
          $rootScope.products = ProductService.parse(res);
          $rootScope.$broadcast(APP_EVENTS.showProducts);
        }, function(res) {
          console.log(res);
          //$rootScope.user = UserService.getNewUser();
          //$rootScope.$broadcast(APP_EVENTS.render_page);
        });
    };

    appService.getProducts = function() {
      return $rootScope.products;
    };


    return appService;
  });
