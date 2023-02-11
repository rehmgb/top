'use strict';

/* Filters */

angular.module('rating.filters', [])
  .filter('interpolate', ['version', function(version) {
    return function(text) {
      return String(text).replace(/\%VERSION\%/mg, version);
    };
  }])
  .filter('msToTime', function() {
    function padTime(t) {
      return t < 10 ? '0' + t : t;
    }
    return function(_seconds) {
      _seconds = Math.floor(_seconds / 1000);
      if (typeof _seconds !== "number" || _seconds < 0)
        return '00:00';

      var minutes = Math.floor(_seconds / 60),
        seconds = Math.floor(_seconds % 60);

      return padTime(minutes) + ':' + padTime(seconds);
    };
  });
