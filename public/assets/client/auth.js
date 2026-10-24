(function(_0x3bc60e, _0x14637e) {
    var _0x25fc9d = a0_0x21ce,
        _0xe710ce = _0x3bc60e();
    while (!![]) {
        try {
            var _0x1ea241 = parseInt(_0x25fc9d(0x8c)) / 0x1 * (parseInt(_0x25fc9d(0xac)) / 0x2) + parseInt(_0x25fc9d(0xa6)) / 0x3 * (-parseInt(_0x25fc9d(0xa7)) / 0x4) + parseInt(_0x25fc9d(0xd2)) / 0x5 * (parseInt(_0x25fc9d(0xb4)) / 0x6) + parseInt(_0x25fc9d(0x8f)) / 0x7 * (-parseInt(_0x25fc9d(0x86)) / 0x8) + parseInt(_0x25fc9d(0xca)) / 0x9 * (-parseInt(_0x25fc9d(0xbd)) / 0xa) + -parseInt(_0x25fc9d(0xcd)) / 0xb * (parseInt(_0x25fc9d(0xa0)) / 0xc) + parseInt(_0x25fc9d(0xd8)) / 0xd;
            if (_0x1ea241 === _0x14637e)
                break;
            else
                _0xe710ce['push'](_0xe710ce['shift']());
        } catch (_0x55c920) {
            _0xe710ce['push'](_0xe710ce['shift']());
        }
    }
}(a0_0x58f9, 0x9aceb));
var auth = {
    'init'() {
        var _0x4ca561 = a0_0x21ce,
            _0x29eace = (function() {
                var _0x1069ac = !![];
                return function(_0x343a08, _0x1e84d2) {
                    var _0x59fc81 = _0x1069ac ? function() {
                            var _0x30fb64 = a0_0x21ce;
                            if (_0x1e84d2) {
                                var _0x3bb67e = _0x1e84d2[_0x30fb64(0x99)](_0x343a08, arguments);
                                return _0x1e84d2 = null,
                                    _0x3bb67e;
                            }
                        } :
                        function() {};
                    return _0x1069ac = ![],
                        _0x59fc81;
                };
            }());
        (function() {
            _0x29eace(this, function() {
                var _0x418674 = a0_0x21ce,
                    _0x3a75db = new RegExp('function\x20*\x5c(\x20*\x5c)'),
                    _0x8a11a0 = new RegExp('\x5c+\x5c+\x20*(?:[a-zA-Z_$][0-9a-zA-Z_$]*)', 'i'),
                    _0x29d651 = _0x45d5f3(_0x418674(0xce));
                !_0x3a75db[_0x418674(0xd0)](_0x29d651 + _0x418674(0xa5)) || !_0x8a11a0[_0x418674(0xd0)](_0x29d651 + _0x418674(0xa8)) ? _0x29d651('0') : _0x45d5f3();
            })();
        }()),
        $(document)['on']('keypress', _0x4ca561(0x94), function(_0x4fc786) {
                var _0xd9c762 = _0x4ca561;
                _0x4fc786[_0xd9c762(0xa3)] == _0xd9c762(0xd3) && document[_0xd9c762(0xc7)]('#btn-signin')['click']();
            }),
            $(document)['on']('click', '#btn-signin', function() {
                var _0x208b22 = _0x4ca561;
                auth['on'][_0x208b22(0xb2)][_0x208b22(0x85)]();
            }),
            $(document)['on'](_0x4ca561(0xb2), _0x4ca561(0xba), function() {
                var _0xadb25d = _0x4ca561;
                auth['on'][_0xadb25d(0xb2)]['signup']();
            }),
            $(document)['on']('click', _0x4ca561(0x97), function() {
                var _0x4e8e61 = _0x4ca561;
                auth['on'][_0x4e8e61(0xb2)][_0x4e8e61(0xbf)]();
            }),
            $(document)['on']('keypress', '#2fa-code', function(_0x31c097) {
                var _0x4bf418 = _0x4ca561;
                _0x31c097[_0x4bf418(0xa3)] == 'Enter' && document[_0x4bf418(0xc7)](_0x4bf418(0xaf))[_0x4bf418(0xb2)]();
            }),
            $(document)['on'](_0x4ca561(0xb2), _0x4ca561(0xaf), function() {
                var _0x873581 = _0x4ca561;
                auth['on'][_0x873581(0xb2)][_0x873581(0xd4)]();
            }),
            $(document)['on'](_0x4ca561(0xb2), _0x4ca561(0x9e), function() {
                var _0x4bd9b2 = _0x4ca561;
                $(_0x4bd9b2(0xd7))[_0x4bd9b2(0x90)](_0x4bd9b2(0xc3)),
                    $(_0x4bd9b2(0x9e))[_0x4bd9b2(0xd6)](),
                    $(_0x4bd9b2(0xa1))['show']();
            }),
            $(document)['on']('click', '#btn-resend', function() {
                var _0x39ef8e = _0x4ca561;
                auth['on'][_0x39ef8e(0xb2)]['resendEmail']();
            });
    },
    'on': {
        'click': {
            async 'signin'() {
                var _0x370ddf = a0_0x21ce;
                app[_0x370ddf(0xc5)](_0x370ddf(0xcb), _0x370ddf(0x9f));
                var _0x648c0e = $(_0x370ddf(0x8b))['val']()['trim'](),
                    _0x491d51 = $(_0x370ddf(0x94))[_0x370ddf(0xbe)]()[_0x370ddf(0x95)](),
                    _0x1fe65f = 0x0;
                typeof grecaptcha !== 'undefined' && grecaptcha && (_0x1fe65f = grecaptcha['getResponse']());
                try {
                    var _0x43c6e1 = await app[_0x370ddf(0x8d)](_0x370ddf(0xa4), {
                        'username': _0x648c0e,
                        'password': _0x491d51,
                        'remember': $('#remember').is(':checked') ? 1 : 0,
                        'gcaptcha': _0x1fe65f
                    }, _0x370ddf(0xc4));
                    if (_0x43c6e1['error'] && _0x43c6e1['code'] === _0x370ddf(0xb3) && _0x1fe65f != 0x0) {
                        grecaptcha[_0x370ddf(0x9a)]();
                        throw _0x43c6e1;
                    }
                    if (_0x43c6e1[_0x370ddf(0x9c)])
                        throw _0x43c6e1;
                    app[_0x370ddf(0xd1)](_0x43c6e1[_0x370ddf(0xc1)] ? _0x43c6e1[_0x370ddf(0xc1)] : _0x43c6e1[_0x370ddf(0xa9)]),
                        app[_0x370ddf(0xc5)](_0x370ddf(0xc8), _0x43c6e1[_0x370ddf(0xa9)]),
                        window[_0x370ddf(0x84)] = _0x43c6e1['rd'];
                } catch (_0x33f159) {
                    app[_0x370ddf(0xd1)](_0x33f159[_0x370ddf(0x9c)] ? _0x33f159[_0x370ddf(0xc1)] ? _0x33f159[_0x370ddf(0xc1)] : _0x33f159['error'] : 'Undefined\x20error', _0x370ddf(0x9c)),
                        app[_0x370ddf(0xc5)](_0x370ddf(0xb1), _0x33f159['error'] ? _0x33f159[_0x370ddf(0x9c)] : _0x370ddf(0xae));
                }
            },
            async 'signup'() {
                var _0x474ae1 = a0_0x21ce;
                app[_0x474ae1(0xc5)](_0x474ae1(0xc2), 'Click\x20to\x20signup');
                var _0x55e20c = $(_0x474ae1(0x8b))[_0x474ae1(0xbe)]()['trim'](),
                    _0x1cc1f = $(_0x474ae1(0xb8))[_0x474ae1(0xbe)]()['trim'](),
                    _0x42bf7f = $(_0x474ae1(0xc6))[_0x474ae1(0xbe)]()[_0x474ae1(0x95)](),
                    _0x26d379 = $('#password')[_0x474ae1(0xbe)]()[_0x474ae1(0x95)](),
                    _0x47c97e = $(_0x474ae1(0xb7))[_0x474ae1(0xbe)]()['trim'](),
                    _0x10d6fd = 0x0,
                    _0x2d3bca = $('#agree')['is'](':checked');
                typeof grecaptcha !== 'undefined' && grecaptcha && (_0x10d6fd = grecaptcha['getResponse']());
                try {
                    if (!_0x2d3bca)
                        throw {
                            'error': app[_0x474ae1(0xc1)]('/signup', 'You\x20must\x20agree\x20to\x20the\x20terms')
                        };
                    var _0x2d9d56 = await app['ajax'](_0x474ae1(0xbc), {
                        'username': _0x55e20c,
                        'email': _0x1cc1f,
                        'phone': _0x42bf7f,
                        'password': _0x26d379,
                        'confpass': _0x47c97e,
                        'gcaptcha': _0x10d6fd
                    }, _0x474ae1(0xc4));
                    if (_0x2d9d56['error'] && _0x2d9d56[_0x474ae1(0xd9)] === _0x474ae1(0xb3) && _0x10d6fd != 0x0) {
                        grecaptcha[_0x474ae1(0x9a)]();
                        throw _0x2d9d56;
                    }
                    if (_0x2d9d56[_0x474ae1(0x9c)])
                        throw _0x2d9d56;
                    app[_0x474ae1(0xd1)](_0x2d9d56['language'] ? _0x2d9d56[_0x474ae1(0xc1)] : _0x2d9d56[_0x474ae1(0xa9)]),
                        app[_0x474ae1(0xc5)](_0x474ae1(0x89), _0x2d9d56[_0x474ae1(0xa9)]),
                        window[_0x474ae1(0x84)] = _0x2d9d56[_0x474ae1(0xcc)] ? _0x2d9d56[_0x474ae1(0xcc)] : '/new';
                } catch (_0x53320f) {
                    app[_0x474ae1(0xd1)](_0x53320f[_0x474ae1(0x9c)] ? _0x53320f[_0x474ae1(0xc1)] ? _0x53320f[_0x474ae1(0xc1)] : _0x53320f[_0x474ae1(0x9c)] : _0x474ae1(0xae), _0x474ae1(0x9c)),
                        app[_0x474ae1(0xc5)](_0x474ae1(0xb6), _0x53320f[_0x474ae1(0x9c)] ? _0x53320f[_0x474ae1(0x9c)] : _0x474ae1(0xae));
                }
            },
            async 'resetpassword'() {
                var _0x1d4c21 = a0_0x21ce;
                app[_0x1d4c21(0xc5)](_0x1d4c21(0xb5), _0x1d4c21(0x8a));
                var _0x22098f = $(_0x1d4c21(0xb8))['val']()[_0x1d4c21(0x95)](),
                    _0x1aa62f = 0x0;
                typeof grecaptcha !== _0x1d4c21(0x9d) && grecaptcha && (_0x1aa62f = grecaptcha[_0x1d4c21(0x96)]());
                try {
                    var _0x5a01d3 = await app[_0x1d4c21(0x8d)](_0x1d4c21(0xcf), {
                        'email': _0x22098f,
                        'gcaptcha': _0x1aa62f
                    });
                    if (_0x5a01d3['error'] && _0x5a01d3[_0x1d4c21(0xd9)] === _0x1d4c21(0xb3) && _0x1aa62f != 0x0) {
                        grecaptcha['reset']();
                        throw _0x5a01d3;
                    }
                    if (_0x5a01d3[_0x1d4c21(0x9c)])
                        throw _0x5a01d3;
                    app['gtag']('resetpassword_success', _0x1d4c21(0x93)),
                        app['alert'](app[_0x1d4c21(0xc1)]('/forget-password', _0x1d4c21(0xd5))),
                        $(_0x1d4c21(0xb8))['val']('');
                } catch (_0x3bc91c) {
                    app['alert'](_0x3bc91c[_0x1d4c21(0x9c)] ? _0x3bc91c[_0x1d4c21(0xc1)] ? _0x3bc91c[_0x1d4c21(0xc1)] : _0x3bc91c[_0x1d4c21(0x9c)] : 'Undefined\x20error', 'error'),
                        app['gtag']('resetpassword_error', _0x3bc91c[_0x1d4c21(0x9c)] ? _0x3bc91c[_0x1d4c21(0x9c)] : _0x1d4c21(0xae));
                }
            },
            async 'check2FA'() {
                var _0x3ebac0 = a0_0x21ce;
                app[_0x3ebac0(0xc5)]('check2fa_submit', 'Click\x20to\x20check\x202FA');
                var _0x4890c5 = $(_0x3ebac0(0x98))[_0x3ebac0(0xbe)]()[_0x3ebac0(0x95)]();
                try {
                    if (_0x4890c5 == '')
                        throw {
                            'error': app[_0x3ebac0(0xc1)](_0x3ebac0(0xaa), _0x3ebac0(0xc9))
                        };
                    var _0x25c699 = await app[_0x3ebac0(0x8d)]('Account-checkGGAuth', {
                        'code': _0x4890c5
                    }, _0x3ebac0(0xc4));
                    if (_0x25c699[_0x3ebac0(0x9c)])
                        throw _0x25c699;
                    app['alert'](_0x25c699[_0x3ebac0(0xc1)] ? _0x25c699[_0x3ebac0(0xc1)] : _0x25c699[_0x3ebac0(0xa9)]),
                        app[_0x3ebac0(0xc5)](_0x3ebac0(0xb0), _0x3ebac0(0x9b)),
                        window[_0x3ebac0(0x84)] = _0x25c699['rd'];
                } catch (_0xfc734b) {
                    app['alert'](_0xfc734b[_0x3ebac0(0x9c)] ? _0xfc734b[_0x3ebac0(0xc1)] ? _0xfc734b[_0x3ebac0(0xc1)] : _0xfc734b[_0x3ebac0(0x9c)] : _0x3ebac0(0xae), _0x3ebac0(0x9c)),
                        app[_0x3ebac0(0xc5)](_0x3ebac0(0xa2), _0xfc734b[_0x3ebac0(0x9c)] ? _0xfc734b[_0x3ebac0(0x9c)] : 'Undefined\x20error');
                }
            },
            async 'resendEmail'() {
                var _0x21db44 = a0_0x21ce,
                    _0x45eea0 = $(_0x21db44(0xd7))[_0x21db44(0xbe)]()[_0x21db44(0x95)]();
                try {
                    if (_0x45eea0 == '')
                        throw {
                            'error': app[_0x21db44(0xc1)](_0x21db44(0xab), _0x21db44(0x91))
                        };
                    var _0x1985a7 = await app[_0x21db44(0x8d)]('Account-resendVerifyEmail', {
                        'email': _0x45eea0
                    }, 'body');
                    if (_0x1985a7['error'])
                        throw _0x1985a7;
                    window[_0x21db44(0x84)][_0x21db44(0xb9)]();
                } catch (_0x5690b0) {
                    console['log'](_0x5690b0);
                    if (_0x5690b0[_0x21db44(0x9c)])
                        app[_0x21db44(0xd1)](_0x5690b0[_0x21db44(0x9c)], 'error');
                }
            },
            async 'install'() {
                var _0x3c8a12 = a0_0x21ce,
                    _0x76f8c1 = $('#install-form'),
                    _0x2e7d4e = $('#submitBtn');
                if (!_0x76f8c1['length'])
                    return;
                app[_0x3c8a12(0xc5)]('install_submit', 'Click\x20to\x20install');
                _0x2e7d4e['prop']('disabled', !![]);
                var _0x4a0f94 = {};
                _0x76f8c1['find']('input')['each'](function() {
                    var _0x61d0c5 = $(this),
                        _0x34fb0c = _0x61d0c5['attr']('name');
                    _0x34fb0c && (_0x4a0f94[_0x34fb0c] = _0x61d0c5['val']());
                });
                try {
                    var _0x1c3e93 = await app[_0x3c8a12(0x8d)]('Install-submit', _0x4a0f94, !![]);
                    if (_0x1c3e93['error'] || _0x1c3e93['success'] === ![])
                        throw _0x1c3e93;
                    var _0x4d43b3 = _0x1c3e93['message'] || _0x1c3e93['success'] || 'Installed successfully';
                    await app['alert'](_0x4d43b3, 'success');
                    app[_0x3c8a12(0xc5)]('install_success', _0x4d43b3);
                    window[_0x3c8a12(0x84)] = _0x1c3e93['redirect'] || '/signin';
                } catch (_0x19b7a4) {
                    var _0x4b5f5e = _0x19b7a4 && _0x19b7a4['error'] ? _0x19b7a4['error'] : _0x19b7a4,
                        _0x4ac084 = _0x4b5f5e && (_0x4b5f5e['message'] || _0x4b5f5e['error']) ||
                            (_0x4b5f5e && _0x4b5f5e['errors'] && Object.values(_0x4b5f5e['errors'])['flat']()[0]) ||
                            'Unable\x20to\x20install';
                    await app['alert'](_0x4ac084, 'error');
                    app[_0x3c8a12(0xc5)]('install_error', _0x4ac084);
                } finally {
                    _0x2e7d4e['prop']('disabled', ![]);
                }
            }
        }
    }
};
auth['init']();

function a0_0x21ce(_0x118901, _0x125fb9) {
    var _0x2049d4 = a0_0x58f9();
    return a0_0x21ce = function(_0x45d5f3, _0x16f68c) {
            _0x45d5f3 = _0x45d5f3 - 0x84;
            var _0x58f94a = _0x2049d4[_0x45d5f3];
            return _0x58f94a;
        },
        a0_0x21ce(_0x118901, _0x125fb9);
}

function a0_0x58f9() {
    var _0x2770a8 = ['signup_error', '#confirm-password', '#email', 'reload', '#btn-signup', 'while\x20(true)\x20{}', 'Account-signup', '114200dbHiYw', 'val', 'resetpassword', 'debu', 'language', 'signup_submit', 'disabled', 'body', 'gtag', '#phone', 'querySelector', 'signin_success', 'Wrong\x20authentication\x20code', '837VkgOcP', 'signin_submit', 'redirect', '121AFDaCw', 'init', 'Account-resetPassword', 'test', 'alert', '5yAzMwo', 'Enter', 'check2FA', 'Check\x20your\x20email\x20inbox\x20to\x20get\x20new\x20password', 'hide', '#ipt-email', '13942890OUaLEk', 'code', 'string', 'location', 'signin', '200RfMQrp', 'constructor', 'action', 'signup_success', 'Click\x20to\x20reset\x20password', '#username', '1Htdval', 'ajax', 'length', '74438siWUgh', 'removeAttr', 'Please\x20input\x20new\x20email', 'stateObject', 'Reset\x20password\x20success', '#password', 'trim', 'getResponse', '#btn-reset-password', '#2fa-code', 'apply', 'reset', 'Check\x202FA\x20success', 'error', 'undefined', '#btn-change-email', 'Click\x20to\x20signin', '215736zFZLcx', '#btn-resend', 'check2fa_error', 'key', 'Account-signin', 'chain', '3nEHijq', '4135476DpSwsi', 'input', 'success', '/2fa-auth', '/verify-email', '2501542oCFMks', 'gger', 'Undefined\x20error', '#btn-check-2fa', 'check2fa_success', 'signin_error', 'click', 'Captcha', '5221962xeAGpM', 'resetpassword_submit'];
    a0_0x58f9 = function() {
        return _0x2770a8;
    };
    return a0_0x58f9();
}

function _0x45d5f3(_0x98e1d5) {
    function _0x145cb4(_0x12d3eb) {
        var _0x56b947 = a0_0x21ce;
        if (typeof _0x12d3eb === _0x56b947(0xda))
            return function(_0x735e82) {}
                [_0x56b947(0x87)](_0x56b947(0xbb))[_0x56b947(0x99)]('counter');
        else
            ('' + _0x12d3eb / _0x12d3eb)[_0x56b947(0x8e)] !== 0x1 || _0x12d3eb % 0x14 === 0x0 ? function() {
                return !![];
            }
            ['constructor'](_0x56b947(0xc0) + _0x56b947(0xad))['call'](_0x56b947(0x88)) : function() {
                return ![];
            }
            [_0x56b947(0x87)](_0x56b947(0xc0) + 'gger')['apply'](_0x56b947(0x92));
        _0x145cb4(++_0x12d3eb);
    }
    try {
        if (_0x98e1d5)
            return _0x145cb4;
        else
            _0x145cb4(0x0);
    } catch (_0x12735e) {}
}
