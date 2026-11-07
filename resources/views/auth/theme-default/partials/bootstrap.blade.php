<script>
    window.AUTH_LANGUAGE_DATA = @json($authLanguageCatalogs ?? []);
    (function () {
        var configuredLanguage = @json($config?->default_lang ?: app()->getLocale() ?: 'en');
        var storedLanguage = null;

        try {
            storedLanguage = localStorage.getItem('data-lang');
        } catch (error) {}

        var language = (storedLanguage || configuredLanguage).toLowerCase().replace('_', '-').split('-')[0];
        try {
            if (!storedLanguage) localStorage.setItem('data-lang', language);
        } catch (error) {}

        document.documentElement.lang = language;
        document.cookie = 'data-lang=' + encodeURIComponent(language) + '; path=/; SameSite=Lax';
        window.AUTH_LANG = language;
        window.AUTH_DEFAULT_LANG = configuredLanguage;
    })();
</script>
