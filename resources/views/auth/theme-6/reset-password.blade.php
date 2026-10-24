<!DOCTYPE html>
<html id="theme_23" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title data-lang="auth.reset_password">{{ __('auth.reset_password') }} - {{ $siteTitle }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ $siteKeywords }}">
    <meta name="description" content="{{ $siteDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <script>
        (function() {
            var lang = localStorage.getItem('data-lang') || 'vi';
            document.documentElement.lang = lang.replace('_', '-');
            window.__siteLang = lang;
        })();
    </script>
    @if (!empty($config?->favicon))
        <link rel="shortcut icon" type="image/ico" href="{{ $config->favicon }}">
        <link rel="icon" type="image/png" href="{{ $config->favicon }}">
        <link rel="apple-touch-icon" href="{{ $config->favicon }}">
    @endif
    <link rel="preload" href="{{ asset('storage.perfectcdn.com/theme-6/fonts/mem8YaGs126MiZpBA-U1UpcaXcl0Aw.ttf') }}" as="font" type="font/ttf" crossorigin>
    <link rel="preload" href="{{ asset('storage.perfectcdn.com/theme-6/fonts/mem5YaGs126MiZpBA-UNirk-VeJoCqeDjg.ttf') }}" as="font" type="font/ttf" crossorigin>
    <link rel="preload" href="{{ asset('storage.perfectcdn.com/theme-6/fonts/mem5YaGs126MiZpBA-UN7rg-VeJoCqeDjg.ttf') }}" as="font" type="font/ttf" crossorigin>
    <link rel="stylesheet" href="{{ asset('storage.perfectcdn.com/theme-6/css/ojd5wm8q8es3jjdb.css') }}">
    <link rel="stylesheet" href="{{ asset('storage.perfectcdn.com/theme-6/css/wsz57ycp89410z6e.css') }}?v={{ filemtime(public_path('storage.perfectcdn.com/theme-6/css/wsz57ycp89410z6e.css')) }}">
    <script>
        window.modules = {};
    </script>
</head>

<body class="body body-public">
    <div id="block_122">
        <div class="block-bg"></div>
        <div class="container-fluid">
            <div class="reset-password-form">
                <div class="row reset-password-form__alignment">
                    <div class="col-lg-4 col-md-7 col-sm-10">
                        <div class="component_card">
                            <div class="card">
                                <form method="post" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="component_form_group">
                                        @if ($errors->any())
                                            <div class="alert alert-danger" role="alert">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="email" class="control-label"
                                                data-lang="auth.email">{{ __('auth.email') }}</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email', $email) }}" required autocomplete="email"
                                                autofocus placeholder="{{ __('auth.email') }}"
                                                data-lang-placeholder="auth.email">
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="control-label"
                                                data-lang="auth.password">{{ __('auth.password') }}</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                required minlength="8" autocomplete="new-password"
                                                placeholder="{{ __('auth.password') }}"
                                                data-lang-placeholder="auth.password">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation" class="control-label"
                                                data-lang="auth.confirm_password">{{ __('auth.confirm_password') }}</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" required minlength="8"
                                                autocomplete="new-password"
                                                placeholder="{{ __('auth.confirm_password') }}"
                                                data-lang-placeholder="auth.confirm_password">
                                        </div>
                                        <div class="component_button_submit">
                                            <button type="submit" class="btn btn-block btn-big-primary"
                                                data-lang="auth.reset_password">{{ __('auth.reset_password') }}</button>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-center">
                                        <a href="{{ route('login') }}"
                                            data-lang="auth.back_to_login">{{ __('auth.back_to_login') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('storage.perfectcdn.com/theme-6/js/99gttjw1i1l6jmws.js') }}"></script>
    <script src="https://storage.perfectcdn.com/global/hecwkrtjf5h4271l.js"></script>
    <script src="{{ asset('storage.perfectcdn.com/theme-6/js/ap5ifcinp3jk13sr.js') }}"></script>
    <script>
        window.modules.layouts = <?php echo json_encode([
            'theme_id' => 23,
            'auth' => 0,
            'live' => true,
            'csrftoken' => csrf_token(),
        ]); ?>;
        window.modules.reset_password = [];
    </script>
    <script>
        (function() {
            var lang = localStorage.getItem('data-lang') || 'vi';
            fetch('/lang/' + lang + '.json')
                .then(function(response) {
                    return response.ok ? response.json() : null;
                })
                .then(function(translations) {
                    if (!translations) return;

                    var siteTitle = @json($siteTitle);
                    document.querySelectorAll('[data-lang]').forEach(function(element) {
                        var key = element.getAttribute('data-lang');
                        if (translations[key] !== undefined) element.textContent = translations[key];
                    });
                    document.querySelectorAll('[data-lang-placeholder]').forEach(function(element) {
                        var key = element.getAttribute('data-lang-placeholder');
                        if (translations[key] !== undefined) element.placeholder = translations[key];
                    });
                    if (translations['auth.reset_password']) {
                        document.title = translations['auth.reset_password'] + ' - ' + siteTitle;
                    }
                })
                .catch(function() {});
        })();
    </script>
</body>

</html>
