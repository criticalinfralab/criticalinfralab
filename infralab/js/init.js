jQuery(document).ready(function($) {
    // detect scroll for showing the menu (applied via CSS on small screens only)
    var lastScrollTop = 0, delta = 10;
    $(window).scroll(function(){
        var currentScrollTop = $(this).scrollTop();
        // add classes to show or hide the menu
        if(Math.abs(lastScrollTop - currentScrollTop) >= delta){
            if (currentScrollTop > lastScrollTop){
                $('body').removeClass('scrolling-up').addClass('scrolling-down');
            } else {
                $('body').removeClass('scrolling-down').addClass('scrolling-up');
            }
            lastScrollTop = currentScrollTop;
        }
    });

    $(document).click(function() {
        // close search when clicking anywhere outside the header
        $('body').removeClass('search-visible');
        // in some cases, the search box needs to be told to disappear :)
        $('#ajaxsearchliteres1:visible').hide();
    });
    $('.show-tools').click(function(event){
        $('body').toggleClass('search-visible');
        if ($("#ajaxsearchliteres1").css("visibility") === "visible") {
            $('#ajaxsearchliteres1:visible').hide();
        } else {
            $('#ajaxsearchliteres1:visible').show();
        }
        event.preventDefault();
        event.stopPropagation();
        return false;
    });

    $('.simple-links-list a').each(function() {
        $(this).removeAttr('title');
    });

});

// video view count
(function($) {
"use strict";
    function count_views(element) {
        var $video = $(element).find('video');
        console.log($video);
        $video.on("play", function() {
            console.log("Playing event triggered");
            var filesrc = $video.attr('src');
            $.ajax({
                  method: "POST",
                  url: "https://mamanetwork.org/viewcount/viewcount.php",
                  data: { filename: filesrc }
            })
            .done(function(msg) {
                  console.log("Data saved." + msg);
            });
        });
    }
    jQuery(function($) {
        $('.entry').each(function(){
            count_views(this);
        });
    });
})(jQuery);

/* Search and filter functions / isotope */
(function($) {
"use strict";

    function install_things(element) {
        var tags=[];
        var categories=[];

        var $container = $(element).find('.grid');
        $container.isotope({
            itemSelector: '.item',
            //transitionDuration: '0.5s',
            stagger: 30,
        });

        $(element).find('.clearAll').addClass('active');

        $(element).find('a.option').click(function() {
            let combofilters=[]; // temporary array to store the filters
            let comboFilter; // string for isotope with filter contents

            // find container that was clicked
            var $gridcontainer = $(this).parents('.grid-container');
            var gridcontainerName = $gridcontainer.attr('id');
            // use isotope filter only on the container that was clicked
            $container = $gridcontainer.find('.grid');

            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                if($(this).hasClass('tag')) {
                    tags.remove('.'+$(this).attr('data-filter-value'));
                } else {
                    categories.remove('.'+$(this).attr('data-filter-value'));
                }
            } else {
                $(this).addClass('active');
                if($(this).hasClass('tag')) {
                    tags.push('.'+$(this).attr('data-filter-value'));
                    $('.clearAll.tag').removeClass('active'); // do per grid-container
                } else {
                    categories.push('.'+$(this).attr('data-filter-value'));
                    $('.clearAll.categories').removeClass('active'); // do per grid-container
                }
            }

            if(tags.length > 0) {
                for (let tag=0; tag<tags.length; tag++) {
                    if(categories.length > 0) {
                        // combine tags and categories
                        for (let category=0; category<categories.length; category++) {
                            combofilters.push(tags[tag]+categories[category]);
                        }
                    } else {
                        // only push the tag
                        combofilters.push(tags[tag]);
                    }
                }
            } else {
                // only push the category
                for (let category=0; category<categories.length; category++) {
                    combofilters.push(categories[category]);
                }
            }
            comboFilter = combofilters.join(', ');
            $container.isotope({ filter: comboFilter });
        });

        $(element).find('.clearAll.tag').click(function() {
            $(element).find('.option-set a.tag.active').trigger('click');
            $(this).addClass('active');
        });
        $(element).find('.clearAll.categories').click(function() {
            $(element).find('.option-set a.category.active').trigger('click');
            $(this).addClass('active');
        });
    }

    jQuery(function($) {
        $('.grid-container').each(function(){
            install_things(this);
        });
    });

    Array.prototype.remove = function() {
        var what, a = arguments, L = a.length, ax;
        while (L && this.length) {
            what = a[--L];
            while ((ax = this.indexOf(what)) !== -1) {
                this.splice(ax, 1);
            }
        }
        return this;
    };
})(jQuery);
