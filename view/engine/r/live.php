<?php namespace _\page;

\Asset::set(__DIR__ . DS . '..' . DS . '..' . DS . 'lot' . DS . 'asset' . DS . 'js' . DS . 'view.min.js', 10, [
    'data-view' => \Language::get('page-view-count')
]);

function view($view, array $lot = []) {
    return '<span class="view" data-path="' . \Path::R(\Path::F($this->path . ""), PAGE, '/') . '">' . $view . '</span>';
}

\Hook::set('page.view', __NAMESPACE__ . "\\view", 1);

\Route::set('.view/*', function() {
    $this->status(200);
    $this->type('text/plain');
    $this->content(\content(PAGE . $this[0] . DS . 'view.data') ?? "");
});