<?php

Asset::set(__DIR__ . DS . '..' . DS . 'asset' . DS . 'js' . DS . 'view.min.js', null, [
    'data[]' => [
        'view' => $language->page_view
    ]
]);

function fn_view_get_($view, $lot = [], $that) {
    return '<span class="view" data-path="' . Path::F($that->path, PAGE, '/') . '">' . $view . '</span>';
}

Hook::set('page.view', 'fn_view_get_', 1);

Route::set('-view/%*%', function($path) {
    HTTP::status(200)->type('text/plain');
    echo File::open(PAGE . DS . $path . DS . 'view.data')->get(0, "");
    exit;
});