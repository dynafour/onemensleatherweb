$(document).ready(function () {
    let table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true, // Ini harus tetap true
        ajax: BASE_URL + '/category/data',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'image',name: 'image',  orderable: false, searchable: false},
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
});


var title = $('#title_modal').data('title').split('|');
var image = document.getElementById('display_image');
var id_form = 'form_category';
function ubah_data(element, id) {
    var foto = $(element).data('image');
    var form = document.getElementById(id_form);
    document.getElementById("category_file").value = "";
    $('#category_file').val('');
    $('#title_modal').text(title[0]);
    form.setAttribute('action', BASE_URL + '/ubah-category');
    $.ajax({
        url: BASE_URL + '/single/categories/id_category',
        method: 'POST',
        data: { 
            _token : csrf_token,
            id: id 
        },
        dataType: 'json',
        success: function (data) {
            // console.log(data)
            image.style.backgroundImage = "url('" + foto + "')";
            $('input[name="id_category"]').val(data.id_category);
            $('input[name="name_image"]').val(data.image);
            $('input[name="name"]').val(data.name);
        }
    })
}

function tambah_data() {
    image.style.backgroundImage = "url('" + base_foto + "')";
    var form = document.getElementById(id_form);
    form.setAttribute('action', BASE_URL + '/tambah-category');
    document.getElementById("category_file").value = "";
    $('#category_file').val('');
    $('#title_modal').text(title[1]);
    $('#'+id_form+' input[type="text"]').val('');
}

