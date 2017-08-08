// 父/母親選不適用 跳答
$('input[name=p22s5]').click(function() {
    if ($('input[name=p22s5][value=7]').is(':checked')) {
        $('input[name=p22q1sc1]').attr('checked',false);
        $('input[name=p22q1sc1]').prop('disabled', true);
    } else {
        $('input[name=p22q1sc1]').prop('disabled', false);
    }
});
$('input[name=p22s4]').click(function() {
    if ($('input[name=p22s4][value=7]').is(':checked')) {
        $('input[name=p22q1sc2]').attr('checked',false);
        $('input[name=p22q1sc2]').prop('disabled', true);
    } else {
        $('input[name=p22q1sc2]').prop('disabled', false);
    }
});