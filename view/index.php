<?php

namespace _\view {
    function set() {
        global $config, $url;
        $i = $url->i;
        $folder = \rtrim(PAGE . DS . \To::path($this[0] ?? $config->path), DS);
        $i = $i !== null ? DS . $i : P;
        if ($file = \File::exist([
            $folder . $i . '.page',
            $folder . $i . '.archive',
            $folder . '.page',
            $folder . '.archive'
        ])) {
            $path = \Path::F($file) . DS . 'view.data';
            if (!\is_file($path)) {
                \File::set('0')->saveTo($path, 0600);
            }
            if (false !== ($i = \file_get_contents($path))) {
                $i = (int) $i;
                \File::set((string) ($i + 1))->saveTo($path, 0600);
            }
        }
    }
    function get($view) {
        global $language;
        if ($view !== null) {
            $i = (int) $view;
            return \trim($language->pageViewCount($view));
        }
        return \trim($language->pageViewCount(0));
    }
    // Is online…
    if (!\has(['127.0.0.1', '::1'], \Get::IP())) {
        // Is logged out…
        if (\extend('user') === null || !\Is::user()) {
            \Route::over(['*', ""], __NAMESPACE__ . "\\set");
        }
    }
    \Hook::set('page.view', __NAMESPACE__ . "\\get", 0);
    \Language::set('page-view-count', ['0 Views', '1 View', '%d Views']);
}

namespace {
    // Live preview?
    if (\plugin('view')['live']) {
        require __DIR__ . DS . 'engine' . DS . 'r' . DS . 'live.php';
    }
}