<?php namespace x\view;

function route($content, $path) {
    if (null !== $content) {
        return $content;
    }
    $request = \status()[1] ?? [];
    // Do not count page view(s) if page is requested with something else other than normal web browser(s)
    if (
        // <https://developer.mozilla.org/en-US/docs/Web/HTTP/Link_prefetching_FAQ#as_a_server_admin_can_i_distinguish_prefetch_requests_from_normal_requests>
        isset($request['purpose']) && 'prefetch' === $request['purpose'] ||
        isset($request['x-moz']) && 'prefetch' === $request['x-moz'] ||
        isset($request['x-purpose']) && 'prefetch' === $request['x-purpose'] ||
        isset($request['x-purpose']) && 'preview' === $request['x-purpose']
    ) {
        return $content;
    }
    \extract($GLOBALS, \EXTR_SKIP);
    $folder = \rtrim(\LOT . \D . 'page' . \D . \strtr(\trim($path ?? $state->route, '/'), '/', \D), \D);
    if ($file = \exist([
        $folder . '.archive',
        $folder . '.page'
    ], 1)) {
        $view = \dirname($file) . \D . \pathinfo($file, \PATHINFO_FILENAME) . \D . 'view.data';
        if (!\is_file($view)) {
            if (!\is_dir($d = \dirname($view))) {
                \mkdir($d, 0775, true);
            }
            \file_put_contents($view, '1'); // Starts at `1`
            \chmod($view, 0600);
        } else {
            if (\is_readable($view) && \is_writable($view) && false !== ($v = \file_get_contents($view))) {
                if (($v = (int) $v) > 0) {
                    if (false !== \file_put_contents($view . '~', (string) ($v + 1))) { // Increment value by `1`
                        \rename($view . '~', $view);
                        \chmod($view, 0600);
                    }
                } else {
                    // If `$v` ever becomes `0` then something must have gone wrong. It is better not to do anything.
                    // Better to lose one page view than to lose it all by accidentally writing the page view data
                    // back to `1`.
                }
            }
        }
    }
    return $content;
}

function set($i) {
    return \trim(\i(null === $i ? '0 Views' : (1 === $i ? '1 View' : '%d Views'), $i));
}

// Is online…
if (!\has(['127.0.0.1', '::1'], \ip())) {
    // Is logged out…
    if (!isset($state->x->user) || !\Is::user()) {
        \Hook::set('route.page', __NAMESPACE__ . "\\route", 0);
    }
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 0);