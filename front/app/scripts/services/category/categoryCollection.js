'use strict';

angular.module('delivery')
  .factory('CategoryCollection', function (CategoryModel) {

    var categoryCollection = function(){
      this.collection = [];
    };

    categoryCollection.prototype.addCategory = function(model) {
      var categoryModel = new CategoryModel();
      categoryModel.setCategory(model);
      this.collection.push(categoryModel);
    };

    return categoryCollection;
  });




