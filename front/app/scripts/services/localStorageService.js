'use strict';

angular.module('delivery')
  .service('LocalStorageService', function LocalStorageService($cookieStore) {
    var service = {};

    service.add = function(key, value) {
      $cookieStore.put(key, value);
    };

    service.get = function(key) {
      return $cookieStore.get(key);
    };

    service.exist = function(key) {
      var value = $cookieStore.get(key);
      return(value !== undefined && value);
    };

    service.delete = function(key) {
      $cookieStore.remove(key);
    };

    return service;
  });
