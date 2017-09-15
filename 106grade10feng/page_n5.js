// 父/母親選不適用 跳答
$('input[name=p5s4]').click(function() {
    if ($('input[name=p5s4][value=7]').is(':checked')) {
        $('input[name=p5q1sc1]').attr('checked',false);
        $('input[name=p5q1sc1]').prop('disabled', true);
    } else {
        $('input[name=p5q1sc1]').prop('disabled', false);
    }
});
$('input[name=p5s3]').click(function() {
    if ($('input[name=p5s3][value=7]').is(':checked')) {
        $('input[name=p5q1sc2]').attr('checked',false);
        $('input[name=p5q1sc2]').prop('disabled', true);
    } else {
        $('input[name=p5q1sc2]').prop('disabled', false);
    }
});