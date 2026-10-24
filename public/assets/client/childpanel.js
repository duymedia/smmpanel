(function (window, $) {
    'use strict';

    if (!$ || typeof window._childpanel !== 'object' || !window._childpanel.on || !window._childpanel.on.click) {
        return;
    }

    window._childpanel.init = function () {
        $('#child-panel-form')
            .off('submit.childPanel')
            .on('submit.childPanel', function (event) {
                event.preventDefault();
                window._childpanel.on.click.create();
            });
    };
})(window, window.jQuery);
