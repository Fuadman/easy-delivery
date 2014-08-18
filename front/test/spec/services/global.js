'use strict';

describe('Service: global', function () {

  // load the service's module
  beforeEach(module('deliveryApp'));

  // instantiate service
  var global;
  beforeEach(inject(function (_global_) {
    global = _global_;
  }));

  it('should do something', function () {
    expect(!!global).toBe(true);
  });

});
