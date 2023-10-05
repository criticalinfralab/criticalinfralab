jQuery(function ($) {
    $('.pagination .page-numbers').not('.next').remove();
    $('.pagination .next').html(infralab_string.buttontxt);

    $(document).on('click','.pagination .next',function(e) {
        e.preventDefault();
        var query = JSON.stringify($(this).closest('.pagination').data('query'));
        var maxpages = $(this).closest('.pagination').data('maxpages');
        var current = parseInt($(this).closest('.pagination').data('current'));

        var button = $(this),
            data = {
                'action': 'infralab_load_more',
                'query': query,
                'page' : current,
            };

            $.ajax({
                type: 'POST',
                url: infralab_string.ajaxurl,
                data: data,
                beforeSend: function(xhr) {
                    button.text(infralab_string.buttonload);
                },
                success: function(data) {
                    current++;
                    button.closest('.pagination').before(data);
                    button.closest('.pagination').data('current',current);
                    button.text(infralab_string.buttontxt);
                    if (current == maxpages) {
                        button.remove();
                    }
                },
           });
    });
});
