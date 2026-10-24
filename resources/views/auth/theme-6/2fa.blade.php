<!DOCTYPE html>
<html id="theme_23" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title data-lang="/2fa-auth.Two Step Verification">Two-factor authentication</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ $siteKeywords }}">
    <meta name="description" content="{{ $siteDescription }}">
    <link rel="canonical" href="{{ route('2fa.show') }}">
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
    <div id="block_112">
        <div class="block-bg"></div>
        <div class="container">
            <div class="block-2fa">
                <div class="row form-alignment">
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <div class="component_card">
                            <div class="card">
                                <form method="post" action="{{ route('2fa.verify') }}" class="component_form_group">
                                    @csrf
                                    <h4 data-lang="/2fa-auth.Two Step Verification">Two-factor authentication</h4>
                                    <div class="mb-4" data-lang="/2fa-auth.Type your 6 digit security code">
                                        Enter the 6-digit code from your authenticator app.
                                    </div>

                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                                    @endif
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
                                        <label for="code" class="control-label"
                                            data-lang="/2fa-auth.Verification code">Verification code</label>
                                        <input type="text" class="form-control" id="code" name="code"
                                            value="{{ old('code') }}" required maxlength="6" minlength="6"
                                            inputmode="numeric" pattern="[0-9]{6}" autocomplete="one-time-code"
                                            autofocus>
                                    </div>
                                    <div class="component_button_submit">
                                        <button type="submit" class="btn btn-block btn-big-primary"
                                            data-lang="/2fa-auth.Submit">Continue</button>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <a href="{{ route('login') }}"
                                            data-lang="/2fa-auth.Back to Sign In">Back to Sign In</a>
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
            'theme_id' => 24,
            'auth' => 0,
            'live' => true,
            'csrftoken' => csrf_token(),
        ]); ?>;
        window.modules.two_factor = [];
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
                    document.querySelectorAll('[data-lang]').forEach(function(element) {
                        var key = element.getAttribute('data-lang');
                        if (translations[key] !== undefined) element.textContent = translations[key];
                    });
                    if (translations['/2fa-auth.Two Step Verification']) {
                        document.title = translations['/2fa-auth.Two Step Verification'] + ' - ' +
                            @json($siteTitle);
                    }
                })
                .catch(function() {});
        })();
    </script>
</body>

</html>
