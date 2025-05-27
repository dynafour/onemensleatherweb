$(document).ready(function () {
    $("#start_date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });

    $("#end_date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });


    let table = $('#transactionTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: {
            url: BASE_URL + '/transaction/data',
            data: function(d) {
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            }
        },
        columns: [
            { data: 'code', name: 'code'},
            { data: 'category', name: 'category' },
            { data: 'name', name: 'name' },
            { data: 'qty', name: 'qty' },
            {
                data: 'price',
                name: 'price',
                render: function(data, type, row) {
                    if (!data) return ''; // Handle data kosong
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data);
                }
            },
            { data: 'pelanggan', name: 'pelanggan' },
            { data: 'alamat', name: 'alamat' },
            { 
                data: 'tanggal_pengiriman', 
                name: 'tanggal_pengiriman',
                render: function(data, type, row) {
                    return moment(data).format('DD-MM-YYYY'); // Format ke "25-03-2025"
                }
            },
            { data: 'sisa_stock', name: 'sisa_stock' },
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

    $('#dateFilter').click(function() {
        table.draw();
    });
});
