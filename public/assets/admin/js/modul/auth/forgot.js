var KTForgotPassword = function () {
    var e, t, i;
    return {
        init: function () {
            e = document.querySelector("#form_forgot"), t = document.querySelector("#button_forgot"), i = FormValidation.formValidation(e, {
                fields: {
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "Alamat email tidak valid"
                            },
                            notEmpty: {
                                message: "Alamat email tidak boleh kosong"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function (n) {
                n.preventDefault(), i.validate().then((function (i) {
                    "Valid" == i ? forgot_proses(t, e) : Swal.fire({
                        text: "Tidak ada data terdeteksi! Silahkan coba lagi",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "ok",
                        customClass: {
                            confirmButton: css_btn_confirm
                        }
                    })
                }))
            }))
        }
    }
}();


function forgot_proses(button, form) {
    var message, icon;
    var btn = $('#button_forgot');
    var btn_text = btn.html();

    $.ajax({
        url: form.getAttribute('action'),
        method: form.getAttribute('method'),
        data: {
            _token: csrf_token,
            email: form.querySelector('[name="email"]').value
        },
        dataType: 'json',
        beforeSend: function () {
            btn.html('Tunggu sebentar...');
            btn.attr('disabled', true);
        },
        success: function (data) {
            // console.log(data);
            btn.html(btn_text);
            btn.attr('disabled', false);
            if (data.status == 200) {
                icon = 'success';
            } else if (data.status == 700) {
                icon = 'error';
            } else {
                icon = 'warning';
            }
            if (data.status == 200) {
                Swal.fire({
                    html: data.message,
                    icon: icon,
                    buttonsStyling: !1,
                    confirmButtonText: "Lanjutkan",
                    customClass: {
                        confirmButton: css_btn_confirm
                    }
                }).then((function (t) {
                    if (t.isConfirmed) {
                        form.querySelector('[name="email"]').value = "";
                        if (data.redirect) {
                            location.href = data.redirect;
                        }
                    }
                }))
            } else {
                Swal.fire({
                    html: data.message,
                    icon: icon,
                    buttonsStyling: !1,
                    confirmButtonText: "Perbaiki",
                    customClass: {
                        confirmButton: css_btn_confirm
                    }
                })
            }
        }
    });
}

KTUtil.onDOMContentLoaded((function () {
    KTForgotPassword.init();
    
}));
