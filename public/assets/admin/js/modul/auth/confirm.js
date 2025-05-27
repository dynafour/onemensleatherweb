var KTConfirmPassword = function () {
    var e2, t2, i2;
    return {
        init: function () {
            e2 = document.querySelector("#form_confirm"), t2 = document.querySelector("#button_confirm"), i2 = FormValidation.formValidation(e2, {
                fields: {
                    "answer": {
                        validators: {
                            notEmpty: {
                                message: "Jawaban pemulihan tidak boleh kosong!"
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
            }), t2.addEventListener("click", (function (n) {
                n.preventDefault(), i2.validate().then((function (i) {
                    "Valid" == i ? confirm_proses(t2, e2) : Swal.fire({
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


function confirm_proses(button, form) {
    var message, icon;
    var btn = $('#button_confirm');
    var btn_text = btn.html();

    $.ajax({
        url: form.getAttribute('action'),
        method: form.getAttribute('method'),
        data: {
            _token: csrf_token,
            answer: form.querySelector('[name="answer"]').value,
            id_user : form.querySelector('[name="id_user"]').value
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
                var myModal = new bootstrap.Modal(document.getElementById('change_password'));
                myModal.show();
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
     KTConfirmPassword.init();
    
}));
