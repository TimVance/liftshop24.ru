$(document).ready(function() {
    $('input, select').styler();
    $(".callbacklink").click(function() {
        $(".modalbg").addClass("modalbgactive");
        $(".callbackform").addClass("callbackformactive");
    });
    $("body").on('click', '.closedModal, .modalbg, .itemcontinue, .modalbg', function() {
        $(".modalbg").removeClass("modalbgactive");
        $(".callbackform").removeClass("callbackformactive");
        $(".cart_one_click").removeClass("callbackformactive");
        $(".successtocart").removeClass("callbackformactive");
        $(".modalwhotowrap").removeClass("active");
    });
    $("body").on('click', '.oneclickbutton, .oneclickbuttonrow', function() {
        $(".modalbg").addClass("modalbgactive");
        $(this).parents('.shop-item').find('.cart_one_click').addClass('callbackformactive');
        $(this).parents('.shop-item-right').find('.cart_one_click').addClass('callbackformactive');
    });
    $("body").on("click", ".action-know-price", function () {
        $(".modalbg").addClass("modalbgactive");
        var form = $(this).parents('.shop-item-right').find('.cart_one_click');
        form.addClass('callbackformactive');
        form.find(".title").text('Заполните заявку');
        if (!form.find(".order_form_param10 label").hasClass("active"))
            form.find(".order_form_param10 label").click().addClass("active");
    });
    $("body").on('click', '.shop_buy .button', function() {
        $(".modalbg").addClass("modalbgactive");
        $(".successtocart").addClass("callbackformactive");
    });
    $(".tooglemenu").click(function() {
        $(this).toggleClass("activemenu");
        $("nav").toggleClass("activenav");
    });
    $(".pricesslider").slider({
        range: true,
        min: 0,
        max: 100000,
        animate: "fast",
        step: 10,
        values: [0, 100000],
        slide: function(event, ui) {
            $(".prices .from").val(ui.values[0]);
            $(".prices .to").val(ui.values[1]);
        }
    });
    $(".prices .from").val($(".pricesslider").slider("values", 0));
    $(".prices .to").val($(".pricesslider").slider("values", 1));
    $('.prices .from, .prices .to').on('input keyup', function(e) {
        $(this).val($(this).val().replace(/[a-zA-Zа-яА-Я]/, ""));
        $(".pricesslider").slider({
            values: [$('.prices .from').val(), $('.prices .to').val()]
        });
    });
    $(".shop-item-left").addClass("preload");

    $(".photo-oborud").slick({
        dots: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        autoplay: true,
        arrows: true,
        speed: 2000,
        responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            dots: false
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false
          }
        }
        ]
    });

    $('.bottomheader .search_form .input_search').on('input keyup', function(e) {
        $('.data-load-search, .data-load-results').html('');
        var q = $(this).val();
        q = q.replace(/ /g, '+');
        $('.bottomheader .data-load-search').load('/search/?module=search&searchword='+ q + ' .right .shop-pane', function(data) {
            $('.bottomheader .data-load-results').append($('.bottomheader .data-load-search .shop-item-title'));
        });
        $('.bottomheader .data-load-results').fadeIn();
    });

    $('.data-load-results').on('click', '.shop-item-title', function(e) {
        e.preventDefault();
        $('.search_form .input_search').val($(this).text());
        $('.search_form .submit_search').click();
    });

    $('.search_form .input_search').focusout(function() {
        $(".data-load-results").fadeOut();
    });

    $('.search_form .input_search').focus(function() {
        if ($(this).val() != '') {
            //$('.search_form .submit_search').click();
            $(".data-load-results").fadeIn();
        }
    });

    $(document).ready(function(){
        $("a[rel^='prettyPhoto']").prettyPhoto();
    });

    $(document).scroll(function() {
        if ($(window).scrollTop() > 100) $('.wrapper-fixed-header, .cart_block.top-line-item').addClass('active');
            else $('.wrapper-fixed-header, .cart_block.top-line-item').removeClass('active');
    });

});
$(document).ready(function() {
    var end = parseInt($('.paginator .end').attr('dataend'));
    if (end > 1) {
        $('.showother').show();
    }
    $('.showother').click(function() {
        $(this).text('Загрузка ...');
        var page = parseInt($(this).attr('data'));
        var end = parseInt($('.paginator .end').attr('dataend'));
        if (page < end) {
            $('.numberpages').each(function(index, number) {
                if (parseInt($(number).attr('numberpage')) == parseInt(page) + 1) {
                    var coordinateitems = $(number).attr('href') + ' .shop_list_rows .shop-item';
                    $('.dataload').load(coordinateitems, function(data) {
                        $('.shop_list_rows .shop-pane').append($('.dataload .shop-item'));
                        $('input').styler();
                        $('.showother').text('Показать еще');
                    });
                }
            });
            page = parseInt(page) + 1;
            $(this).attr('data', page);
        }
        if (page + 1 >= end) {
            $('.showother').fadeOut('slow');
        }
    });
});

function isVisible(tag) {
    var t = $(tag);
    var w = $(window);
    var wt = w.scrollTop();
    var tt = t.offset().top;
    var tb = tt + t.height();
    return ((tb <= wt + w.height()) && (tt >= wt));
}
$(function() {
    $(window).scroll(function() {
        var page = parseInt($('.showother').attr('data'));
        var end = parseInt($('.paginator .end').attr('dataend'));
        if (page < end) {
            var b = $(".showother");
            if (!b.prop("shown") && isVisible(b)) {
                b.prop("shown", true);
                autoLoadGoods(b);
            }
        }
    });
});

function autoLoadGoods(b) {
    var end = parseInt($('.paginator .end').attr('dataend'));
    if (end > 1) {
        $('.showother').show();
    }
    $('.showother').text('Загрузка ...');
    var page = parseInt($('.showother').attr('data'));
    var end = parseInt($('.paginator .end').attr('dataend'));
    if (page < end) {
        $('.numberpages').each(function(index, number) {
            if (parseInt($(number).attr('numberpage')) == parseInt(page) + 1) {
                console.log($(number).attr('href'));
                var coordinateitems = encodeURI($(number).attr('href')) + ' .shop_list_rows .shop-item';
                $('.dataload').load(coordinateitems, function(data) {
                    $('.shop_list_rows .shop-pane').append($('.dataload .shop-item'));
                    $('input').styler();
                    $('.showother').text('Показать еще');
                });
            }
        });
        page = parseInt(page) + 1;
        $('.showother').attr('data', page);
    }
    if (page + 1 >= end) {
        $('.showother').fadeOut('slow');
    }
    b.prop("shown", false);
}


$(function() {
  // Проверяем запись в куках о посещении
  // Если запись есть - ничего не происходит
     if (!$.cookie('hideModal')) {
  // если cookie не установлено появится окно
  // с задержкой 5 секунд
    var delay_popup = 1000;
    setTimeout("document.querySelector('.bottom-cookie-block').style.display='inline-block'", delay_popup);
     }
     $.cookie('hideModal', true, {
   // Время хранения cookie в днях
    expires: 30,
    path: '/'
   });


    // Закрытие полосы cookie
    $('.ok').click(function(){
        $('.bottom-cookie-block').fadeOut();
    });
});


// Cookie
(function(factory){if(typeof define==='function'&&define.amd){define(['jquery'],factory);}else if(typeof exports==='object'){module.exports=factory(require('jquery'));}else{factory(jQuery);}}(function($){var pluses=/\+/g;function encode(s){return config.raw?s:encodeURIComponent(s);}function decode(s){return config.raw?s:decodeURIComponent(s);}function stringifyCookieValue(value){return encode(config.json?JSON.stringify(value):String(value));}function parseCookieValue(s){if(s.indexOf('"')===0){s=s.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,'\\');}try{s=decodeURIComponent(s.replace(pluses,' '));return config.json?JSON.parse(s):s;}catch(e){}}function read(s,converter){var value=config.raw?s:parseCookieValue(s);return $.isFunction(converter)?converter(value):value;}var config=$.cookie=function(key,value,options){if(arguments.length>1&&!$.isFunction(value)){options=$.extend({},config.defaults,options);if(typeof options.expires==='number'){var days=options.expires,t=options.expires=new Date();t.setMilliseconds(t.getMilliseconds()+days*864e+5);}return(document.cookie=[encode(key),'=',stringifyCookieValue(value),options.expires?'; expires='+options.expires.toUTCString():'',options.path?'; path='+options.path:'',options.domain?'; domain='+options.domain:'',options.secure?'; secure':''].join(''));}var result=key?undefined:{},cookies=document.cookie?document.cookie.split('; '):[],i=0,l=cookies.length;for(;i<l;i++){var parts=cookies[i].split('='),name=decode(parts.shift()),cookie=parts.join('=');if(key===name){result=read(cookie,value);break;}if(!key&&(cookie=read(cookie))!==undefined){result[name]=cookie;}}return result;};config.defaults={};$.removeCookie=function(key,options){$.cookie(key,'',$.extend({},options,{expires:-1}));return!$.cookie(key);};}));