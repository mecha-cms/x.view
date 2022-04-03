<?php namespace x\view\live;

$z = \defined("\\TEST") && \TEST ? '.' : '.min.';
\Asset::set(__DIR__ . \D . '..' . \D . '..' . \D . 'index' . $z . 'js');

function route($content, $path) {
    if (null !== $content) {
        return $content;
    }
    $r = \status()[1] ?? [];
    \type('text/plain');
    if ('XHR' !== ($r['x-requested-with'] ?? "")) {
        \status(404);
        return "";
    }
    \status(200);
    return \content(\LOT . \D . 'page' . \D . $path . \D . 'view.data') ?? "";
}

function set($count) {
    $path = $this->path;
    $path = \strtr(\strtr(\dirname($path) . \D . \pathinfo($path, \PATHINFO_FILENAME), [\LOT . \D . 'page' . \D => ""]), \D, '/');
    return '<output class="view" for="' . $path . '">' . $count . '</output>';
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 1);

\Hook::set('route', function($content, $path) {
    if (\preg_match('/^\/\.view\/(.*?)$/', $path ?? "", $m)) {
        return \call_user_func(__NAMESPACE__ . "\\route", $content, '/' . $m[1]);
    }
    return $content;
}, 0);

// `dechex(crc32('.\lot\x\view'))`
\setcookie('*b934eebc', \i('0 Views') . '|' . \i('1 View') . '|' . \i('%d Views'), [
    'domain' => "",
    'expires' => 0,
    'httponly' => true,
    'path' => '/',
    'samesite' => 'Strict',
    'secure' => false
]);