<script>
    (function () {
        var languageCode = window.AUTH_LANG || localStorage.getItem('data-lang')
            || window.AUTH_DEFAULT_LANG || @json($config?->default_lang ?: app()->getLocale() ?: 'en');
        var language = window.LANGUAGE || {};
        var selectedDictionary = languageCode === 'vi' ? language.language : language.core;
        var selectedAlertTitle = selectedDictionary?.message?.Alert;
        var activeTranslations = window.AUTH_LANGUAGE_DATA?.[languageCode] || {};

        if (language.language && selectedDictionary) language.language = selectedDictionary;

        function translateDataLang(element) {
            if (!element || !element.hasAttribute('data-lang')) return;

            var key = element.getAttribute('data-lang') || element.textContent.trim();
            var elementPage = element.getAttribute('data-page') || page;
            var group = key.indexOf('::') >= 0 ? key.split('::')[0] : elementPage;
            var localized = activeTranslations[group + '.' + key] || activeTranslations[key]
                || language.language?.[group]?.[key] || language.core?.[group]?.[key];
            if (!localized) return;

            if (element.matches('input, textarea')) {
                if (element.hasAttribute('placeholder')) {
                    if (element.placeholder !== localized) element.placeholder = localized;
                } else if (element.hasAttribute('value') && element.value !== localized) {
                    element.value = localized;
                }
            } else if (element.textContent.trim() !== localized) {
                element.textContent = localized;
            }
        }

        function translateAlertTitle(title) {
            if (!title || !title.matches('#modal-alert .modal-title')) return;

            title.setAttribute('data-lang', 'Alert');
            title.setAttribute('data-page', 'message');
            translateDataLang(title);
            var localized = languageCode === 'vi'
                ? selectedAlertTitle || activeTranslations?.['message.Alert'] || language.core?.message?.Alert
                : activeTranslations?.['message.Alert'] || selectedAlertTitle || language.language?.message?.Alert;

            if (localized && title.textContent.trim() !== localized) {
                title.textContent = localized;
            }
        }

        var observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                var target = mutation.type === 'characterData'
                    ? mutation.target.parentElement?.closest('[data-lang]')
                    : mutation.target;
                if (target?.nodeType === Node.ELEMENT_NODE) translateDataLang(target);

                mutation.addedNodes?.forEach(function (node) {
                    if (node.nodeType !== Node.ELEMENT_NODE) return;
                    if (node.matches('[data-lang]')) translateDataLang(node);
                    node.querySelectorAll?.('[data-lang]').forEach(translateDataLang);
                    if (node.matches('#modal-alert .modal-title')) translateAlertTitle(node);
                    node.querySelectorAll?.('#modal-alert .modal-title').forEach(translateAlertTitle);
                });
            });
        });
        observer.observe(document.body, { childList: true, characterData: true, subtree: true });

        if (language.language) {
            Object.keys(activeTranslations).forEach(function (catalogKey) {
                var separator = catalogKey.indexOf('.');
                if (separator < 1) return;

                var group = catalogKey.slice(0, separator);
                var key = catalogKey.slice(separator + 1);
                language.language[group] = language.language[group] || {};
                language.language[group][key] = activeTranslations[catalogKey];
            });
        }

        var page = '/' + (window.location.pathname.split('/')[1] || '');
        document.querySelectorAll('[data-lang]').forEach(translateDataLang);

        var title = document.querySelector('title[data-lang]');
        if (title) {
            document.title = title.textContent + ' - ' + document.title.split(' - ').slice(1).join(' - ');
        }
        document.querySelectorAll('#modal-alert .modal-title').forEach(translateAlertTitle);
    })();
</script>
