/**
 * Adds jquery bindings to toggle fields on clicking them
 */
jScript.add('toggle', function() {
    $('.toggleable').on('click', function(e){
        e.preventDefault();
        var link = $(this);

        if (link.data('hideSelector')) {
            $(link.data('hideSelector')).addClass('hidden');
        } else {
            link.addClass('hidden');
        }

        $(link.data('toggleSelector')).removeClass('hidden').addClass('show');
    });
});