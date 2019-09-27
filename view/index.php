<?php namespace _\lot\x\view;

function route() {
    global $state, $url;
    $i = $url->i;
    $folder = \rtrim(\PAGE . \DS . \strtr($this[0] ?? \trim(\State::get('path'), '/'), '/', \DS), \DS);
    $i = $i !== null ? \DS . $i : \P;
    if ($file = \File::exist([
        $folder . $i . '.page',
        $folder . $i . '.archive',
        $folder . '.page',
        $folder . '.archive'
    ])) {
        $path = \Path::F($file) . \DS . 'view.data';
        if (!\is_file($path)) {
            $file = new \File($path);
            $file->set('0')->save(0600);
        } else {
            $file = new \File($path);
            $i = (int) $file->get(0);
            $file->set((string) ($i + 1))->save(0600);
        }
    }
}

function set($i) {
    return \trim($GLOBALS['language']->pageViewCount($i ?? 0));
}

// Is online…
if (!\has(['127.0.0.1', '::1'], \Get::IP())) {
    // Is logged out…
    if (\State::get('x.user') === null || !\Is::user()) {
        \Route::over(['*', ""], __NAMESPACE__ . "\\route");
    }
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 0);
\Language::set('page-view-count', ['0 Views', '1 View', '%d Views']);

// Live preview?
if (\State::get('x.view.live')) {
    require __DIR__ . \DS . 'engine' . \DS . 'r' . \DS . 'live.php';
}