'use strict';

angular.module('delivery')
  .controller('MainCtrl', function ($scope, $rootScope, $state, ApplicationService, AlertMessageService, LOADER_EVENTS, APP_EVENTS, GLOBAL_STATES) {
    $scope.alertMessage = AlertMessageService.getAlertMessage();

    $state.transitionTo(GLOBAL_STATES.app);
  });