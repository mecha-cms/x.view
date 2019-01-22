<?php

namespace fn\view {
    function set($path = "", $step = null) {
        global $config;
        $folder = \rtrim(PAGE . DS . \To::path($path === "" ? $config->path : $path), DS);
        $i = $step !== null ? DS . $step : X;
        if ($file = \File::exist([
            $folder . $i . '.page',
            $folder . $i . '.archive',
            $folder . '.page',
            $folder . '.archive'
        ])) {
            $path = \Path::F($file) . DS . 'view.data';
            if (!\file_exists($path)) {
                \File::put('0')->saveTo($path, 0600);
            }
            if (($i = \file_get_contents($path)) !== false) {
                $i = (int) $i;
                \File::put($i + 1)->saveTo($path, 0600);
            }
        }
    }
    function get($view) {
        global $language;
        if ($view !== null) {
            $i = (int) $view;
            return \trim($view . ' ' . $language->page_view[$i === 1 ? 0 : 1]);
        }
        return \trim('0 ' . $language->page_view[1]);
    }
    // Is online…
    if (!\has(['127.0.0.1', '::1'], \Get::IP())) {
        // Is logged out…
        if (!\Extend::exist('user') || !\Is::user()) {
            \Route::lot(['%*%/%i%', '%*%', ""], __NAMESPACE__ . "\\set");
        }
    }
    \Hook::set('page.view', __NAMESPACE__ . "\\get", 0);
}

namespace {
    // Live preview?
    if (\Plugin::state('view', 'live')) {
        require __DIR__ . DS . 'lot' . DS . 'worker' . DS . 'live.php';
    }
}