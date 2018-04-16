(function(win, doc) {

    function ajax(url, fn) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                fn(xhr.responseText);
            }
        };
        xhr.open('GET', url, true);
        xhr.send();
    }

    var view = doc.querySelectorAll('.view[data-path]'),
        script = doc.getElementsByTagName('script'),
        src, text,
        interval = 10, // 10 second(s)
        i, j = view.length,
        timer = win.setTimeout;

    if (!j) return;

    script = script[script.length - 1];
    src = script.src;
    src = src.slice(0, src.indexOf('/lot/')) + '/-view/';
    text = script.getAttribute('data-view');
    text = JSON.parse(text || '["",""]');

    function get($) {
        ajax(src + $.getAttribute('data-path'), function(r) {
            var i = +$.innerHTML.split(/\s+/)[0],
                j = 0, k;
            r = +(r || 0);
            if (r > i) {
                // console.log('animate to ' + r);
                (function loop(l) {
                    ++j;
                    timer(function() {
                        k = i + j;
                        $.innerHTML = k + ' ' + (k === 1 ? text[0] : (text[1] || text[0]));
                        // console.log('animated to ' + (i + j));
                        if (--l) {
                            loop(l);
                        } else {
                            // console.log('check...');
                            timer(function() {
                                get($);
                            }, 1000 * interval);
                        }
                    }, 10);
                })(r - i);
            } else {
                // console.log('no change, check again...');
                timer(function() {
                    get($);
                }, 1000 * interval);
            }
        });
    }

    for (i = 0; i < j; ++i) {
        // console.log('begin...');
        get(view[i]);
    }

})(window, document);