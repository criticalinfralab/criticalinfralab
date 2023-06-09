/*
@licstart
Copyright (C) 2023 Ulrike Uhlig

    The JavaScript code in this page is free software: you can
    redistribute it and/or modify it under the terms of the GNU
    General Public License (GNU GPL) as published by the Free Software
    Foundation, either version 3 of the License, or (at your option)
    any later version.  The code is distributed WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS
    FOR A PARTICULAR PURPOSE.  See the GNU GPL for more details.

    As additional permission under GNU GPL version 3 section 7, you
    may distribute non-source (e.g., minimized or compacted) forms of
    that code without the copy of the GNU GPL normally required by
    section 4, provided you include this license notice and a URL
    through which recipients can access the Corresponding Source.
@licend
*/

jQuery(document).ready(function($) {
    // click publication opens first href found
    $('.section:nth-child(3) .section-content p').each(function() {
       let href = $(this).find('a').attr('href');
       if(href !== undefined) {
           var a = new RegExp('/' + window.location.host + '/');
           if(!a.test(href)) {
               $(this).click(function(event) {
                   event.preventDefault();
                   event.stopPropagation();
                   window.open(href, '_blank');
               });
           } else {
            $(this).addClass("missing-link");
       }
       }
    });

    // open external links in new tab
    $('a').each(function() {
       var a = new RegExp('/' + window.location.host + '/');
       if(!a.test(this.href)) {
           $(this).click(function(event) {
               event.preventDefault();
               event.stopPropagation();
               window.open(this.href, '_blank');
           });
       }
    });

    // show/hide blog posts logic
    $('.item-content').hide();
    $('.item-title').on('click', function() {
        $(this).next('.item-content').slideToggle();
    });
    
    // show/hide publications logic
    var $set = $('.section:nth-child(3) .section-content p');
    if($set.length > 5) {
        $set.slice(5, $set.length).wrapAll('<div class="hidden"/>');
        $set.parent('.section-content').after('<span class="button reveal">see all publications</span>');
        $('.reveal').on('click', function(){
            $(this).parent().find('.hidden').slideToggle();
        });
    }

    // desaturation cookie
    let desaturation_cookie = Cookies.get('desaturate');
    if(desaturation_cookie == "desaturate") {
        $('body').addClass(desaturation_cookie);
        $('#eyecare').text('saturate');
    }
    $('#eyecare').click(function() {
        let value = Cookies.get('desaturate');
        if(value == "desaturate") {
            $('body').removeClass(value);
            $(this).text('desaturate');
            value = "";
        } else {
            value = "desaturate";
            $('body').addClass(value);
            $(this).text('saturate');
        };
        Cookies.set('desaturate', value, { expires: 365 });
    });
});
