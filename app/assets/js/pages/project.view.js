/**
 * Adds jquery bindings to toggle fields on clicking them
 */
jScript.add('project.view', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function csrfSafeClick(element, cb)  {
        element.on('click', function(e) {
            e.preventDefault();

            if (element.hasClass('disabled')) {
                return true;
            }

            element.addClass('disabled');

            $.ajax( element.attr('href'), {
                type: "PUT"
            }).always(function(jqXHR, status) {
                element.removeClass('disabled');
                cb(jqXHR, status);
            });
        });
    }

    var toggle = function() {
        $('#watch-project, #unwatch-project').toggleClass('hidden');
    };

    csrfSafeClick($('#watch-project'), toggle);
    csrfSafeClick($('#unwatch-project'), toggle);
});