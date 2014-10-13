jScript.add('typeahead-usersearch', function () {
    var usersDataSet = [
        {value: "Logan Bailey", id: 1},
        {value: "Mitchell McKenna", id: 2},
        {value: "Evan Fribough", id: 3}
    ]

    // constructs the suggestion engine
    var users = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `states` is an array of state names defined in "The Basics"
        local: $.map(usersDataSet, function(user) {
            return user;
        })
    });

    // kicks off the loading/processing of `local` and `prefetch`
    users.initialize();

    var input = $('.user-search'),
        idField = $(input.data('id-selector'));

    input.typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: 'users',
        displayKey: 'value',
        source: users.ttAdapter()
    });

    input
        .on('typeahead:selected', function(event, user) {
            input.data('startingValue', user.value);
            idField.val(user.id);
        })
        .on('typeahead:opened', function() {
            if (input.val() != input.data('startingValue')) {
                idField.val('');
            }
        })
        .on('typeahead:closed', function() {
            if (input.val() != input.data('startingValue')) {
                idField.val('');
            }
        });


}, ['typeahead']);