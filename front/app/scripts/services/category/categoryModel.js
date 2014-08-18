'use strict';

angular.module('delivery')
  .factory('CategoryModel', function () {

    var categoryModel = function(){
      this.id = 0;
      this.name = '';

      this.setCategory = function(object) {
        this.id = object.cid;
        this.name = object.name;
      };
    };

    return categoryModel;
  });