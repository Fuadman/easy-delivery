'use strict';

angular.module('delivery', [
  'ngCookies',
  'ngResource',
  'ngSanitize',
  'ngAnimate',
  'ui.router',
  'ui.bootstrap',
  'restangular',
  'angular-carousel'
])
  .config(function ($stateProvider, GLOBAL_STATES, RestangularProvider, $locationProvider) {
    $stateProvider
      .state(GLOBAL_STATES.app, {
        templateUrl: 'views/main.html',
        controller: 'ApplicationCtrl'
      })
      .state(GLOBAL_STATES.userGuide, {
        templateUrl: 'views/user_guide/user_guide.html',
        controller: 'UserGuideCtrl'
      })
      .state(GLOBAL_STATES.dashboardPage, {
        templateUrl: 'views/dashboard/dashboard.html'
      })
      .state(GLOBAL_STATES.categoriesPage, {
        templateUrl: 'views/dashboard/categories.html',
        controller: 'CategoriesCtrl'
      })
      .state(GLOBAL_STATES.vendorsPage, {
        templateUrl: 'views/dashboard/vendors.html',
        controller: 'VendorsCtrl'
      })
      .state(GLOBAL_STATES.productsPage, {
        templateUrl: 'views/dashboard/products.html',
        controller: 'ProductsCtrl'
      })
      .state(GLOBAL_STATES.cart, {
        templateUrl: 'views/cart/cart.html'
      });

    //RestangularProvider.setBaseUrl('http://10.100.1.110/easy-delivery-services/api/');
    RestangularProvider.setBaseUrl('http://192.168.74.1:8090/easy-delivery/api/');

    RestangularProvider.setRequestInterceptor(function(elem, operation) {
      if (operation === 'put') {
        elem._id = undefined;
        return elem;
      }
      return elem;
    });

    RestangularProvider.setResponseInterceptor(function(response, operation) {
      if (operation === 'getList') {
        var newResponse = response.results;
        return newResponse;
      }
      return response;
    });

    $locationProvider.html5Mode(true);
  })
  .run(function ($rootScope, ALERT_EVENTS, AlertMessageService) {
    $rootScope.$on('$stateChangeStart', function (event, next) {
      if(AlertMessageService.hideOnChange()) {
        $rootScope.$broadcast(ALERT_EVENTS.hide);
      }
    });
  })
  .animation('.slide', function() {
    var NgHideClassName = 'ng-hide';
    return {
      beforeAddClass: function(element, className, done) {
        if(className === NgHideClassName) {
          jQuery(element).slideUp(done);
        }
      },
      removeClass: function(element, className, done) {
        if(className === NgHideClassName) {
          jQuery(element).hide().slideDown(done);
        }
      }
    };
  });
