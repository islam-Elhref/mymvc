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










