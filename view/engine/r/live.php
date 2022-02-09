<?php namespace x\view\live;

$z = \defined("\\TEST") && \TEST ? '.' : '.min.';
\Asset::set(__DIR__ . \D . '..' . \D . '..' . \D . 'lot' . \D . 'asset' . \D . 'index' . $z . 'js');

function route($r, $path) {
    if (isset($r['content']) || isset($r['kick'])) {
        return $r;
    }
    $request = \status()[1] ?? [];
    $r['content'] = "";
    $r['status'] = 404;
    $r['type'] = 'text/plain';
    if ('XHR' !== ($request['x-request-with'] ?? "")) {
        return $r;
    }
    $r['content'] = \content(\LOT . \D . 'page' . \D . $path . \D . 'view.data') ?? "";
    $r['status'] = 200;
    return $r;
}

function set($count) {
    $path = $this->path;
    $path = \strtr(\strtr(\dirname($path) . \D . \pathinfo($path, \PATHINFO_FILENAME), [\LOT . \D . 'page' . \D => ""]), \D, '/');
    return '<output class="view" for="' . $path . '">' . $count . '</output>';
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 1);

\Hook::set('route', function($r, $path) {
    if (\preg_match('/^\/\.view\/(.*?)$/', $path ?? "", $m)) {
        return \call_user_func(__NAMESPACE__ . "\\route", $r, '/' . $m[1]);
    }
    return $r;
}, 0);

// `dechex(crc32('.\lot\x\view'))`
\setcookie('_b934eebc', \i('0 Views') . '|' . \i('1 View') . '|' . \i('%d Views'), 0, '/', "", true, false);