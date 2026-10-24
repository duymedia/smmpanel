<!DOCTYPE html>
<html id="theme_23" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title data-lang="auth.sign_up">{{ __('auth.sign_up') }} - {{ $settings['title'] ?? config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        (function() {
            var lang = localStorage.getItem('data-lang') || 'vi';
            document.documentElement.lang = lang.replace('_', '-');
            window.__siteLang = lang;
        })();
    </script>
    @if(!empty($config->favicon))
        <link rel="shortcut icon" type="image/ico" href="{{ $config->favicon }}">
        <link rel="icon" type="image/png" href="{{ $config->favicon }}">
        <link rel="apple-touch-icon" href="{{ $config->favicon }}">
    @endif
     <link href="{{ asset('storage.perfectcdn.com/theme-6/js/99gttjw1i1l6jmws.js') }}" rel="preload" as="script">
<link href="{{ asset('storage.perfectcdn.com/theme-6/js/qoy6usyny80ul09k.js') }}" rel="preload" as="script">
<link href="{{ asset('storage.perfectcdn.com/theme-6/js/ap5ifcinp3jk13sr.js') }}" rel="preload" as="script">
@if(!empty($settings['google_client_id']))
        <link href="https://accounts.google.com/gsi/client" rel="preload" as="script">
    @endif
<link href="{{ asset('storage.perfectcdn.com/theme-6/js/f7lw81wrmhzxhpb3.js') }}" rel="preload" as="script">

      <link rel="stylesheet" type="text/css" href="{{ asset('storage.perfectcdn.com/theme-6/css/ojd5wm8q8es3jjdb.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('storage.perfectcdn.com/theme-6/css/wsz57ycp89410z6e.css') }}">
    <script>window.modules = {};</script>
</head>
<body class="body body-public">

<div id="block_123">
    <div class="block-bg"></div>
    <div class="container">
        <div class="sign-in">
            <div class="row sign-up-center-alignment">
                <div class="col-lg-8">
                    <div class="component_card">
                        <div class="card">
                            <form action="{{ route('signup.store') }}" method="post">
                                @csrf

                                @if(!empty($settings['google_client_id']))
                                    <div class="component_form_group">
                                        <div class="form-group">
                                            <div id="g_id_onload"
                                                data-client_id="{{ $settings['google_client_id'] }}"
                                                data-login_uri="{{ url('/confirm_signup') }}"
                                                data-auto_prompt="false"></div>
                                            <div class="g_id_signin" data-type="standard" data-size="large"
                                                data-theme="outline" data-text="sign_in_with"
                                                data-shape="rectangular" data-logo_alignment="left"></div>
                                        </div>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-dismissible alert-danger mb-3">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-dismissible alert-danger mb-3">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-dismissible alert-success mb-3">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="component_form_group">
                                    <div class="form-group">
                                        <label for="name" class="control-label" data-lang="auth.full_name">{{ __('auth.full_name') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" required>
                                    </div>
                                </div>
                                <div class="component_form_group">
                                    <div class="form-group">
                                        <label for="username" class="control-label" data-lang="auth.username">{{ __('auth.username') }}</label>
                                        <input type="text" class="form-control" id="username" value="{{ old('username') }}" name="username" required minlength="3" maxlength="20" pattern="[a-z0-9_]+">
                                    </div>
                                </div>
                                <div class="component_form_group">
                                    <div class="form-group">
                                        <label for="email" class="control-label" data-lang="auth.email">{{ __('auth.email') }}</label>
                                        <input type="email" class="form-control" id="email" value="{{ old('email') }}" name="email" required>
                                    </div>
                                </div>
                                <div class="component_form_group">
                                    <div class="form-group">
                                        <label for="password" class="control-label" data-lang="auth.password">{{ __('auth.password') }}</label>
                                        <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                    </div>
                                </div>
                                <div class="component_form_group">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="control-label" data-lang="auth.confirm_password">{{ __('auth.confirm_password') }}</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8">
                                    </div>
                                </div>
                                <div class="component_form_group">
                                    <div class="form-group form-group__checkbox">
                                        <label class="form-group__checkbox-label">
                                            <input type="checkbox" name="agree_terms" value="1" id="agree_terms" {{ old('agree_terms') ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label for="agree_terms" class="form-group__label-title" data-lang="auth.agree_terms">{{ __('auth.agree_terms') }}</label>
                                    </div>
                                </div>
                                <div class="component_button_submit">
                                    <button type="submit" class="btn btn-block btn-big-primary" data-lang="auth.sign_up">{{ __('auth.sign_up') }}</button>
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="{{ route('login') }}" data-lang="auth.already_have_account">{{ __('auth.already_have_account') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/99gttjw1i1l6jmws.js') }}"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/hecwkrtjf5h4271l.js"></script>
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/ap5ifcinp3jk13sr.js') }}"></script>
<script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/f7lw81wrmhzxhpb3.js') }}"></script>
<script type="text/javascript">
    window.modules.layouts = <?php echo json_encode(['theme_id' => 23, 'auth' => 0, 'live' => true, 'csrftoken' => csrf_token()]); ?>;
</script>
<script type="text/javascript">window.modules.select = [];</script>
<script>
(function() {
    var lang = localStorage.getItem('data-lang') || 'vi';
    fetch('/lang/' + lang + '.json')
        .then(function(r) { return r.ok ? r.json() : null; })
        .then(function(t) {
            if (!t) return;
            document.querySelectorAll('[data-lang]').forEach(function(el) {
                var key = el.getAttribute('data-lang');
                if (t[key] !== undefined) el.textContent = t[key];
            });
            document.querySelectorAll('[data-lang-placeholder]').forEach(function(el) {
                var key = el.getAttribute('data-lang-placeholder');
                if (t[key] !== undefined) el.placeholder = t[key];
            });
            if (t['auth.sign_up']) {
                document.title = t['auth.sign_up'] + ' - ' + document.title.split(' - ').slice(1).join(' - ');
            }
        })
        .catch(function() {});
})();
</script>
@if(!empty($settings['google_client_id']))
    <script src="https://accounts.google.com/gsi/client" async defer></script>
@endif
</body>
</html>
