require('./bootstrap');

window.setTimeout(function () {
    $(".alert.calltimer")
        .fadeTo(10000, 0)
        .slideUp(10000, function () {
            $(this).hide();
        });
}, 4000);

$(function () {
    $('#data-table').DataTable({
        processing: true,
        serverSide: false
    });

    $('#datepicker').datepicker();
});
window.MyNotifyJs = function (html, options) {
    if (typeof html != "undefined") {
        toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: false,
            progressBar: false,
            positionClass: "toast-top-right",
            // positionClass: "toast-top-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",

            // tapToDismiss : true,
            // timeOut: 0,
            // extendedTimeOut: 0,
        };
        toastr[options.type](html);
    }
    return;
}
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="site_csrf_token"]').attr("content"),
    },
});

$(document).ready(function () {
    $("#selecctall").click(function (event) {
        if (this.checked) {
            $(".checkCK_id").each(function () {
                this.checked = true;
            });
        } else {
            $(".checkCK_id").each(function () {
                this.checked = false;
            });
        }
    });
});


$(".ajaxCall").on("change", function (e) {
    e.preventDefault();
    fetchData(this);
});


window.fetchData = function (obj) {
    var targetId = $(obj).data("target");
    var ajaxUrl = $(obj).data("action");
    var data = $(obj).val();
    var html = "";
    $.ajax({
        type: "post",
        url: ajaxUrl,
        data: { id: data },
        success: function (data) {
            if ($("#" + targetId).hasClass('select2js')) {
                $("#" + targetId).html('').select2({
                    width: "100%",
                    containerCssClass: "select2js select2js-form-control",
                });
                $("#" + targetId).html(data);
                $("#" + targetId).select2('open');
            } else {
                $("#" + targetId).html(data);
            };
        },
    });
}

window.initializeSelect2AjaxSearchField = function (targetField, Url) {
    $(targetField).select2({
        ajax: {
            url: Url,
            dataType: 'json',
            delay: 250,
            type: 'post',
            data: function (params) {
                return {
                    search: params.term
                };
            },
            processResults: function (response) {
                var results = [];
                $.each(response, function (index, return_data) {
                    results.push({ id: index, text: return_data });
                });
                return {
                    results: results
                };
            },
            cache: true
        },
        placeholder: 'Write Something',
        minimumInputLength: 3,
    });
}


window.submitFrm = function (frmObj, redirectUrl = "") {
    frmUrl = $(frmObj).attr("action");
    var frmData = new FormData($(frmObj)[0]);
    var frmId = $(frmObj).attr("id");
    $.ajax({
        method: "post",
        url: frmUrl,
        data: frmData,
        dataType: "json",
        beforeSend: function () {
            $("#site-model").find(".modal-loader").show();
            $("#site-model").find(".modal-error").empty();
        },
        complete: function () {
            $("#site-model").find(".modal-loader").show();
            $("#site-model").find(".modal-loader").hide();
        },
        success: function (json_array) {
            if (json_array.status) {
                if (json_array.action == "redirect") {
                    setInterval(function () {
                        window.location.href = json_array.url;
                    }, 2000);
                }
                if (json_array.action == "show-model") {
                    openPopup(json_array.url);
                }
                if (json_array.action == "show-model-refresh") {
                    $("#site-model").modal("show").find(".modal-body").html(json_array.message);
                    setTimeout(function () {
                        // location.reload();
                    }, 5000);
                }
                if (json_array.action == "showError") {
                    var errors = json_array["errors"];
                    if (typeof errors == 'object') {
                        $.each(errors, function (key, value) {
                            if (value) {
                                MyNotifyJs(value, { 'type': 'error' });
                            }
                        });
                    } else if (typeof errors == 'string') {
                        MyNotifyJs(errors, { 'type': 'error' });
                    }
                }
                if (json_array.action == "reload") {
                    window.location.reload();
                }
                if (json_array.action == "notify") {
                    MyNotifyJs(json_array.message, { 'type': 'error' });
                }
            } else {
                window.location.reload();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#site-model").find(".modal-loader").hide();
            if (jqXHR.responseText) {
                var errorResponse = JSON.parse(jqXHR.responseText);
                var errors = errorResponse["errors"];
                if (typeof errors == 'object') {
                    $.each(errors, function (key, value) {
                        if (value) {
                            MyNotifyJs(value, { 'type': 'error' });
                        }
                    });
                } else if (typeof errors == 'string') {
                    MyNotifyJs(errors, { 'type': 'error' });
                }
            }
        },
        cache: false,
        contentType: false,
        processData: false,
    });
    return false;
}

window.openPopup = function (popupUrl, formId = "", modalWidth = "") {
    $("#site-model").find(".modal-error").html(" ");
    $("#site-model").find(".ContentDiv").html(" ");
    $("#site-model").find(".modal-loader").show();
    $("#site-model").find(".modal-dialog modal-dialog-centered").removeClass().addClass("modal-dialog");

    var token = $('meta[name="site_csrf_token"]').attr("content");
    var formData = { _token: token };
    if (formId) {
        formData = $("#" + formId).serialize();
    }
    $.ajax({
        method: formId ? "post" : "get",
        url: popupUrl,
        data: formData,
        success: function (data) {
            if (modalWidth) {
                $("#site-model").find(".modal-dialog").removeClass("modal-lg");
                $("#site-model").find(".modal-dialog").addClass(modalWidth);
            }
            $("#site-model").find(".modal-loader").hide();
            $("#site-model").modal("show").find(".ContentDiv").html(data);
        },
    });
}

$(document).on("change", '.upload-single-image', function () {
    targetId = $(this).data("id");
    readURLSingle(this, targetId);
});

window.checkContentType = function (e) {
    let type = $(e).data("type");
    let error = $(e).data("error");
    $(error).html("");
    if (type == "doc" && !/\.(pdf|doc|docx)$/i.test(e.files[0].name)) {
        // var text = '<div class="text-danger"> ' + e.files[0].name + ' is not an Document (pdf ,doc ,docx )</div>';
        var text = "Please select valid document format (pdf ,doc ,docx )";
        MyNotifyJs(text, { 'type': 'error' });
        $(error).html(text);
        return false;
    }
    if (type == "excel" && !/\.(xlsx)$/i.test(e.files[0].name)) {
        var text = "Please select valid document format (xlsx )";
        MyNotifyJs(text, { 'type': 'error' });
        $(error).html(text);
        return false;
    }
    if (type == "video" && !/\.(mp4|avi)$/i.test(e.files[0].name)) {
        // var text = '<div class="text-danger"> ' + e.files[0].name + ' is not valid video (jmp4,avi)</div>';
        var text = "Please select valid video format (jmp4,avi)";
        MyNotifyJs(text, { 'type': 'error' });
        $(error).html(text);
        return false;
    }
    if (type == "image" && !/\.(jpe?g|png|gif)$/i.test(e.files[0].name)) {
        // var text = '<div class="text-danger"> ' + e.files[0].name + ' is not valid Image (jpe,jpeg,png)</div>';
        var text = "Please select valid Image format (jpe,jpeg,png)";
        MyNotifyJs(text, { 'type': 'error' });
        $(error).html(text);
        return false;
    }
    if (type == "image" && e.files[0].size > 2000000) {
        // var text = '<div class="text-danger"> ' + e.files[0].name + ' Image is too large</div>';
        var text = "Upload image max size 2MB";
        MyNotifyJs(text, { 'type': 'error' });
        $(error).html(text);
        return false;
    }
    return true;
}

$(document).on("change", '.upload-single', function () {
    targetId = $(this).data("id");
    if (checkContentType(this)) {
        readURLSingle(this, targetId);
    } else {
        $(targetId).attr("src", "");
        $(this).val("");
    }
});

window.readURLSingle = function (e, t) {
    if (e.files && e.files[0]) {
        var a = new FileReader();
        (a.onload = function (e) {
            $(t).attr("src", e.target.result);
        }),
            a.readAsDataURL(e.files[0]);
    }
}

window.previewImages = function () {
    var preview = document.querySelector("#productImg");
    $("#productImg").empty();
    if (this.files) {
        [].forEach.call(this.files, readAndPreview);
    }
    window.readAndPreview = function (file) {
        if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
            return alert(file.name + " is not an image");
        }
        var reader = new FileReader();
        reader.addEventListener("load", function () {
            var image = new Image();
            image.height = 100;
            image.title = "Remove Image";
            image.src = this.result;
            image.classList = "removeImage";
            image.name = "image[]";
            preview.appendChild(image);
        });
        reader.readAsDataURL(file);
    }
}
$(document).on("change", '.upload-multi', previewImages);

window.readURLSec = function (input) {
    if (input.files && input.files[0]) {
        if (!/\.(jpe?g|png|gif)$/i.test(input.files[0].name)) {
            return alert(input.files[0].name + " is not an image");
        }
        var reader = new FileReader();
        reader.onload = function (event) {
            var className = $(input).attr("class");
            $(".images").prepend('<div id="imageRemoveId" class="' + className + '" style="background-image: url(\'' + event.target.result + '\');" rel="' + event.target.result + '"><span>remove</span></div>');
            $(".image-title").html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
        // } else {
        //     removeUpload();
    }
}
$(document).ready(function () {
    // uploadImage();
    window.uploadImage = function () {
        var button = $(".images .pic");
        var images = $(".images");

        function setAttributes(elem, attrs) {
            for (var key in attrs) {
                elem.setAttribute(key, attrs[key]);
            }
        }
        button.on("click", function () {
            var classValue = Math.random()
                .toString(36)
                .substring(7);
            var elem = document.createElement("INPUT");
            setAttributes(elem, {
                type: "file",
                class: classValue,
                name: "image[]",
                style: "display:none",
                onchange: "readURLSec(this);",
            });
            document.getElementById("productImg").setAttribute("class", "d-none");
            document.getElementById("uploadImage").appendChild(elem);
            elem.click();
        });
        images.on("click", "#imageRemoveId", function () {
            var className = $(this).attr("class");
            $("." + className).remove();
        });
    }
    uploadImage();
});
