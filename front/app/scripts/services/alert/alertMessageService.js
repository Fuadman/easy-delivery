'use strict';

angular.module('delivery')
  .service('AlertMessageService', function AlertMessageService(AlertMessageModel, $rootScope) {

    var alertMessageService = {};

    alertMessageService.getAlertMessage = function() {
      if($rootScope.alertMessage === undefined) {
        $rootScope.alertMessage = new AlertMessageModel();
      }
      return $rootScope.alertMessage;
    };

    alertMessageService.hideOnChange = function () {
      return $rootScope.alertMessage.hideOnChange;
    };

    alertMessageService.setAlertMessage = function (type, message, hideOnChange) {
      $rootScope.alertMessage.setMessage(type, message, hideOnChange);
    };

    alertMessageService.hideAlertMessage = function () {
      $rootScope.alertMessage.display = false;
    };

    alertMessageService.showAlertMessage = function () {
      $rootScope.alertMessage.display = true;
    };

    return alertMessageService;
  });