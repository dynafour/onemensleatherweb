$(function () {

    $('.hps_image').on('click', function () {
        // console.log('hapus');
        $('input[name="name_image"]').val("");
    });

    

});

function cek_email(element) {
    var value = $(element).val();
    var def = $('#def_email').val();
    if (value != def) {
        $('label.cek_kondisi').addClass('required');
    }else{
        $('label.cek_kondisi').removeClass('required');
    }
}