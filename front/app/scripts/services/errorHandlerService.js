'use strict';

angular.module('delivery')
  .service('ErrorHandlerService', function ErrorHandlerService($rootScope, AlertMessageService, ALERT_EVENTS) {
    var service = {};

    service.handleError = function(response) {
      switch(response.statusCode) {
        default:
          AlertMessageService.setAlertMessage('error', response.errors, true);
          $rootScope.$broadcast(ALERT_EVENTS.display);
      }
    };

    return service;
  });
