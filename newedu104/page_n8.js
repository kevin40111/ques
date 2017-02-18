$('input[name=p8q2sc1]').click(function() {
    if ($(this).val() == '7') {
        $('input[name=p8q3sc1]').prop('disabled', true);
    } else {
        $('input[name=p8q3sc1]').prop('disabled', false);
    }
});

$('input[name=p8q2sc2]').click(function() {
    if ($(this).val() == '7') {
        $('input[name=p8q3sc2]').prop('disabled', true);
    } else {
        $('input[name=p8q3sc2]').prop('disabled', false);
    }
});


