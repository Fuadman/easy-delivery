'use strict';

angular.module('delivery')
  .controller('ProductsCtrl', function ($scope, $rootScope, $modal, APP_EVENTS, GLOBAL_STATES, LOADER_EVENTS, ApplicationService) {
    $scope.products = ApplicationService.getProducts();

    $scope.addProduct = function (id) {
      ApplicationService.loadProductById(id);
    };

    $rootScope.$on(APP_EVENTS.productDetails, function () {
      var modalInstance = $modal.open({
        templateUrl: 'views/dashboard/add/productDetails.html',
        controller: 'ProductModalCtrl',
        resolve: {
          product: function () {
            return ApplicationService.getSelectedProduct();
          }
        }
      });

      $rootScope.$broadcast(LOADER_EVENTS.closeLoader);

      modalInstance.result.then(function (details) {
        //TODO: add to cart
        console.log(details);
      }, function () {
        console.log('Modal dismissed at: ' + new Date());
      });
    });
  });