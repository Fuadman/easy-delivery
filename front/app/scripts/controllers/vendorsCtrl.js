'use strict';

angular.module('delivery')
  .controller('VendorsCtrl', function ($scope, $rootScope, $state, ApplicationService, APP_EVENTS, GLOBAL_STATES, LOADER_EVENTS) {
    $scope.vendors = ApplicationService.getVendors();

    $scope.loadProducts = function(id) {
      ApplicationService.loadProductsByVendor(id);
    };

    $rootScope.$on(APP_EVENTS.showProducts, function () {
      $state.transitionTo(GLOBAL_STATES.productsPage);
      $rootScope.$broadcast(LOADER_EVENTS.closeLoader);
    });
  });