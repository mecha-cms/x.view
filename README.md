Page View Extension for Mecha
=============================

Release Notes
-------------

### 2.4.1

 - Added more secure write condition. Trying to cancel the stats update when something have gone wrong such as dropped internet connection or file writing error caused by memory usage limit.

### 2.4.0

 - Ignore page views counter on certain cases, such as when the page is visited via JavaScript AJAX or via HTML5 prefetch elements.

### 2.3.1

 - Stop interval when JavaScript DOM is removed by another extension. For example, if it was removed by [F3H](https://github.com/taufik-nurrohman/f3h) events.
 - Assume translation text without number as 0 views. For example, when translating `0 Views` into `No views yet.`.

### 2.3.0

 - Added live counter feature.
