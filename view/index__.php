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
            File::write('0')->saveTo($path);
        }
        if (($i = file_get_contents($path)) !== false) {
            $i = (int) $i;
            File::write($i + 1)->saveTo($path);
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

Hook::set('page.view', 'fn_view_get');

// Is online…
if (!Is::this(['127.0.0.1', '::1'])->contain($_SERVER['REMOTE_ADDR'])) {
    Route::lot(['%*%/%i%', '%*%', ""], 'fn_view_set');
}