<?php namespace _\lot\x\view\live;

\Asset::set(__DIR__ . DS . '..' . DS . '..' . DS . 'lot' . DS . 'asset' . DS . 'js' . DS . 'view.min.js', 10, [
    'data-language' => \Language::get('page-view-count')
]);

function route() {
    if ($this->header('X-Requested-With') !== 'XHR') {
        \Guard::abort('Method not allowed.');
    }
    $this->type('text/plain');
    echo \content(PAGE . DS . $this[0] . DS . 'view.data') ?? "";
    exit;
}

function set($i) {
    return '<output class="view" for="' . \Path::R(\Path::F((string) $this->path), PAGE, '/') . '">' . $i . '</output>';
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 1);
\Route::set('.view/*', 200, __NAMESPACE__ . "\\route");