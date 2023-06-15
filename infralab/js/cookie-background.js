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
    // desaturation cookie
    let desaturation_cookie = Cookies.get('desaturate');
    if(desaturation_cookie == "desaturate") {
        $('body').addClass('desaturated');
        $('#eyecare').text('saturate');
    } else {
        $('body').addClass('saturated');
        $('#eyecare').text('desaturate');
    }
    $('#eyecare').on('click', function(e) {
        e.preventDefault();
        let value = Cookies.get('desaturate');
        if(value == "desaturate") {
            $('body').removeClass('desaturated');
            $('body').addClass('saturated');
            $(this).text('desaturate');
            value = "";
        } else {
            value = "desaturate";
            $('body').removeClass('saturated');
            $('body').addClass('desaturated');
            $(this).text('saturate');
        };
        Cookies.set('desaturate', value, { expires: 365 });
    });
});
