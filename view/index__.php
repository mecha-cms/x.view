<?php

function fn_view_set($path) {
    $path = rtrim(PAGE . DS . To::path($path), DS) . DS . 'view.data';
    $i = (int) File::open($path)->get(0, 0);
    File::write($i + 1)->saveTo($path);
}

function fn_view_get($data) {
    global $language;
    if (isset($data['view'])) {
        $i = $data['view'];
        $data['view'] = $i . ' ' . $language->page_view[$i === 1 ? 0 : 1];
    } else {
        $data['view'] = '0 ' . $language->page_view[1];
    }
    return $data;
}

Route::hook('%*%', 'fn_view_set');
Hook::set('page.output', 'fn_view_get');