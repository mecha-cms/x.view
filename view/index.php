<?php namespace _\lot\x\view;

function route($any = null) {
    // Do not count page view(s) if page is requested with something else other than normal web browser(s)
    if (
        // <https://developer.mozilla.org/en-US/docs/Web/HTTP/Link_prefetching_FAQ#As_a_server_admin.2C_can_I_distinguish_prefetch_requests_from_normal_requests.3F>
        'prefetch' === $this->lot('purpose') ||
        'prefetch' === $this->lot('x-moz') ||
        'prefetch' === $this->lot('x-purpose') ||
        'preview' === $this->lot('x-purpose')
    ) {
        return;
    }
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
            \file_put_contents($path, '1');
            @\chmod($path, 0600);
        } else {
            if (false !== ($i = \file_get_contents($path))) {
                $i = (int) $i;
                \file_put_contents($path, (string) ($i + 1));
                @\chmod($path, 0600);
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
        \Route::hit(['*', ""], __NAMESPACE__ . "\\route");
    }
}

\Hook::set('page.view', __NAMESPACE__ . "\\set", 0);

// Live preview?
if (\State::get('x.view.live')) {
    require __DIR__ . \DS . 'engine' . \DS . 'r' . \DS . 'live.php';
}
