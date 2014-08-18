'use strict';

angular.module('delivery')
  .service('CategoryService', function CategoryService(CategoryCollection, CategoryModel, Restangular) {
    var categoryService = {};

    categoryService.getCategoryList = function () {
      return Restangular.all('categories').getList();
    };

    categoryService.parse = function (data) {
      var categoryCollection = new CategoryCollection();
      for (var i = 0; i < data.length; i++) {
        categoryCollection.addCategory(data[i]);
      }
      return categoryCollection;
    };

    return categoryService;
  });
