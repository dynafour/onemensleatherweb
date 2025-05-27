$(document).ready(function () {
    $("#tanggal").daterangepicker();
})


function set_periode(element) {
    var value = $(element).val();
    $('.filter-laporan').addClass('d-none');
    reset_form();
    if (value != '') {
        $('#width_main_pane').removeClass('col-xl-12');
        $('#width_main_pane').addClass('col-xl-7');
        $('#pane_filter').removeClass('d-none');
        if (value == 1) {
            $('#pane_filter_tanggal').removeClass('d-none');
        }

        if (value == 2) {
            $('#pane_filter_tahun').removeClass('d-none');
            $('#pane_filter_bulan').removeClass('d-none');
        }

        if (value == 3) {
            $('#pane_filter_tahun').removeClass('d-none');
        }
    }else{
        $('#width_main_pane').addClass('col-xl-12');
        $('#width_main_pane').removeClass('col-xl-7');
        $('#pane_filter').addClass('d-none');
    }
}


function reset_form() {
    $('#tanggal').val('');
    $('#start_month').val('');
    $('#start_month').trigger('change');
    $('#end_month').val('');
    $('#end_month').trigger('change');
    $('#year').val('');
    $('#year').trigger('change');
    $('#id_product').val('');
    $('#id_product').trigger('change');
    $('#display_report').empty();
    $('#button_cetak').addClass('d-none');
}


function select_tipe_report(element) {
    var value = $(element).val();
    if (value == 2) {
        $('#pane_filter_product').removeClass('d-none');
    }else{
        $('#pane_filter_product').addClass('d-none');
    }
}


function pick_start_month(element) {
    var value = $(element).val();
    let select = document.getElementById("end_month");
    let options = select.options;

    select.disabled = true;
    for (let i = 0; i < options.length; i++) {
        options[i].disabled = false;
    }
    if (value != '') {
        select.disabled = false;
        for (let i = 0; i < value; i++) {
            options[i].disabled = true;
        }
    }
    
}


function cek_data() {
    var tipe = $('#tipe').val();
    var periode = $('#periode').val();
    var id_product = $('#id_product').val();
    var tanggal = $('#tanggal').val();
    var start_month = $('#start_month').val();
    var end_month = $('#end_month').val();
    var year = $('#year').val();

    if (!tipe) {
        Swal.fire({
            html: 'Jenis laporan tidak boleh kosong!',
            icon: 'warning',
            buttonsStyling: !1,
            confirmButtonText: 'Lanjutkan',
            customClass: { confirmButton: css_btn_confirm }
        });
        return;
    }
    if (!periode) {
        Swal.fire({
            html: 'Pilih periode filter terlebih dulu!',
            icon: 'warning',
            buttonsStyling: !1,
            confirmButtonText: 'Lanjutkan',
            customClass: { confirmButton: css_btn_confirm }
        });
        return;
    }
    if (tipe == 2) {
        if (!id_product) {
             Swal.fire({
                html: 'Produk harus dipilih untuk melihat laporan stock!',
                icon: 'warning',
                buttonsStyling: !1,
                confirmButtonText: 'Lanjutkan',
                customClass: { confirmButton: css_btn_confirm }
            });
            return;
        }
    }
    if (periode == 1) {
        if (!tanggal) {
            Swal.fire({
                html: 'Pilih range tanggal terlebih dahulu!',
                icon: 'warning',
                buttonsStyling: !1,
                confirmButtonText: 'Lanjutkan',
                customClass: { confirmButton: css_btn_confirm }
            });
            return;
        }
    }


    if (periode == 2) {
        if (!start_month || !end_month || !year) {
            Swal.fire({
                html: 'Pilih range bulan dan tahun terlebih dahulu',
                icon: 'warning',
                buttonsStyling: !1,
                confirmButtonText: 'Lanjutkan',
                customClass: { confirmButton: css_btn_confirm }
            });
            return;
        }
    }

    if (periode == 3) {
        if (!year) {
            Swal.fire({
                html: 'Pilih tahun terlebih dahulu',
                icon: 'warning',
                buttonsStyling: !1,
                confirmButtonText: 'Lanjutkan',
                customClass: { confirmButton: css_btn_confirm }
            });
            return;
        }
    }
    
    var dataPost = { 
            _token: csrf_token,
            tanggal: tanggal,
            tipe: tipe,
            periode: periode,
            start_month: start_month,
            end_month: end_month,
            year: year,
            id_product: id_product
        };
    $.ajax({
        url: BASE_URL + '/report-ajax',
        method: 'POST',
        data: dataPost,
        cache: false,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200 || data.status == true) {
                dataPost.datatable = true;
                $('#display_report').empty();
                $("#display_report").html(data.html);
                // $("#display_report table").DataTable();
                var table = $("#display_report table").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: BASE_URL + '/report-ajax', // URL untuk ambil data JSON (bisa sama dengan HTML-nya)
                        data: dataPost,
                        type: "POST"
                    }
                });

                table.on('draw.dt', function() {
                    var jumlah = table.data().length;
                    // console.log(jumlah);
                    if (jumlah === 0) {
                        $('#button_cetak').addClass('d-none');
                    } else {
                        $('#button_cetak').removeClass('d-none');
                    }
                });

                // Fungsi debounce
                function debounce(func, wait, immediate) {
                    let timeout;
                    return function () {
                        let context = this, args = arguments;
                        let later = function () {
                            timeout = null;
                            if (!immediate) func.apply(context, args);
                        };
                        let callNow = immediate && !timeout;
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                        if (callNow) func.apply(context, args);
                    };
                }

                // Event saat mengetik di input search
                $('#searchTable').on('keyup', debounce(function () {
                    table.search(this.value).draw();
                }, 500)); // Delay 500ms untuk debounce
                
            }
        }
    });


}



function cetak_excel() {
    var tipe = $('#tipe').val();
    var periode = $('#periode').val();
    var id_product = $('#id_product').val();
   


    var tanggal = $('#tanggal').val();
    var start_month = $('#start_month').val();
    var end_month = $('#end_month').val();
    var year = $('#year').val();

    var filename = '';
    if (!tipe) {
        Swal.fire({
            html: 'Jenis laporan tidak boleh kosong!',
            icon: 'warning',
            buttonsStyling: !1,
            confirmButtonText: 'Lanjutkan',
            customClass: { confirmButton: css_btn_confirm }
        });
        return;
    }
    if (!periode) {
        Swal.fire({
            html: 'Pilih periode filter terlebih dulu!',
            icon: 'warning',
            buttonsStyling: !1,
            confirmButtonText: 'Lanjutkan',
            customClass: { confirmButton: css_btn_confirm }
        });
        return;
    }
    if (tipe == 2) {
        if (!id_product) {
             Swal.fire({
                html: 'Produk harus dipilih untuk melihat laporan stock!',
                icon: 'warning',
                buttonsStyling: !1,
                confirmButtonText: 'Lanjutkan',
                customClass: { confirmButton: css_btn_confirm }
            });
            return;
        }
    }
    
    var dt = '';
    if (periode == 1) {
        if (!tanggal) {
            Swal.fire({
                html: 'Pilih range tanggal terlebih dahulu!',
                icon: 'warning',
                buttonsStyling: !1,
                confirmButtonText: 'Lanjutkan',
                customClass: { confirmButton: css_btn_confirm }
            });
            return;
        }
        var to = tanggal.replace("-", "to");
        to = to.replace(/\//g, "_");
        dt += to.replace(/ /g, "_");
    }
    if (periode == 2) {
        if (!start_month || !end_month || !year) {
            Swal.fire({
                html: 'Pilih range bulan dan tahun terlebih dahulu',
                icon: 'warning',
                buttonsStyling: !1,
                confirmButtonText: 'Lanjutkan',
                customClass: { confirmButton: css_btn_confirm }
            });
            return;
        }
        var last = new Date(year, end_month, 0);
        last = last.getDate();

        dt += year+'_'+start_month+'_01_to_'+year+'_'+end_month+'_'+last;
    }
    if (periode == 3) {
        if (!year) {
            Swal.fire({
                html: 'Pilih tahun terlebih dahulu',
                icon: 'warning',
                buttonsStyling: !1,
                confirmButtonText: 'Lanjutkan',
                customClass: { confirmButton: css_btn_confirm }
            });
            return;
        }
        dt += year+'_01_01_to_'+year+'_12_31';
    }

    if (tipe == 1) {
        filename += 'laporan_produk_'+dt;
    }
    

    if (tipe == 2) {
        // Mendapatkan elemen select
        var selectElement = document.querySelector('#id_product');
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var name_product = selectedOption.getAttribute('data-name');
        console.log(name_product);
        filename += 'laporan_stock_produk_'+name_product.replace(/ /g, "_")+'_'+dt;
    }
    
    if (tipe == 3) {
        filename += 'laporan_transaksi_'+dt;
    }
    var dataPost = { 
            _token: csrf_token,
            tanggal: tanggal,
            tipe: tipe,
            periode: periode,
            start_month: start_month,
            end_month: end_month,
            year: year,
            id_product: id_product,
            filename : filename
        };
    $.ajax({
        url: BASE_URL + '/export',
        type: 'POST',
        data: dataPost,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            const blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename+'.xlsx';
            link.click();
        },
        error: function (err) {
            console.log(tipe);
            alert('Export gagal, bro!');
        }
    });
}