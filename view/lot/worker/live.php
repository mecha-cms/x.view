<?php namespace fn\page;

\Asset::set(__DIR__ . DS . '..' . DS . 'asset' . DS . 'js' . DS . 'view.min.js', 10, [
    'data-view' => $language->page_view
]);

function view($view, array $lot = []) {
    return '<span class="view" data-path="' . \Path::R(\Path::F($this->path . ""), PAGE, '/') . '">' . $view . '</span>';
}

\Hook::set('page.view', __NAMESPACE__ . "\\view", 1);

\Route::set('\.view/(.+)', function($path) {
    \HTTP::status(200);
    \HTTP::type('text/plain');
    return \content(PAGE . DS . $path . DS . 'view.data') ?? "";
});