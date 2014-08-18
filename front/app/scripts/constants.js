'use strict';

angular.module('delivery')
  .constant('GLOBAL_STATES', {
    app: 'app',
    dashboardPage: 'app.dashboard',
    categoriesPage: 'app.categories',
    vendorsPage: 'app.vendors',
    productsPage: 'app.products',
    userGuide: 'app.user_guide',
    cart: 'app.cart'
  })
  .constant('LOADER_EVENTS', {
    openLoader: 'open-loader',
    closeLoader: 'close-loader'
  })
  .constant('APP_EVENTS', {
    showDashboard: 'show-dashboard',
    showUserGuide: 'show-user-guide',
    showCategories: 'show-categories',
    showVendors: 'show-vendors',
    showProducts: 'show-products',
    productDetails: 'product-details'
  })
  .constant('ALERT_EVENTS', {
    display: 'display-alert-message',
    hide: 'hide-alert-message',
    update: 'update-alert-message'
  })
  .constant('API_PATH', {
    auth: 'user/login/'
  });
