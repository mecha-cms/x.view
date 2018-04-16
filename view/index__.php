<?php

function fn_view_set($path = "", $step = null) {
    global $site;
    $s = rtrim(PAGE . DS . To::path($path === "" ? $site->path : $path), DS);
    $i = $step !== null ? DS . $step : X;
    if ($file = File::exist([
        $s . $i . '.page',
        $s . $i . '.archive',
        $s . '.page',
        $s . '.archive'
    ])) {
        $path = Path::F($file) . DS . 'view.data';
        if (!file_exists($path)) {
            File::set('0')->saveTo($path);
        }
        if (($i = file_get_contents($path)) !== false) {
            $i = (int) $i;
            File::set($i + 1)->saveTo($path);
        }
    }
}

function fn_view_get($view) {
    global $language;
    if ($view !== null) {
        $i = (int) $view;
        return $view . ' ' . $language->page_view[$i === 1 ? 0 : 1];
    }
    return '0 ' . $language->page_view[1];
}

Hook::set('page.view', 'fn_view_get', 0);

// Is online…
if (!Is::this(['127.0.0.1', '::1'])->has($_SERVER['REMOTE_ADDR'])) {
    // Is logged out…
    if (!Extend::exist('user') || !Is::user()) {
        Route::lot(['%*%/%i%', '%*%', ""], 'fn_view_set');
    }
}

// Live preview?
if (Plugin::state('view', 'live')) {
    require __DIR__ . DS . 'lot' . DS . 'worker' . DS . 'live.php';
}