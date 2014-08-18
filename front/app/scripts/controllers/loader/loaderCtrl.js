'use strict';

angular.module('delivery')
  .controller('LoaderCtrl', function ($scope, $rootScope, LOADER_EVENTS) {

    $scope.loading = true;

    // Listen loader events
    $rootScope.$on(LOADER_EVENTS.openLoader, function () {
      $scope.loading = true;
    });

    $rootScope.$on(LOADER_EVENTS.closeLoader, function () {
      $scope.loading = false;
    });
  });

