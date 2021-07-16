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
                if(!$("input[type=checkbox]:checked").length){
                    $("input[type=checkbox]").prop('required','required')
                }else{
                    $("input[type=checkbox]:invalid").prop('required','')
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

$(document).ready(function () {

    $("input[title]:invalid").keydown(function () {
        $(this).siblings('.invalid-feedback').text($(this).attr('title'));
    })

})

$(document).ready(function(){
    $('.needs-validation .checkExist').change(function () {
        var input = this
        var inputname = $(this).attr('name');
        //  استخدمت الاايلمينت بالطريقه دي علشان مكنوش راضيين يتكتبوا جوه الداتا بتاعة الاجاكس
        elements = {};
        elements[inputname] = $(this).val(); // الانبوت نيم ده متغير جايبه من اتربيوت النيم من اتشتيمل وباعته هو والفاليو بتاعته للبي اتش بي
        elements['input'] = inputname; // استخدمت انبوت نيم كا ثابت علشان اي كان الانبوت اللي هيتبعت يكون ثابت سواء كان يوسر نيم او ايميل انا هستخدم $post[input]

        $.ajax({
            url: "http://mymvc.com/users/userexist",
            method: "POST",
            data: elements
        }).done(function( msg ) {

            var old_value = $(input).siblings('.invalid-feedback').text(); // old value from text بجوار الانبوت المستخدم
            var checkExist_value = $(input).siblings('.invalid-feedback').attr('data-temp') // قيمة الاتربيوت الموجوده في الداتا تيمب وهيا المراد وضعها عندما يكون اليوسر او الايميل موجودين من قبل ونستدعيها من ملفات اللغه

            if (msg == 1 ){ // عند ارسال الريكويست لل بي اتش بي يتم الرد عليا اما ب 1 لو موجود او 0 لو مش موجود

                input.setCustomValidity("Invalid field.") // i use input not this because this refere to ajax xml so i make variable equl to this before ajax
                $(input).siblings('.invalid-feedback').attr('data-old' , old_value ) // $(inut) equl to $(this) becuse i save this in var input before ajax
                $(input).siblings('.invalid-feedback').text(checkExist_value)
            }else{
                input.setCustomValidity("") // if setcustomevalidity has param = '' then input valid if there is value then is invalid
                var data_old = $(input).siblings('.invalid-feedback').attr('data-old');
                $(input).siblings('.invalid-feedback').text(data_old)
            }

        });

    })
})

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
    var textCancel = textDelete=='Delete' ? 'Cancel' : 'إلغاء' ;
    event.preventDefault();
    $.confirm({
        title: msg + ' ' + name + ' ?',
        content: 'This dialog will automatically trigger \'cancel\' in 8 seconds if you don\'t respond.',
        autoClose: 'cancel|8000',
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






