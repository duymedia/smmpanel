(function (window, $) {
    'use strict';

    if (!$ || typeof window._settings !== 'object' || !window._settings.on || !window._settings.on.click) {
        return;
    }

    var settings = window._settings;
    var inheritedInit = typeof settings.init === 'function' ? settings.init : null;
    var originalChangePassword = settings.on.click.changePassword;

    function optionContent(option) {
        if (!option.element || (option.element.getAttribute('style') || '').includes('display: none')) {
            return option.element ? null : option.text;
        }

        return option.element.getAttribute('data-content') || option.text;
    }

    function configureSelect($element, options) {
        if (!$element.length) {
            return;
        }

        if ($element.hasClass('select2-hidden-accessible')) {
            $element.select2('destroy');
        }

        $element.select2(options);
    }

    function showError(error, fallback) {
        var response = error && (error.responseJSON || error);
        var message = response && (response.language || response.message || response.error);

        app.alert(message || fallback, 'danger');
    }

    async function save(url, data, fallback) {
        try {
            var response = await $.post(url, data);
            if (response.success === false || response.error) {
                throw response;
            }

            window.location.reload();
        } catch (error) {
            showError(error, fallback);
        }
    }

    function responseMessage(response, fallback) {
        return (response && (response.language || response.message || response.success || response.error)) || fallback;
    }

    settings.init = function () {
        if (inheritedInit) {
            inheritedInit.call(settings);
        }

        var richSelect = {
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: optionContent,
            templateSelection: optionContent,
            width: '100%'
        };

        configureSelect($('#sl-language'), richSelect);
        configureSelect($('#sl-currency'), richSelect);
        configureSelect($('#sl-timezone'), { width: '100%' });
        configureSelect($('#sl-appearance'), {
            minimumResultsForSearch: -1,
            width: '100%'
        });

        $('#sl-appearance')
            .val(localStorage.getItem('theme') || 'light')
            .trigger('change.select2')
            .off('change.settingsAppearance')
            .on('change.settingsAppearance', function () {
                var theme = this.value;

                ['data-bs-theme', 'data-bs-theme-mode', 'data-theme'].forEach(function (attribute) {
                    document.documentElement.setAttribute(attribute, theme);
                });

                localStorage.setItem('theme', theme);
                document.cookie = 'data-bs-theme=' + theme + ';path=/;max-age=2592000;SameSite=Lax';
            });

        settings.on.change = settings.on.change || {};
        settings.on.change.language = function (element) {
            var $element = $(element);
            localStorage.setItem('data-lang', element.value);
            localStorage.setItem('language', element.value);

            return save($element.data('update-url'), { lang: element.value }, 'Unable to update language');
        };
        settings.on.change.currency = function (element) {
            var option = element.options[element.selectedIndex];

            return save($(element).data('update-url'), {
                currency_code: option.dataset.code || element.value,
                currency_symbol: option.dataset.symbol || '',
                currency_name: option.dataset.name || ''
            }, 'Unable to update currency');
        };
        settings.on.change.timezone = function (element) {
            return save($(element).data('update-url'), { timezone: element.value }, 'Unable to update timezone');
        };

        settings.on.click.changePassword = async function () {
            var email = $('#ipt-email').val().trim();
            var phone = $('#ipt-phone').val().trim();
            var currentPassword = $('#ipt-current-pass').val().trim();
            var newPassword = $('#ipt-new-pass').val().trim();
            var confirmPassword = $('#ipt-confirm-pass').val().trim();
            var isChangingPassword = currentPassword || newPassword || confirmPassword;

            if (!$('#ipt-email').length || !$('#ipt-phone').length) {
                return originalChangePassword.call(settings.on.click);
            }

            try {
                var information = await app.ajax('Account-changeEmailPhone', {
                    email: email,
                    phone: phone
                });

                if (information.error) {
                    throw information;
                }

                if (isChangingPassword) {
                    var password = await app.ajax('Account-changePassword', {
                        oldp: currentPassword,
                        newp: newPassword,
                        cnewp: confirmPassword
                    });

                    if (password.error) {
                        throw password;
                    }

                    $('#ipt-current-pass, #ipt-new-pass, #ipt-confirm-pass').val('');
                    app.alert(responseMessage(password, 'Information updated successfully'));
                    return;
                }

                app.alert(responseMessage(information, 'Information updated successfully'));
            } catch (error) {
                showError(error, 'Unable to update account settings');
            }
        };

        $('#sl-language')
            .off('change.settingsLanguage')
            .on('change.settingsLanguage', function () {
                settings.on.change.language(this);
            });
        $('#sl-currency')
            .off('change.settingsCurrency')
            .on('change.settingsCurrency', function () {
                settings.on.change.currency(this);
            });
        $('#sl-timezone')
            .off('change.settingsTimezone')
            .on('change.settingsTimezone', function () {
                settings.on.change.timezone(this);
            });
    };
})(window, window.jQuery);
