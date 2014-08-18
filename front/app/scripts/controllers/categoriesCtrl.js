'use strict';

angular.module('delivery')
  .controller('CategoriesCtrl', function ($scope, $rootScope, $state, ApplicationService, APP_EVENTS, GLOBAL_STATES, LOADER_EVENTS) {
    $scope.categories = ApplicationService.getCategories();

    $scope.loadVendors = function(id) {
      ApplicationService.loadVendorsByCategory(id);
    };

    $rootScope.$on(APP_EVENTS.showVendors, function () {
      $state.transitionTo(GLOBAL_STATES.vendorsPage);
      $rootScope.$broadcast(LOADER_EVENTS.closeLoader);
    });
  });