<?php namespace x\view\live;

$z = \defined("\\TEST") && \TEST ? '.' : '.min.';
\Asset::set(__DIR__ . \D . '..' . \D . '..' . \D . 'lot' . \D . 'asset' . \D . 'js' . \D . 'index' . $z . 'js');

function route($path) {
    $request = \status()[1] ?? [];
    if ('XHR' !== $request['x-request-with']) {
        \status(404);
        exit;
    }
    \status(200);
    \type('text/plain');
    echo \content(\LOT . \D . 'page' . \D . $path . \D . 'view.data') ?? "";
    exit;
}

function set($count) {
    $path = $this->path;
    $path = \strtr(\strtr(\dirname($path) . \D . \pathinfo($path, \PATHINFO_FILENAME), [\LOT . \D . 'page' . \D => ""]), \D, '/');
    return '<output class="view" for="' . $path . '">' . $count . '</output>';
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 1);

\Hook::set('route', function($path) {
    if (\preg_match('/^\.view\/(.*?)$/', $path, $m)) {
        \call_user_func(__NAMESPACE__ . "\\route", $m[1]);
    }
}, 0);

// `dechex(crc32('.\lot\x\view'))`
\setcookie('_b934eebc', \i('0 Views') . '|' . \i('1 View') . '|' . \i('%d Views'), 0, '/', "", true, false);