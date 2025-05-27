$(function () {
    if ($('.search_mekanik input[type="text"]')) {
        var i = document.querySelector('.search_mekanik i');
        var button = document.querySelector('.search_mekanik button');
        var input = document.querySelector('.search_mekanik input');
        $('.search_mekanik input[type="text"]').on('keydown', function () {
            var value = $(this).val();
            if (value != '') {
                i.classList.add('d-none');
                input.classList.remove('ps-13');
                button.classList.remove('d-none');
                $('.search_mekanik button').attr('disabled', false);
            } else {
                i.classList.remove('d-none');
                input.classList.add('ps-13');
                button.classList.add('d-none');
                $('.search_mekanik button').attr('disabled', true);
            }
        })
    }


     /* Tanpa Rupiah */
    
    

    


});
function matauang(element = null,rep = null)
    {
         var angka = $(element).val();
       
        var rupiah = format_uang(angka);
        
        
        $(element).val(rupiah);
        if (rep != null) {
            var asli = angka.replaceAll(".", "");
            $(rep).val(asli);
        }
    }

    function format_uang(angka)
    {
       
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

function func_search(element, target = '.search_mekanik'){
    var i = document.querySelector(target+' i');
    var button = document.querySelector(target+' button');
    var input = document.querySelector(target+' input');
        var value = $(element).val();
        if (value != '') {
            i.classList.add('d-none');
            input.classList.remove('ps-13');
            button.classList.remove('d-none');
            $(target+' button').attr('disabled', false);
        } else {
            i.classList.remove('d-none');
            input.classList.add('ps-13');
            button.classList.add('d-none');
            $(target+' button').attr('disabled', true);
        }
}
function checked_action(element, child = 'child_checkbox') {
    var drag = document.getElementById('sistem_drag');
    var filter = document.getElementById('sistem_filter');
    if ($(element).is(':checked')) {
        drag.classList.remove('d-none');
        filter.classList.add('d-none');
        $('.' + child).prop('checked', true);
    } else {
        drag.classList.add('d-none');
        filter.classList.remove('d-none');
        $('.' + child).prop('checked', false);
    }


}

function child_checked(main = '') {
    var drag = document.getElementById('sistem_drag');
    var filter = document.getElementById('sistem_filter');

    var total = $('.child_checkbox').length;
    var total_checked = $('input.child_checkbox:checked').length;
    if (main == '') {
         if (total_checked == total) {
            $('thead input[type=checkbox]').prop('checked', true);
        } else {
            $('thead input[type=checkbox]').prop('checked', false);
        }
    }else{
         if (total_checked == total) {
            $(main).prop('checked', true);
        } else {
            $(main).prop('checked', false);
        }
    }
   
    if ($(this).is(':checked')) {
        if (total_checked > 0) {
            drag.classList.remove('d-none');
            filter.classList.add('d-none');
        } else {
            drag.classList.add('d-none');
            filter.classList.remove('d-none');

        }

    } else {
        if (total_checked > 0) {
            drag.classList.remove('d-none');
            filter.classList.add('d-none');
        } else {
            drag.classList.add('d-none');
            filter.classList.remove('d-none');
        }
    }
}
function search(excel = true,target = '.search_mekanik') {
    var src = $(target+' input[name=search]').val();
    src = src.split(" ");
    var value = '';
    var no = 0;
    src.forEach(val => {
        if (no++ > 0) {
            value += '--';
        }
        value += val
    });
    var get = url_get();
    if (excel == true) {
         var l = $('#cetak_excel').attr('href');
        const li = l.split("?");
        var link_cetak = li[0];
    }
   
    var params = '';
    if (get.length > 0) {
        if (get[0].split('=')[0] != 'search') {
            for (var i = 0; i < get.length; i++) {

                if (get[i].split('=')[0] != 'search') {
                    if (i == 0) {
                        params += '?' + get[i];
                    } else {
                        params += '&' + get[i];
                    }
                }

            }
            params += '&search=' + value;
        } else {

            params += '?search=' + value;
            for (var i = 0; i < get.length; i++) {

                if (get[i].split('=')[0] != 'search') {

                    params += '&' + get[i];
                }
            }
        }
    } else {

        params = '?search=' + value;
    }

    var uri = BASE_URL + page + params;
    uri = encodeURI(uri);
    if (excel == true) {
         $('#cetak_excel').attr('href', link_cetak + params);
    }
   
    window.history.pushState('', '', uri);
    $('#base_table').load(uri + ' #reload_table');

}

function filter(name = [],excel = true,hid = true) {
    var get = url_get();
    if (excel == true) {
          var l = $('#cetak_excel').attr('href');
    const li = l.split("?");
    var link_cetak = li[0];
    }
  
    var params = '';
    if (name.length > 0) {

        if (get.length > 0) {
            params += '?';
            // fruits.includes("Mango");
            for (var i = 0; i < get.length; i++) {
                if (!name.includes(get[i].split('=')[0])) {
                    params += get[i] + '&';
                }
            }
            for (var i = 0; i < name.length; i++) {
                var val_fix = '';
                var val_input = $('.filter_mekanik .filter-input[name=' + name[i] + ']').val();
                if (Array.isArray(val_input)) {
                    val_fix = val_input.join("|");
                }else{
                    val_fix = val_input.split(" ").join("");
                }
                params += name[i] + '=' + val_fix + '&';
            }
        } else {
            for (var i = 0; i < name.length; i++) {
                var val_fix = '';
                var val_input = $('.filter_mekanik .filter-input[name=' + name[i] + ']').val();
                if (Array.isArray(val_input)) {
                    val_fix = val_input.join("|");
                }else{
                    val_fix = val_input.split(" ").join("");
                }
                if (i == 0) {
                    params += '?' + name[i] + '=' + val_fix;
                } else {
                    params += '&' + name[i] + '=' + val_fix;
                }

            }
        }
        var uri = BASE_URL + page + params;
        uri = encodeURI(uri);
        if (excel == true) {
             $('#cetak_excel').attr('href', link_cetak + params);
        }
       
        window.history.pushState('', '', uri);
        if (hid == true) {
            $('.filter_mekanik').hide();
        }
        
        $('#base_table').load(uri + ' #reload_table');
    }
}


function url_get() {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    var data = [];
    for (var i = 0; i < sURLVariables.length; i++) {
        if (sURLVariables[i] != '') {
            data[i] = sURLVariables[i]
        }

    }
    // console.log(data);
    return data;
}

function url_get_1() {
    var url = window.location.search.substring(1);
    var request = {};
    var arr = [];
    var pairs = url.substring(url.indexOf('?') + 1).split('&');
    for (var i = 0; i < pairs.length; i++) {
      var pair = pairs[i].split('=');

      //check we have an array here - add array numeric indexes so the key elem[] is not identical.
      if(endsWith(decodeURIComponent(pair[0]), '[]') ) {
          var arrName = decodeURIComponent(pair[0]).substring(0, decodeURIComponent(pair[0]).length - 2);
          if(!(arrName in arr)) {
              arr.push(arrName);
              arr[arrName] = [];
          }

          arr[arrName].push(decodeURIComponent(pair[1]));
          request[arrName] = arr[arrName];
      } else {
        request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
      }
    }
    // console.log(request);
    return Object.keys(request);
}
function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}



