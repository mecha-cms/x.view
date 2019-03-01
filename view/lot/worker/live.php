<?php namespace fn\page;

\Asset::set(__DIR__ . DS . '..' . DS . 'asset' . DS . 'js' . DS . 'view.min.js', null, [
    'data-view' => $language->page_view
]);

function view($view, array $lot = []) {
    return '<span class="view" data-path="' . \Path::R(\Path::F($this->path . ""), PAGE, '/') . '">' . $view . '</span>';
}

\Hook::set('page.view', __NAMESPACE__ . "\\view", 1);

\Route::set('.view/%*%', function($path) {
    \HTTP::status(200)->type('text/plain');
    echo \File::open(PAGE . DS . $path . DS . 'view.data')->get(0, "");
    return;
});