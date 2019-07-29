/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

var submitForm = function (e) {
    e.preventDefault();
    document.getElementById('submit_section').submit();
};

var closeAlert = function(e) {
    var alertWindow = document.getElementsByClassName('alert closeable');
    if (alertWindow[0]) {
        alertWindow[0].style.display = 'none';
    }
};

//need to separate functions because touchpad fires key down events
var onInputKeyDown = function (e) {
    if (e && ((e.keyCode && e.keyCode != 13) || !e.keyCode)) {
        return;
    }
    submitForm(e);
};

var languagesListSelector = function (e) {
    var languageDropdown = document.getElementById('languageDropdown');

    if (!languageDropdown) {
        return;
    }

    if (languageDropdown.style.display === 'none') {
        languageDropdown.style.display = 'block';
    } else {
        languageDropdown.style.display = 'none';
    }
};

var hideLanguagesListSelector = function (e) {
    var languageDropdown = document.getElementById('languageDropdown');

    if (!languageDropdown) {
        return;
    }
    if (languageDropdown.style.display !== 'none') {
        languageDropdown.style.display = 'none';
    }
};

var adjustLanguagesListHeight = function () {
    var languageDropdown = document.getElementById('languageDropdown'),
        footer = document.getElementsByTagName('footer');

    if (!languageDropdown) {
        return;
    }

    languageDropdown.style.maxHeight = Math.round(window.innerHeight - footer[0].clientHeight - 10).toString() + "px";
};

var showLoginForm = function () {
    var ssoForm = document.getElementById('ssoLoginForm'),
        loginForm = document.getElementById('submit_section');

    if (ssoForm) {
        ssoForm.style.display = 'none';
    }

    if (loginForm) {
        loginForm.style.display = 'block';
    }
}

var onDOMContentLoaded = function (e) {
    var loginButton = document.getElementById('submit_btn'),
        closeAlertButton = document.getElementById('close_alert_btn'),
        ssoButton = document.getElementById('sso_btn'),
        tenantInput = document.getElementById('tid'),
        languageButton = document.getElementById('languageButton'),
        content = document.getElementById('content'),
        showLoginFormBtn = document.getElementById('show_login_form_btn');

    if (languageButton) {
        languageButton.onclick = languagesListSelector;
        content.onclick = hideLanguagesListSelector;
    }

    if (closeAlertButton) {
        closeAlertButton.onclick = closeAlert;
    }

    if (loginButton) {
        loginButton.onclick = submitForm;
    }

    if (showLoginFormBtn) {
        showLoginFormBtn.onclick = showLoginForm;
    }

    if (ssoButton && tenantInput) {
        ssoButton.onclick = function () {
            ssoButton.href += "?tid=" + tenantInput.value;
        };
    }
    adjustLanguagesListHeight();
    window.onresize = adjustLanguagesListHeight;
};

document.addEventListener("DOMContentLoaded", onDOMContentLoaded);
