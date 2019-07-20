(function(win, doc) {

    function ajax(url, fn) {
        if (typeof fetch === "function") {
            fetch(url, {
                headers: new Headers({
                    'X-Requested-With': 'XHR'
                })
            }).then(function(response) {
                response.text().then(fn);
            });
            return;
        }
        var xhr = new XMLHttpRequest;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                fn(xhr.responseText);
            }
        };
        xhr.open('GET', url, true);
        xhr.setRequestHeader('X-Requested-With', 'XHR');
        xhr.send();
    }

    var view = doc.querySelectorAll('.view[for]'),
        script = doc.currentScript,
        src = script.src,
        text = script.getAttribute('data-language'),
        interval = 10, // 10 second(s)
        i, j = view.length,
        timer = win.setTimeout;

    if (!j) return;

    src = src.slice(0, src.indexOf('/lot/')) + '/.view/';
    text = JSON.parse(text || '["","",""]');

    function get($) {
        ajax(src + $.getAttribute('for'), function(r) {
            var i = +(/\d+/.exec($.value)[0] || 0),
                j = 0, k;
            r = +(r || 0);
            if (r > i) {
                // console.log('animate to ' + r);
                (function loop(l) {
                    ++j;
                    timer(function() {
                        k = i + j;
                        $.value = (text[k] || text[2]).replace(/%d/g, k).trim();
                        // console.log('animated to ' + (i + j));
                        if (--l) {
                            loop(l);
                        } else {
                            // console.log('check...');
                            timer(function() {
                                get($);
                            }, 1000 * interval);
                        }
                    }, 100);
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