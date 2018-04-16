<?php

Asset::set(__DIR__ . DS . '..' . DS . 'asset' . DS . 'js' . DS . 'view.min.js');

Hook::set('page.view', function($view, $lot = [], $that) use($url) {
    $view = preg_replace('#\d+#', '<span>$0</span>', $view);
    return '<span class="view" data-view="' . $url . '/-view/' . $that->id . '">' . $view . '</span>';
}, 1);

Route::set('-view/%s%', function($path) {
    HTTP::status(200)->type('text/plain');
    echo File::open(File::exist([
        PAGE . DS . $path . '.page',
        PAGE . DS . $path . '.archive'
    ]))->get(0, "");
    exit;
});