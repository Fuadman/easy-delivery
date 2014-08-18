'use strict';

angular.module('delivery')
  .controller('ProductModalCtrl', function ($scope, $modalInstance, product) {
    $scope.product = product;
    $scope.productDetails = {
      quantity: '',
      comment: ''
    };

    $scope.addToCart = function () {
      $modalInstance.close($scope.productDetails);
    };

    $scope.cancel = function () {
      $modalInstance.dismiss('cancel');
    };
  });

