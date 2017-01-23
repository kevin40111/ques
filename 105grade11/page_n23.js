
$('input[name=p23q1]').click(function() {
    var disabled = $(this).val() == 7;
    $('input[name=p23q5sc1]').prop('disabled', disabled);
});

$('input[name=p23q2]').click(function() {
    var disabled = $(this).val() == 7;
    $('input[name=p23q5sc2]').prop('disabled', disabled);
});