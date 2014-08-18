'use strict';

angular.module('delivery')
  .controller('AlertCtrl', function ($scope, $rootScope, AlertMessageService, ALERT_EVENTS) {
    // Listen alert events
    $rootScope.$on(ALERT_EVENTS.display, function () {
      AlertMessageService.showAlertMessage();
      $rootScope.$broadcast(ALERT_EVENTS.update);
    });

    $rootScope.$on(ALERT_EVENTS.hide, function () {
      AlertMessageService.hideAlertMessage();
      $rootScope.$broadcast(ALERT_EVENTS.update);
    });

    $rootScope.$on(ALERT_EVENTS.update, function () {
      $scope.alertMessage = AlertMessageService.getAlertMessage();
    });
  });

