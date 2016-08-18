$('input[name=p12q5sc3][value=10]').attr('checked',false);
$('input[name=p12q5sc3][value=10]').prop('disabled', true);

$('input[name=p12q6sc3][value=6]').attr('checked',false);
$('input[name=p12q6sc3][value=6]').prop('disabled', true);

var giver=['1','2','3'];
$.getJSON('public/care', {}, function(data) {
    if (giver.indexOf(data['p3q2']) != -1) {
        $('input[name=p12q5sc3]').attr('checked',false);
        $('input[name=p12q5sc3]').prop('disabled', true);
        $('input[name=p12q6sc3]').attr('checked',false);
        $('input[name=p12q6sc3]').prop('disabled', true);
    }
}).error(function(e){
    console.log(e);
});

$("#QID_p72qr86u").find('table').find('th').css("width","10px");
$("#QID_643vvune").find('table').find('th').css("width","15px");