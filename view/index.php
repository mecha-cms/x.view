<?php namespace _\lot\x\view;

function route() {
    global $config, $url;
    $i = $url->i;
    $folder = \rtrim(PAGE . DS . \strtr($this[0] ?? \Config::get('/'), '/', DS), DS);
    $i = $i !== null ? DS . $i : P;
    if ($file = \File::exist([
        $folder . $i . '.page',
        $folder . $i . '.archive',
        $folder . '.page',
        $folder . '.archive'
    ])) {
        $path = \Path::F($file) . DS . 'view.data';
        if (!\is_file($path)) {
            $file = new \File($path);
            $file->set('0');
            $file->save(0600);
        } else {
            $file = new \File($path);
            $i = (int) $file->get(0);
            $file->set((string) ($i + 1));
            $file->save(0600);
        }
    }
}

function set($i) {
    return \trim($GLOBALS['language']->pageViewCount($i ?? 0));
}

// Is online…
if (!\has(['127.0.0.1', '::1'], \Get::IP())) {
    // Is logged out…
    if (\state('user') === null || !\Is::user()) {
        \Route::over(['*', ""], __NAMESPACE__ . "\\route");
    }
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 0);
\Language::set('page-view-count', ['0 Views', '1 View', '%d Views']);

// Live preview?
if (!empty(\state('view')['live'])) {
    require __DIR__ . DS . 'engine' . DS . 'r' . DS . 'live.php';
}