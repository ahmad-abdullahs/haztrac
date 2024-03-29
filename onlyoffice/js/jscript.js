﻿/**
 *
 * (c) Copyright Ascensio System SIA 2021
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

        if (typeof jQuery != "undefined") {
    jq = jQuery.noConflict();
    responseDataG = {};
    user = getUrlVars()["user"];
    if ("" != user && undefined != user)
        jq("#user").val(user);
    else
        user = jq("#user").val();

    jq(document).on("change", "#user", function () {
        window.location = "?user=" + jq(this).val();
    });

    jq(function () {
        jq('#fileupload').fileupload({
            dataType: 'json',
            add: function (e, data) {
                jq(".error").removeClass("error");
                jq(".done").removeClass("done");
                jq(".current").removeClass("current");
                jq("#step1").addClass("current");
                jq("#mainProgress .error-message").hide().find("span").text("");
                jq("#blockPassword").hide();
                jq("#mainProgress").removeClass("embedded");
                jq("#uploadFileName").text("");

                jq.blockUI({
                    theme: true,
                    title: "File upload" + "<div class=\"dialog-close\"></div>",
                    message: jq("#mainProgress"),
                    overlayCSS: {"background-color": "#aaa"},
                    themedCSS: {width: "539px", top: "20%", left: "50%", marginLeft: "-269px"}
                });
                jq("#reloadPage").addClass("disable");
                jq("#openRecord").addClass("disable");
                jq("#beginEdit, #beginView, #beginEmbedded").addClass("disable");

                data.submit().done(function (responseData) {
                    responseDataG = responseData;
                    if (responseData.id !== undefined) {
                        var messageString = parent.SUGAR.App.lang.get('LBL_RECORD_SAVED_SUCCESS', 'Doc_Manager', {
                            'module': 'Doc_Manager',
                            'moduleSingularLower': parent.SUGAR.App.lang.getModuleName('Doc_Manager'),
                            'id': responseData.id,
                            'name': responseData.name,
                        });
                        parent.SUGAR.App.alert.show('create-success', {
                            level: 'success',
                            messages: messageString,
                            autoClose: true,
                            autoCloseDelay: 10000,
                            onLinkClick: function () {
                                app.alert.dismiss('create-success');
                            }
                        });
                    }
                });
            },
            always: function (e, data) {
                if (!jq("#mainProgress").is(":visible")) {
                    return;
                }
                var response = data.result;
                if (response.hasOwnProperty("error")) {
                    jq(".current").removeClass("current");
                    jq(".step:not(.done)").addClass("error");
                    jq("#mainProgress .error-message").show().find("span").text(response.error);
                    jq('#hiddenFileName').val("");
                    return;
                }

                jq("#hiddenFileName").val(response.filename);
                jq("#uploadFileName").text(response.filename);
                jq("#uploadFileName").addClass(response.documentType);

                jq("#step1").addClass("done").removeClass("current");

                checkConvert();
            }
        });

        initSelectors();
    });

    var timer = null;
    var checkConvert = function (fileUri, filePass) {
        if (timer != null) {
            clearTimeout(timer);
        }

        if (!jq("#mainProgress").is(":visible")) {
            return;
        }

        var fileName = jq("#hiddenFileName").val();
        var posExt = fileName.lastIndexOf('.');
        posExt = 0 <= posExt ? fileName.substring(posExt).trim().toLowerCase() : '';

        if (ConverExtList.indexOf(posExt) == -1) {
            loadScripts();
            return;
        }

        if (jq("#checkOriginalFormat").is(":checked")) {
            loadScripts();
            return;
        }
        jq("#step2").addClass("current");
        jq("#filePass").val("");

        timer = setTimeout(function () {
            var requestAddress = "webeditor-ajax.php?type=convert";

            jq.ajax({
                async: true,
                contentType: "text/xml",
                type: "post",
                dataType: "json",
                data: JSON.stringify({filename: fileName, fileUri: fileUri || "", filePass: filePass}),
                url: requestAddress,
                complete: function (data) {
                    var responseText = data.responseText;
                    try {
                        var response = jq.parseJSON(responseText);
                    } catch (e) {
                        response = {error: e};
                    }

                    if (response.error) {
                        if (response.error.includes("Incorrect password")) {
                            jq(".current").removeClass("current");
                            jq("#step2").addClass("error");
                            jq("#blockPassword").show();
                            if (filePass) {
                                jq("#filePass").addClass("errorInput");
                                jq(".errorPass").text("The password is incorrect, please try again.");
                            }
                            return;
                        } else {
                            jq(".current").removeClass("current");
                            jq(".step:not(.done)").addClass("error");
                            jq("#mainProgress .error-message").show().find("span").text(response.error);
                            jq('#hiddenFileName').val("");
                            return;
                        }
                    }

                    jq("#hiddenFileName").val(response.filename);

                    if (response.step < 100) {
                        checkConvert(response.fileUri, filePass);
                    } else {
                        jq("#step2").addClass("done").removeClass("current");
                        loadScripts();
                    }
                }
            });
        }, 1000);
    };

    var loadScripts = function () {
        if (!jq("#mainProgress").is(":visible")) {
            return;
        }
        jq("#step3").addClass("current");

        if (jq("#loadScripts").is(":empty")) {
            var urlScripts = jq("#loadScripts").attr("data-docs");
            var frame = '<iframe id="iframeScripts" width=1 height=1 style="position: absolute; visibility: hidden;" ></iframe>';
            jq("#loadScripts").html(frame);
            document.getElementById("iframeScripts").onload = onloadScripts;
            jq("#loadScripts iframe").attr("src", urlScripts);
        } else {
            onloadScripts();
        }
    };

    var onloadScripts = function () {
        if (!jq("#mainProgress").is(":visible")) {
            return;
        }
        jq("#step3").addClass("done").removeClass("current");
        jq("#reloadPage").removeClass("disable");
        jq("#openRecord").removeClass("disable");
        jq("#beginView, #beginEmbedded").removeClass("disable");

        var fileName = jq("#hiddenFileName").val();
        var posExt = fileName.lastIndexOf('.');
        posExt = 0 <= posExt ? fileName.substring(posExt).trim().toLowerCase() : '';

        if (EditedExtList.indexOf(posExt) != -1) {
            jq("#beginEdit").removeClass("disable");
        }
    };

    var initSelectors = function () {
        var langSel = jq("#language");

        function getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                    ));
            return matches ? decodeURIComponent(matches[1]) : null;
        }
        function setCookie(name, value) {
            document.cookie = name + "=" + value + "; expires=" + new Date(Date.now() + 1000 * 60 * 60 * 24 * 7).toUTCString(); //week
        }

        var langId = getCookie("ulang");
        if (langId)
            langSel.val(langId);

        langSel.on("change", function () {
            setCookie("ulang", langSel.val());
        });
    };

    jq(document).on("click", "#enterPass", function () {
        var filePass = jq("#filePass").val();
        if (filePass) {
            jq("#step2").removeClass("error");
            jq("#blockPassword").hide();
            checkConvert(null, filePass);
        } else {
            jq("#filePass").addClass("errorInput");
            jq(".errorPass").text("Password can't be blank.");
        }
    });

    jq(document).on("click", "#skipPass", function () {
        jq("#blockPassword").hide();
        loadScripts();
    });

    jq(document).on("click", "#beginEdit:not(.disable)", function () {
        var fileId = encodeURIComponent(jq('#hiddenFileName').val());
        var url = "doceditor.php?fileID=" + fileId + "&user=" + user;
        window.open(url, "_blank");
        jq('#hiddenFileName').val("");
        jq.unblockUI();
        document.location.reload();
    });

    jq(document).on("click", "#beginView:not(.disable)", function () {
        var fileId = encodeURIComponent(jq('#hiddenFileName').val());
        var url = "doceditor.php?action=view&fileID=" + fileId + "&user=" + user;
        window.open(url, "_blank");
        jq('#hiddenFileName').val("");
        jq.unblockUI();
        document.location.reload();
    });

    jq(document).on("click", "#reloadPage:not(.disable)", function () {
        jq('#hiddenFileName').val("");
        jq.unblockUI();
        document.location.reload();
    });

    jq(document).on("click", "#openRecord:not(.disable)", function () {
        jq('#hiddenFileName').val("");
        jq.unblockUI();
        var url = "#Doc_Manager" + "/" + responseDataG.id;
        parent.SUGAR.App.router.navigate(url, {trigger: true, replace: true});
    });

    jq(document).on("click", "#beginEmbedded:not(.disable)", function () {
        var fileId = encodeURIComponent(jq('#hiddenFileName').val());
        var url = "doceditor.php?type=embedded&fileID=" + fileId + "&user=" + user;

        jq("#mainProgress").addClass("embedded");
        jq("#beginEmbedded").addClass("disable");

        jq("#embeddedView").attr("src", url);
    });

    jq(document).on("click", ".reload-page", function () {
        setTimeout(function () {
            document.location.reload();
        }, 1000);
        return true;
    });

    jq(document).on("mouseup", ".reload-page", function (event) {
        if (event.which == 2) {
            setTimeout(function () {
                document.location.reload();
            }, 1000);
        }
        return true;
    });

    jq(document).on("click", "#cancelEdit, .dialog-close", function () {
        jq('#hiddenFileName').val("");
        jq("#embeddedView").attr("src", "");
        jq.unblockUI();
    });

    jq(document).on("click", ".delete-file", function () {
        var fileName = jq(this).attr("data");

        var requestAddress = "webeditor-ajax.php?type=delete&fileName=" + fileName;

        jq.ajax({
            async: true,
            contentType: "text/xml",
            type: "get",
            url: requestAddress,
            complete: function (data) {
                document.location.reload();
            }
        });
    });

    jq(document).on("click", "#createSample", function () {
        jq(".try-editor").each(function () {
            var href = jq(this).attr("href");
            if (jq("#createSample").is(":checked")) {
                href += "&sample=true";
            } else {
                href = href.replace("&sample=true", "");
            }
            jq(this).attr("href", href);
        });
    });

    jq(".info").mouseover(function (event) {
        var target = event.target;
        var id = target.dataset.id ? target.dataset.id : target.id;
        var tooltip = target.dataset.tooltip;

        jq("<div class='tooltip'>" + tooltip + "<div class='arrow'></div></div>").appendTo("body");

        var top = jq("#" + id).offset().top + jq("#" + id).outerHeight() / 2 - jq("div.tooltip").outerHeight() / 2;
        var left = jq("#" + id).offset().left + jq("#" + id).outerWidth() + 20;
        jq("div.tooltip").css({"top": top, "left": left});
    }).mouseout(function () {
        jq("div.tooltip").remove();
    });
}

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
;
