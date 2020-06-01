<?php namespace _\lot\x\view\live;

$z = \defined("\\DEBUG") && \DEBUG ? '.' : '.min.';
\Asset::set(__DIR__ . \DS . '..' . \DS . '..' . \DS . 'lot' . \DS . 'asset' . \DS . 'js' . \DS . 'view' . $z . 'js');

function route($any) {
    if ('XHR' !== $this->lot('x-requested-with')) {
        $this->status(404);
        exit;
    }
    $this->type('text/plain');
    echo \content(\LOT . \DS . 'page' . \DS . $any . \DS . 'view.data') ?? "";
    exit;
}

function set($i) {
    return '<output class="view" for="' . \Path::R(\Path::F((string) $this->path), \LOT . \DS . 'page', '/') . '">' . $i . '</output>';
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 1);
\Route::set('.view/*', 200, __NAMESPACE__ . "\\route");

// `dechex(crc32('.\lot\x\view'))`
\setcookie('_b934eebc', \i('0 Views') . '|' . \i('1 View') . '|' . \i('%d Views'));
