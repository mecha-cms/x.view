<?php

namespace _\view {
    function set() {
        $i = $this->url->i;
        $folder = \rtrim(PAGE . DS . \To::path($this[0] ?? $this->config->path), DS);
        $i = $i !== null ? DS . $i : X;
        if ($file = \File::exist([
            $folder . $i . '.page',
            $folder . $i . '.archive',
            $folder . '.page',
            $folder . '.archive'
        ])) {
            $path = \Path::F($file) . DS . 'view.data';
            if (!\is_file($path)) {
                \File::put('0')->saveTo($path, 0600);
            }
            if (false !== ($i = \file_get_contents($path))) {
                $i = (int) $i;
                \File::put((string) ($i + 1))->saveTo($path, 0600);
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
        if (!\Extend::exist('user') || !\Is::user()) {
            \Route::lot(['*', ""], __NAMESPACE__ . "\\set");
        }
    }
    \Hook::set('page.view', __NAMESPACE__ . "\\get", 0);
    \Language::set('page-view-count', ['0 Views', '1 View', '%d Views']);
}

namespace {
    // Live preview?
    if (\Plugin::state('view', 'live')) {
        require __DIR__ . DS . 'engine' . DS . 'r' . DS . 'live.php';
    }
}