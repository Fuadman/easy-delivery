'use strict';

angular.module('delivery')
  .controller('ApplicationCtrl', function ($scope, $rootScope, $state, LocalStorageService, ApplicationService, APP_EVENTS, GLOBAL_STATES, LOADER_EVENTS) {
    $rootScope.$on(APP_EVENTS.showDashboard, function () {
      ApplicationService.loadCategories();
      $rootScope.$broadcast(LOADER_EVENTS.closeLoader);
    });

    $rootScope.$on(APP_EVENTS.showCategories, function () {
      $state.transitionTo(GLOBAL_STATES.categoriesPage);
      $rootScope.$broadcast(LOADER_EVENTS.closeLoader);
    });

    $rootScope.$on(APP_EVENTS.showUserGuide, function () {
      $state.transitionTo(GLOBAL_STATES.userGuide);
      $rootScope.$broadcast(LOADER_EVENTS.closeLoader);
    });

    if (ApplicationService.isFirstLogin()) {
      $rootScope.$broadcast(APP_EVENTS.showUserGuide);
    } else {
      $rootScope.$broadcast(APP_EVENTS.showDashboard);
    }
  });