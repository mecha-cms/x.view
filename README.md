Page View Plugin for Mecha
==========================

This plugin adds a `view` property to the current page once visited by your readers with dynamic value. Each page visit will increment the `view` value by one.

### Usage

To show the current page views, add this to the `page.php` file in your active shield:

~~~ .php
<?php echo $page->view(0); ?>
~~~