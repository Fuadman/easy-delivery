'use strict';

angular.module('delivery')
  .controller('UserGuideCtrl', function ($scope, $rootScope, LocalStorageService, APP_EVENTS) {
    $scope.skipUserGuide = function() {
      LocalStorageService.add('user_guide', true);
      $rootScope.$broadcast(APP_EVENTS.showDashboard);
    };
  });