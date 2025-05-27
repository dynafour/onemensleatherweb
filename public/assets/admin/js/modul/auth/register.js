var KTSignupGeneral = function() {
	var e, t, a, r, s = function() {
		return 100 === r.getScore()
	};
	return {
		init: function() {
			e = document.querySelector("#form_register"), t = document.querySelector("#button_register"), r = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]')), a = FormValidation.formValidation(e, {
				fields: {
					"name": {
						validators: {
							notEmpty: {
								message: "Nama pengguna tidak boleh kosong!"
							},
                            regexp: {
                                regexp: /^[A-Za-z0-9_][A-Za-z0-9._]*$/,
                                message: "Nama pengguna hanya boleh berisi huruf, angka, garis bawah, dan tanda titik (tidak boleh di awal)"
                            }
						}
					},
					email: {
						validators: {
							regexp: {
								regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
								message: "Email tidak valid!"
							},
							notEmpty: {
								message: "Email tidak boleh kosong!"
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: "Kata sandi tidak boleh kosong!"
							},
							callback: {
								message: "Kata sandi tidak valid",
								callback: function(e) {
									if (e.value.length > 0) return s()
								}
							}
						}
					},
					"repassword": {
						validators: {
							notEmpty: {
								message: "Konfirmasi kata sandi tidak boleh kosong!"
							},
							identical: {
								compare: function() {
									return e.querySelector('[name="password"]').value
								},
								message: "Konfirmasi kata sandi salah!"
							}
						}
					},
                    "question": {
						validators: {
							notEmpty: {
								message: "Pertanyaan pemulihan tidak boleh kosong!"
							}
						}
					},
                    "answer": {
						validators: {
							notEmpty: {
								message: "Jawaban pemulihan tidak boleh kosong!"
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger({
						event: {
							password: !1
						}
					}),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: ".fv-row",
						eleInvalidClass: "",
						eleValidClass: ""
					})
				}
			}), t.addEventListener("click", (function(s) {
				s.preventDefault(), a.revalidateField("password"), a.validate().then((function(a) {
					"Valid" == a ? regis_proses(t, e) : Swal.fire({
                        text: "Anda di larang daftar! terdapat kesalahan pada data yang anda masukan mohon periksa dan coba kembali",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "ok",
                        customClass: {
                            confirmButton: css_btn_confirm
                        }
                    })
				}))
			})), e.querySelector('input[name="password"]').addEventListener("input", (function() {
				this.value.length > 0 && a.updateFieldStatus("password", "NotValidated")
			}))
		}
	}
}();
function regis_proses(button, form) {
    var message, icon;
    var btn_text =  $('#button_register').html();

    $.ajax({
        url: form.getAttribute('action'),
        method: form.getAttribute('method'),
        data: {
            _token: csrf_token,
			name: form.querySelector('[name="name"]').value,
            email: form.querySelector('[name="email"]').value,
			password: form.querySelector('[name="password"]').value,
            repassword: form.querySelector('[name="repassword"]').value,
            question: form.querySelector('[name="question"]').value,
            answer: form.querySelector('[name="answer"]').value
        },
        dataType: 'json',
        beforeSend: function () {
            $('#button_register').html('Tunggu Sebentar...');
            $('#button_register').attr('disabled', true);
            // console.log('proses');
        },
        success: function (data) {
            // console.log(data);
            $('#button_register').html(btn_text);
            $('#button_register').attr('disabled', false);
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
                        form.querySelector('[name="email"]').value = "", form.querySelector('[name="password"]').value = "";
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
                    confirmButtonText: "Lanjutkan",
                    customClass: {
                        confirmButton: css_btn_confirm
                    }
                })
            }
        }
    });
}
KTUtil.onDOMContentLoaded((function() {
	KTSignupGeneral.init()
}));
