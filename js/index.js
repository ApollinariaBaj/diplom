$(document).ready(function() {
    $(this).run();
});

var popupShow = function(options) {
    
    var popup = $('#popup').get(0);
    var shadow = $('#shadow').get(0);
    
    $('#popup-m-i', popup).html(options.data);
    
    $(shadow).height($(document).height());
    $(popup).css({'top':$(window).scrollTop()+25,'left':parseInt(($(window).width()-$(popup).width())/2)});
    
    if ($.browser.msie == true) {
        $(shadow).show();
        $(popup).show();
    }
    else {
        $(shadow).fadeIn('slow');
        $(popup).fadeIn('slow');
    }
    
    $(popup).run();
    
}

var popupHide = function() {
    
    var popup = $('#popup').get(0);
    var shadow = $('#shadow').get(0);
    
    if ($.browser.msie == true) {
        $(shadow).hide();
        $(popup).hide();
    }
    else {
        $(shadow).fadeOut('slow');
        $(popup).fadeOut('slow');
    }
    
}

var tooltipShow = function(options) {
    
    var tooltip = $('#tooltip').clone().removeAttr('id').insertAfter('#tooltip').get(0);
    
    $('.tooltip-content-m', tooltip).html(options.data);
    
    var h = $(tooltip).height();
    var x = options.event.pageX - 50;
    var y = options.event.pageY - h - 15;
    var timeout = 3000;
    
    if ($.browser.msie == true) {
        $(tooltip).css({'top':y,'left':x}).show(10, function() {
            setTimeout(function() {
                $(tooltip).hide(10, function() {
                    $(tooltip).remove();
                });
            }, timeout);
        });
    }
    else {
        $(tooltip).css({'top':y,'left':x}).fadeIn('slow', function() {
            setTimeout(function() {
                $(tooltip).fadeOut('slow', function() {
                    $(tooltip).remove();
                });
            }, timeout);
        });
    }
    
}

jQuery.fn.run = function() {
    
    var context = this;
    
    $.ifixpng('/img/blank.gif');
    $('*:not(.noifixpng)', context).ifixpng();
    
    $('.text:not(.active) .text-hidden', context).hide();
    
    if (window.location.hash != null) {
        $("a[name='" + window.location.hash.substring(1) + "']", context).parents('.text').toggleClass('active').children('.text-hidden').slideToggle('slow');
    }
    
    $('.text .text-toggle a', context).click(
        function() {
            $(this).parents('.text').toggleClass('active').children('.text-hidden').slideToggle('slow');
            return false;
        }
    );

    $('.popup', context).click(function(e) {
        var url = $(this).attr('popup');
        if (!url) {
            url = $(this).attr('href');
        }
        if (!url) {
            return false;
        }
        $.get(url, {'template':'96'}, function(data) {
            popupShow({'data':data,'event':e});
        });
        return false;
    });

    $('#popup-c', context).click(function(e) {
        popupHide();
        return false;
    });
    
    $('.image-change', context).click(
        function() {
            var href = $(this).attr('href');
            var name = $(this).attr('name');
            var popup = $(this).attr('popup');
            //$('.model-zoom a').attr('href', popup);
            if (href == null || name == null) {
                return false;
            }
            $(this).parent().trigger('click');
            $(name).fadeOut('fast', function() {
                $(name).attr('src', href).load(function() {
                    //var p = parseInt(($(this).parent().height() - $(this).height()) / 2);
                    //if (p > 0) {
                    //    $(this).css({'paddingTop':p,'paddingBottom':p});
                    //}
                    $(name).fadeIn('fast');
                });
            });
            return false;
        }
    );
    
    $(window, context).scroll(function(e) {
        $('#popup').dequeue().animate({'top':$(window).scrollTop() + 25,'left':parseInt(($(window).width() - $('#popup').width()) / 2)}, 'slow');
    });
    
    $(window, context).resize(function(e) {
        $('#shadow').height($(document).height())/*.width($(window).width())*/;
        $('#popup').dequeue().animate({'top':$(window).scrollTop() + 25,'left':parseInt(($(window).width() - $('#popup').width()) / 2)}, 'slow');
    });
    
    $('.scrollable', context).scrollable({'size':3,'next':'.scroll-next','prev':'.scroll-prev','speed':'slow'});
    
    $('.focus-blur', context).each(function() {
        $(this).attr('default', $(this).val());
        $(this).bind('focus',function() {
            if ($(this).val() == $(this).attr('default')) {
                $(this).val('');
            }
        });
        $(this).bind('blur',function() {
            if ($(this).val() == '') {
                $(this).val($(this).attr('default'));
            }
        });
    });
    
    $('.form-submit', context).click(function() {
        $(this).parents('form').submit();
        return false;
    });
    
    $('.ajax-form-submit', context).click(function(e) {
        $(this).parents('form').ajaxForm({
            'success':function(data) {
                tooltipShow({'data':data,'event':e});
            }
        }).submit();
        return false;
    });
    
    /*$('#popup-m-i form', context).ajaxForm({
        'target':'#popup-m-i',
        'data':{'template':'96'},
        'success':function() {
            $(context).run();
        }
    });*/
    
    $('.recalc-cart').click(
        function() {
            $(this).parents('tr').find('input').val(0);
            $(this).parents('form').submit();
            return false;
        }
    );
    
    $('.add-to-cart').click(function(e) {
        $(this).parents('form').ajaxForm({
            'success':function(data) {
                tooltipShow({'data':data,'event':e});
                $('#head-cart').load('/netcat/modules/default/netshop.php', {'action':'cart'}, function() {
                    ;
                });
            }
        }).submit();
        return false;
    });
    
    $('#region-select').change(function() {
        $(this).parents('form').ajaxForm({
            'success':function(data) {
                $('#region-total').html(data);
            }
        }).submit();
        return false;
    });
    
    $('label[for^=rbDeliveryMethod]').parent().siblings().hide();
    
    $('input[name=f_DeliveryMethod][checked=checked]').each(function() {
        $('label[for='+$(this).attr('id')+']').parent().siblings().show();
    });
    
    $('input[name=f_DeliveryMethod]').click(function() {
        $('label[for^=rbDeliveryMethod]').parent().siblings().slideUp('slow');
        $('label[for='+$(this).attr('id')+']').parent().siblings().slideToggle('slow');
    });
    
    $('label[for^=rbPaymentMethod]').parent().siblings().hide();
    
    $('input[name=f_PaymentMethod][checked=checked]').each(function() {
        $('label[for='+$(this).attr('id')+']').parent().siblings().show();
    });
    
    $('input[name=f_PaymentMethod]').click(function() {
        $('label[for^=rbPaymentMethod]').parent().siblings().slideUp('slow');
        $('label[for='+$(this).attr('id')+']').parent().siblings().slideToggle('slow');
    });
    
    $('input, select, textarea', context).change(function() {
        var name = $(this).attr('name');
        var val = $(this).val();
        var elem = this;
        $('form [name='+name+']').not(elem).each(function() {
            $(this).val(val);
        });
    });
    
    $('#menu-i > ul > li', context).hover(function() {
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
    }, function() {
        $(this).removeClass('active');
    });
    
    $('.submenu:has(ul.c2)').each(function(e) {
        $ul = $('.submenu-m > ul', this);
        html = "";
        var n = 5;
        for (i = 1; i <= n; i+= 1) {
            htmli = "";
            $('> li:nth-child('+n+'n+'+i+')', $ul).each(function() {
                htmli += "<li>"+$(this).html()+"</li>";
            });
            html += "<td class='td"+i+"'><ul>"+htmli+"</ul></td>";
        }
        $('.submenu-m', this).html("<table class='c2'><tbody><tr height='15'><td colspan='"+n+"' class='td"+n+"'></td></tr><tr>"+html+"</tr><tr height='10'><td colspan='"+n+"' class='td"+n+"'></td></tr></tbody></table>");
        $(this).css({'width':'auto'});
        $('.submenu-m', this).css({'width':'auto'});
    });
    
    return this;
    
};