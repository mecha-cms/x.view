<?php namespace _\page;

\Asset::set(__DIR__ . DS . '..' . DS . '..' . DS . 'lot' . DS . 'asset' . DS . 'js' . DS . 'view.min.js', 10, [
    'data-t' => \Language::get('page-view-count')
]);

function view($view, array $lot = []) {
    return '<output class="view" for="' . \Path::R(\Path::F((string) $this->path), PAGE, '/') . '">' . $view . '</output>';
}

\Hook::set('page.view', __NAMESPACE__ . "\\view", 1);

\Route::set('.view/<>', 200, function() {
    $this->type('text/plain');
    $this->put(\content(PAGE . DS . $this[0] . DS . 'view.data') ?? "");
});