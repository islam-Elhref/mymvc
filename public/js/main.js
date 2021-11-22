// validation
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (!$("input[type=checkbox]:checked").length) {
                    $("input[type=checkbox]").prop('required', 'required')
                } else {
                    $("input[type=checkbox]:invalid").prop('required', '')
                }
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

$(function () {
    $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        yearRange: "1950: "
    });
});

$(document).ready(function () {

    $("input[title]:invalid").keydown(function () {
        $(this).siblings('.invalid-feedback').text($(this).attr('title'));
    })

})

function checkusersexist(url, me, jme) {
    var input = me
    var inputname = jme.attr('name');
    //  استخدمت الاايلمينت بالطريقه دي علشان مكنوش راضيين يتكتبوا جوه الداتا بتاعة الاجاكس
    elements = {};
    elements[inputname] = jme.val(); // الانبوت نيم ده متغير جايبه من اتربيوت النيم من اتشتيمل وباعته هو والفاليو بتاعته للبي اتش بي
    elements['input'] = inputname; // استخدمت انبوت نيم كا ثابت علشان اي كان الانبوت اللي هيتبعت يكون ثابت سواء كان يوسر نيم او ايميل انا هستخدم $post[input]
    input.setCustomValidity("Invalid field.")

    $.ajax({
        url: url,
        method: "POST",
        data: elements
    }).done(function (msg) {
        var old_value = $(input).siblings('.invalid-feedback').text(); // old value from text بجوار الانبوت المستخدم
        var checkExist_value = $(input).siblings('.invalid-feedback').attr('data-temp') // قيمة الاتربيوت الموجوده في الداتا تيمب وهيا المراد وضعها عندما يكون اليوسر او الايميل موجودين من قبل ونستدعيها من ملفات اللغه

        if (msg == 1) { // عند ارسال الريكويست لل بي اتش بي يتم الرد عليا اما ب 1 لو موجود او 0 لو مش موجود
            input.setCustomValidity("Invalid field.") // i use input not this because this refere to ajax xml so i make variable equl to this before ajax
            $(input).siblings('.invalid-feedback').attr('data-old', old_value) // $(inut) equl to $(this) becuse i save this in var input before ajax
            $(input).siblings('.invalid-feedback').text(checkExist_value)
        } else {

            input.setCustomValidity("") // if setcustomevalidity has param = '' then input valid if there is value then is invalid
            var data_old = $(input).siblings('.invalid-feedback').attr('data-old');
            $(input).siblings('.invalid-feedback').text(data_old)
        }

    });

}


// check if exists
$(document).ready(function () {

    $('.needs-validation .checkExist').change(function () {
        checkusersexist('http://mymvc.com/users/userexist', this, $(this))
    })

    // $('.needs-validation .supplierExist').change(function () {
    //     checkusersexist('http://mymvc.com/suppliers/supplierexist' , this , $(this))
    // })
})
// check if exists


$('#open_nav').click(function () {
    var nav = $('.navbar');
    var view = $('.view');

    if (nav.hasClass('open')) {
        nav.removeClass('open')
        view.removeClass('navopen')
        $(this).removeClass('open')
    } else {
        nav.addClass('open')
        view.addClass('navopen')
        $(this).addClass('open')
    }

})

$('.box').on('focus', function () {
    $(this).parent().find('label').addClass('active')
}).on('blur', function () {
    if (!this.value) {
        $(this).parent().find('label').removeClass('active')
    }
})


$(document).ready(function () {
    $('.box').each(function () {
        if (this.value) {
            $(this).parent().find('label').addClass('active')
        }
    })

})

setTimeout(function () {
    $('.message').each(function () {
        $(this).fadeOut('slow', function () {
            $(this).remove();
        })
    })
}, 10000)

//confirm
$('.delete').click(function (event) {
    var name = $(this).parents('tr').find('td.use_title').text()
    var msg = $(this).attr('title')
    var href = $(this).attr('href')
    var textDelete = $(this).text().trim();
    var textCancel = textDelete == 'Delete' ? 'Cancel' : 'إلغاء';
    event.preventDefault();
    $.confirm({
        title: msg + ' ' + name + ' ?',
        content: 'This dialog will automatically trigger \'cancel\' in 20 seconds if you don\'t respond.',
        autoClose: 'cancel|20000',
        buttons: {
            deleteUser: {
                text: textDelete,
                action: function () {
                    window.location.href = href;
                }
            },
            cancel: {
                text: textCancel,
                action: function () {

                }
            }
        }
    })
})

//confirm

$(document).ready(function () {
    $('.title').each(function () {

        var arabic = /[\u0600-\u06FF]/;
        var title = $(this).text();

        $num = Math.ceil(title.length / 3) + 1;

        if (arabic.test(title) == true) {
            var firstTitle = title.substr(0, $num);
            var lastTitle = title.substring($num);

        } else {
            var firstTitle = title.substring(0, $num);
            var lastTitle = title.substring($num);
        }

        $(this).html("<span class='text-capitalize'>" + firstTitle + "</span>" + lastTitle);

    })
})


$('.dropdown-toggle').dropdown()

$('[data-toggletool="tooltip"]').tooltip()

$(function () {
    $('.links a').hover(function () {
        if (!$('.navbar').hasClass('open')) {
            $('[data-toggletool="tooltip"]').tooltip('enable')
        } else {
            $('[data-toggletool="tooltip"]').tooltip('disable')
        }
    })


    $('.submenu').children().each(function () {
        if ($(this).hasClass('subactive')) {
            $(this).closest('.parent_link').addClass('active');
        }
    })

})

$('.links').children('li').click(function () {
    $(this).find('.submenu').slideToggle();
    $(this).siblings().find('.submenu').slideUp();
})


// submit in login bage


// submit in login bage



$(document).ready(function () {
    var arrayid=[];
    var option = [];

    $('.product_delete').each(function () {
        var id = $(this).val();
        option[id]= $('#product').find('option[value='+id+']').removeAttr("hidden")
        arrayid.push(id);
        option[id].remove()
    })


    $('#addproductorder').on('click' ,function (event) {

        if (!event.detail || event.detail == 1){ // for prevent the speed click علشان ميظهرش الناتج لو حد داس بسرعه علي الزر
            event.preventDefault();
        this.disabled=true;
        var select = $(this).siblings('#product').find('select');
        const id = select.val();
        option[id]= select.find('option[value='+id+']')

        if (arrayid.indexOf(id) < 0 && id != null ){

            $.ajax({
                url: 'http://mymvc.com/products/getproduct',
                method: "POST",
                data: {
                    product_id_add: id
                }
            }).done(function (msg) {
                if (msg != ''){
                    arrayid.push(id);
                    option[id].remove()
                    $('.complete_form').append(msg)
                    event.stopPropagation();
                }

            });
        }
        this.disabled=false;
        return false ;
        }
    })

    $('.complete_form').on('click','.closeproduct',function (e) {
        e.preventDefault();
        var id = $(this).parent('.product_plus').attr('data-id');
        $(this).parent('.product_plus').remove();
        arrayid.splice(arrayid.indexOf(id), 1);
        var select = $('#addproductorder').siblings('#product').find('select');
        console.log(option[id])
        select.append(option[id]);
    })

    function forbank_check(){
        var reciept_type = $('#reciept_type').val();
        if (reciept_type == 2){
            $('#receipt_bank').find('input').removeAttr('disabled')
            $('#receipt_bank').find('input').attr('required' , 'required')
        }else{
            $('#receipt_bank').find('input').attr('disabled' , 'disabled')
            $('#receipt_bank').find('input').removeAttr('required')
        }
    }
    forbank_check();
    $('#reciept_type').on('change' , forbank_check)



    function bill_id_check(){
        urlcheck = '';
        if($('#reciept_type').hasClass('sales')){
            urlcheck = '/receiptssales/get_price'
        }else{
            urlcheck = '/receiptspurchases/get_price';
        }

        var reciept_type = $('#bill_id').val();
        var url = window.location.origin + urlcheck
        $.ajax({
            url: url ,
            method: "POST",
            data: {
                bill_id: reciept_type
            }
        }).done(function (msg) {
            if (msg != ''){
                $('#bill_price').val(msg)
                $('#receipt_price').attr('max' , msg)
            }else{
                $('#bill_price').val('')
                $('#receipt_price').removeAttr('max')
            }

        });
    }
    bill_id_check()
    $('#bill_id').on('change' , bill_id_check )

    $('.icon').on('click',function () {
       var bill_price =  parseInt($('#bill_price').val())
        $('#receipt_price').val(bill_price).siblings('label').addClass('active')
    })

})

var value_count ;
var value_empty ;

$('.complete_form').on('change' , '.product_count_add.sales' ,function () {
    var count_in_store = parseInt($(this).parent().siblings('.allow_count').find('p').text().trim());

    if (value_count == undefined && value_empty == undefined){
        var value_count = $(this).siblings('.invalid-feedback').attr('data-temp');
        var value_empty = $(this).siblings('.invalid-feedback').attr('data-old');
    }

    if ( count_in_store < parseInt($(this).val().trim()) ){
        this.setCustomValidity("Invalid field.")
        $(this).siblings('.invalid-feedback').text(value_count)

    } else {
        this.setCustomValidity("")
        $(this).siblings('.invalid-feedback').text(value_empty)

    }

} )

$('.complete_form').on('change' , '.product_count_add.buy' ,function () {
    var count_in_store = parseInt($(this).parent().siblings('.allow_count').find('p').text().trim());

    if (value_count == undefined && value_empty == undefined){
        var value_count = $(this).siblings('.invalid-feedback').attr('data-temp');
        var value_empty = $(this).siblings('.invalid-feedback').attr('data-old');
    }

    if ( count_in_store > parseInt($(this).val().trim()) ){
        this.setCustomValidity("Invalid field.")
        $(this).siblings('.invalid-feedback').text(value_count)

    } else {
        this.setCustomValidity("")
        $(this).siblings('.invalid-feedback').text(value_empty)

    }

} )

$(document).ready(function () {
    $('.finalorderprice').each(function () {
        if ($(this).text() == $(this).siblings('.receipt_price').text() ){
            $(this).addClass('finish_price')
        }
    })
})

$(document).ready(function () {
    Notification.requestPermission()
    new Notification('hi' , {
        icon: 'adsd',
        body: 'sadasdqwda'
    })
})
