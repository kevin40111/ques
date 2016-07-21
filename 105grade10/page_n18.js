$('input[name=p18s5]').click(function() {
    if ($('input[name=p18s5][value=7]').is(':checked')) {
        $('input[name=p18q1sc1]').attr('checked',false);
        $('input[name=p18q1sc1]').prop('disabled', true);
    } else {
        $('input[name=p18q1sc1]').prop('disabled', false);
    }
});

$('input[name=p18s4]').click(function() {
    if ($('input[name=p18s4][value=7]').is(':checked')) {
        $('input[name=p18q1sc2]').attr('checked',false);
        $('input[name=p18q1sc2]').prop('disabled', true);
    } else {
        $('input[name=p18q1sc2]').prop('disabled', false);
    }
});