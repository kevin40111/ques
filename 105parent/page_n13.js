$('input[name=p13q1sc3][value=15]').attr('checked',false);
$('input[name=p13q1sc3][value=15]').prop('disabled', true);

var giver=['1','2','3'];
$.getJSON('public/care', {}, function(data) {
    if (giver.indexOf(data['p3q2']) != -1) {
        $('input[name=p13q1sc3]').attr('checked',false);
        $('input[name=p13q1sc3]').prop('disabled', true);
    }
}).error(function(e){
    console.log(e);
});

$("#QID_2tw6jg2j").hover(function() {
    var tooltip = $("<div id='tooltip' class='tooltip2'>說明：為何要問收入?收入是基本分析資料，任何單位絕對無法辨識您個人所填的答案，敬請放心據實填答。</div>");
    tooltip.appendTo($("#QID_2tw6jg2j"));
    },hideTooltip);

function hideTooltip(){
    $("#tooltip").fadeOut().remove();
}