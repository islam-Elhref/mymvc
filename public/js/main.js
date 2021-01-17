
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
    $('#message').fadeOut('slow', function () {
        $("#message").remove();
    })
}, 5000)

//confirm

$('.delete').click(function (event) {
    var href =$(this).attr('href')
    event.preventDefault();
    $.confirm({
        title: 'Sure You Want To Delete user?',
        content: 'This dialog will automatically trigger \'cancel\' in 8 seconds if you don\'t respond.',
        autoClose: 'cancelAction|8000',
        buttons: {
            deleteUser: {
                text: 'delete user',
                action: function () {
                    window.location.href = href;
                }
            },
            cancelAction: function () {

            }
        }
    })
})


//confirm

$(document).ready(function () {
    $('.title').each(function () {

        var arabic = /[\u0600-\u06FF]/;
        var title = $(this).text();

        $num = Math.ceil(title.length / 3) + 1 ;

        if(arabic.test(title) == true){
            var firstTitle =title.substr(0 , $num);
            var lastTitle =title.substring($num );

        }else{
            var firstTitle =title.substring(0 , $num);
            var lastTitle =title.substring($num );
        }

        $(this).html("<span class='text-capitalize'>"+firstTitle+"</span>"+lastTitle);

    })
})


$('.dropdown-toggle').dropdown()

$(function () {
    $('.links a').mouseenter(function () {
        if (!$('.navbar').hasClass('open')){
            $('[data-toggletool="tooltip"]').tooltip('enable')
        }else{
            $('[data-toggletool="tooltip"]').tooltip('disable')
        }
    })


    $('.submenu').children().each(function () {
        if ($(this).hasClass('subactive') ){
            $(this).closest('.parent_link').addClass('active');
        }
    })

})

$('.links').children('li').click(function () {
    $(this).find('.submenu').slideToggle();
    $(this).siblings().find('.submenu').slideUp();
})










