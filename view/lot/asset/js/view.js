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

    var view = doc.querySelectorAll('.view[data-view]'),
        interval = 10, // 10 second(s)
        i, j = view.length,
        timer = win.setTimeout;

    function get($) {
        ajax($.getAttribute('data-view'), function(r) {
            var c = $.children[0],
                i = +c.innerHTML,
                j = 0;
            r = +(r || 0);
            if (r > i) {
                // console.log('animate to ' + r);
                (function loop(k) {
                    ++j;
                    timer(function() {
                        c.innerHTML = i + j;
                        // console.log('animated to ' + (i + j));
                        if (--k) {
                            loop(k);
                        } else {
                            // console.log('check...');
                            timer(function() {
                                get($);
                            }, 1000 * interval);
                        }
                    }, 50);
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