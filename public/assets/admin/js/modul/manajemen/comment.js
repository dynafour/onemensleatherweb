$(document).ready(function () {
    let table = $('#commentTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true, // Ini harus tetap true
        ajax: BASE_URL + '/comment/data',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'subject', name: 'subject'},
            { data: 'description', name: 'description', searchable: false },
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