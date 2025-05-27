$(document).ready(function () {
    let table = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true, // Ini harus tetap true
        ajax: BASE_URL + '/product/data',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'code', name: 'code' },
            { data: 'name', name: 'name' },
            { data: 'category', name: 'category'},
            { data: 'total_sold', name: 'total_sold', searchable: false }, // Matikan searching
            { data: 'stok_tersedia', name: 'stok_tersedia', searchable: false }, // Matikan searching
            { data: 'switch', name: 'switch', orderable: false, searchable: false },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
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

    $('#select_id_category').select2({
        dropdownParent: $('#kt_modal_product')
    });
});

ClassicEditor.create(document.querySelector('#description'), {
    toolbar: {
        items: CKEditor_tool,
    },
    alignment: {
        options: ['left', 'center', 'right', 'justify'],
    },
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
    },
    link: {
        addTargetToExternalLinks: true, // Add 'target="_blank"' for external links
        decorators: {
            openInNewTab: {
                mode: 'manual',
                label: 'Open in a new tab',
                attributes: {
                    target: '_blank',
                    rel: 'noopener noreferrer'
                }
            }
        }
    },
    fontColor: {
        colors: font_color,
        columns: 5,
        documentColors: 10,
        colorPicker: true,
    },
    fontBackgroundColor: {
        colors: font_color,
    },
    language: 'en',
    licenseKey: '',
})
.then((editor) => {
    mydescription = editor;
})
.catch((error) => {
    console.error(error);
});



var title = $('#title_modal').data('title').split('|');
var id_form = 'form_product';
var image = document.getElementById('display_image');
function ubah_data(element, id) {
    var foto = $(element).data('image');
    var form = document.getElementById(id_form);
    $('#title_modal').text(title[0]);
    form.setAttribute('action', BASE_URL + '/ubah-product');
    $.ajax({
        url: BASE_URL + '/detail_product',
        method: 'POST',
        data: { 
            _token : csrf_token,
            id: id 
        },
        dataType: 'json',
        success: function (data) {
             image.style.backgroundImage = "url('" + foto + "')";
            // MANIPULASI TAMPILAN
            $('#req_code').removeClass('d-none');
            $('#pane_stock').addClass('d-none');
            $('#pane_color').removeClass('col-md-6');
            $('#pane_color').addClass('col-md-12');
            $('#management_stock').removeClass('d-none');
            $('input[name="addstock"]').val('');

            // MANIPULASI INPUT
            $('input[name="id_product"]').val(data.detail.id_product);
            $('input[name="name"]').val(data.detail.name);
            $('input[name="material"]').val(data.detail.material);
            $('input[name="size"]').val(data.detail.size);
            $('input[name="color"]').val(data.detail.color);
            $('input[name="link"]').val(data.detail.link);
            $('input[name="name_image"]').val(data.detail.image);

            $('input#real_price').val(data.detail.price);
            $('input#fake_price').val(format_uang(data.detail.price.toString()));
            $('input[name="code"]').val(data.detail.code);
             mydescription.setData(data.detail.description)
            $('select#select_id_category').val(data.detail.id_category);
            $('select#select_id_category').trigger('change');
            $('#display_table').html(data.table);
        }
    })
}

function detail_data(element, id) {
    var foto = $(element).data('image');
    var image_detail = document.getElementById('display_image_detail');
     document.getElementById("product_file").value = "";
    $('#product_file').val('');
    $.ajax({
        url: BASE_URL + '/detail_product',
        method: 'POST',
        data: { 
            _token : csrf_token,
            id: id 
        },
        dataType: 'json',
        success: function (data) {
            $('#title_detail_modal').text(data.detail.name);
             image_detail.style.backgroundImage = "url('" + foto + "')";

            // MANIPULASI INPUT
            $('#detail_price').html('Rp. '+format_uang(data.detail.price.toString()));
            $('#detail_material').html(data.detail.material);
            $('#detail_size').html(data.detail.size);
            $('#detail_color').html(data.detail.color);
            $('#detail_link').html(data.detail.link);
            $('#detail_description').html(data.detail.description);

            $('#display_table_detail').html(data.table);
        }
    })
}

function tambah_data() {
    image.style.backgroundImage = "url('" + base_foto + "')";
    var form = document.getElementById(id_form);
    form.setAttribute('action', BASE_URL + '/tambah-product');
     document.getElementById("product_file").value = "";
    $('#product_file').val('');
    $('#title_modal').text(title[1]);
    // MANIPUASI TAMPILAN
    $('#req_code').addClass('d-none');
    $('#pane_stock').removeClass('d-none');
    $('#management_stock').addClass('d-none');
    $('#pane_color').removeClass('col-md-12');
    $('#pane_color').addClass('col-md-6');

    mydescription.setData('')
    // MANIPULASI INPUT
    $('#'+id_form+' input[type="text"]').val('');
    $('#'+id_form+' input[type="number"]').val('');
    $('#'+id_form+' textarea').val('');
     $('#'+id_form+' input#real_price').val('');


    $('select#select_id_category').val('');
    $('select#select_id_category').trigger('change');
}

function add_stock() {
    var id_product = $('input[name="id_product"]').val();
    var stock = $('input[name="addstock"]').val();
    if (!id_product) {
        Swal.fire({
            html: 'Data product tidak valid',
            icon: 'warning',
            buttonsStyling: !1,
            confirmButtonText: 'Lanjutkan',
            customClass: { confirmButton: css_btn_confirm }
        });
        return
    }

    if (stock <= 0) {
        Swal.fire({
            html: 'Nilai stok tidak boleh kosong!',
            icon: 'warning',
            buttonsStyling: !1,
            confirmButtonText: 'Lanjutkan',
            customClass: { confirmButton: css_btn_confirm }
        });
        return
    }
    Swal.fire({
        html: 'Apakah anda yakin akan menambahkan stok sebanyak <b>'+stock+' pcs </b> ?',
        icon: 'question',
        showCancelButton: true,
        buttonsStyling: !1,
        confirmButtonText: 'Lanjutkan',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: css_btn_confirm,
            cancelButton: css_btn_cancel
        },
        reverseButtons: true
    }).then((function (t) {
        if (t.isConfirmed) {
            $.ajax({
                url: BASE_URL + '/stock-product',
                method: 'POST',
                data: { 
                    _token : csrf_token,
                    id_product: id_product,
                    jumlah: stock 
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == true) {
                        var icon = 'success';
                        if (data.datatable) {
                            var table = $('#'+data.datatable).DataTable();
                            table.ajax.reload(null, false);
                            if ($('#no_value_table')) {
                                $('#no_value_table').remove();
                            }
                            $('#display_table').prepend(data.newrow);
                            $('input[name="addstock"]').val('');
                        }
                    }else{
                        var icon = 'warning';
                    }
                    
                    Swal.fire({
                        html: data.alert.message,
                        icon: icon,
                        buttonsStyling: !1,
                        confirmButtonText: 'Lanjutkan',
                        customClass: { confirmButton: css_btn_confirm }
                    });

                }
            })
        }
    }));
}