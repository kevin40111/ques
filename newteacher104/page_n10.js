$('input[name=p10q4sc1]').click(function() {
    if ($('input[name=p10q4sc1][value=6]').is(':checked')) {
        $('input[name=p10q5sc1]').attr('checked',false);
        $('input[name=p10q5sc1]').prop('disabled', true);
    } else {
        $('input[name=p10q5sc1]').prop('disabled', false);
    }
});

$('input[name=p10q4sc2]').click(function() {
    if ($('input[name=p10q4sc2][value=6]').is(':checked')) {
        $('input[name=p10q5sc2]').attr('checked',false);
        $('input[name=p10q5sc2]').prop('disabled', true);
    } else {
        $('input[name=p10q5sc2]').prop('disabled', false);
    }
});