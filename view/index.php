<?php namespace _\lot\x\view;

function route($any = null) {
    global $state, $url;
    $i = $url['i'];
    $folder = \rtrim(\LOT . \DS . 'page' . \DS . \strtr($any ?? \trim(\State::get('path'), '/'), '/', \DS), \DS);
    $i = null !== $i ? \DS . $i : \P;
    if ($file = \File::exist([
        $folder . $i . '.page',
        $folder . $i . '.archive',
        $folder . '.page',
        $folder . '.archive'
    ])) {
        $path = \Path::F($file) . \DS . 'view.data';
        if (!\is_file($path)) {
            if (!\is_dir($d = \dirname($path))) {
                \mkdir($d, 0775, true);
            }
            \file_put_contents($path, '0');
            \chmod($path, 0600);
        } else {
            if (false !== ($i = \file_get_contents($path))) {
                $i = (int) $i;
                \file_put_contents($path, (string) ($i + 1));
                \chmod($path, 0600);
            }
        }
    }
}

function set($i) {
    return \trim(\i(null === $i ? '0 Views' : (1 === $i ? '1 View' : '%d Views'), $i));
}

// Is online…
if (!\has(['127.0.0.1', '::1'], \Client::IP())) {
    // Is logged out…
    if (null === \State::get('x.user') || !\Is::user()) {
        \Route::over(['*', ""], __NAMESPACE__ . "\\route");
    }
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 0);

// Live preview?
if (\State::get('x.view.live')) {
    require __DIR__ . \DS . 'engine' . \DS . 'r' . \DS . 'live.php';
}
