'use strict';

angular.module('delivery')
  .factory('AlertMessageModel', function () {

    var alertMessageModel = function(){
      this.type = '';
      this.message = '';
      this.display = false;
      this.hideOnChange = false;

      this.setMessage = function(type, message, hideOnChange) {
        this.type = type;
        this.message = message;
        this.hideOnChange = hideOnChange;
      };

      this.display = function(display) {
        this.display = display;
      };
    };

    return alertMessageModel;
  });