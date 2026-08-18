<!DOCTYPE html>
<html id="theme_23" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title data-lang="auth.reset_password">{{ __('auth.reset_password') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ $settings['keywords'] ?? '' }}">
    <meta name="description" content="{{ $settings['description'] ?? '' }}">
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
    <link rel="stylesheet" type="text/css" href="https://storage.perfectcdn.com/global/qi2w4eotlr7z5sa9.css">
    <link rel="stylesheet" type="text/css" href="https://storage.perfectcdn.com/hx1lyd/mdo8pos315ygpcmz.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <script>window.modules = {};</script>
</head>
<body class="body body-public">

<div id="block_122">
    <div class="block-bg"></div>
    <div class="container-fluid">
        <div class="reset-password-form">
            <div class="row reset-password-form__alignment">
                <div class="col-lg-4">
                    <div class="component_card">
                        <div class="card">
                            <form method="post" action="{{ route('password.email') }}">
                                @csrf

                                @if(session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="component_form_group">
                                    <div class="form-group">
                                        <label for="email" class="control-label" data-lang="auth.email">{{ __('auth.email') }}</label>
                                        <input type="email" class="form-control" id="email" value="{{ old('email') }}" name="email" required
                                            placeholder="{{ __('auth.email') }}" data-lang-placeholder="auth.email">
                                    </div>
                                    <div class="component_button_submit">
                                        <button type="submit" class="btn btn-block btn-big-primary" data-lang="auth.send">{{ __('auth.send') }}</button>
                                    </div>
                                </div>

                                <div class="mt-3 text-center">
                                    <a href="{{ route('login') }}" data-lang="auth.back_to_login">{{ __('auth.back_to_login') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://storage.perfectcdn.com/global/niz1noemjyzfu7f9.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/hecwkrtjf5h4271l.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/9slt7wawt5z76g0n.js"></script>
<script type="text/javascript" src="https://storage.perfectcdn.com/global/zapdpw5dch3izybt.js"></script>
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
            if (t['auth.reset_password']) {
                document.title = t['auth.reset_password'] + ' - ' + document.title.split(' - ').slice(1).join(' - ');
            }
        })
        .catch(function() {});
})();
</script>
</body>
</html>
