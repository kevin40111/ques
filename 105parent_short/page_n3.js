var name_in_db = "";
var replaced_name = '';
$.getJSON('public/name', {
}, function(data) {
    name_in_db = data;
}).error(function(e){
    console.log(e);
});

/*$("#QID_27jo3439").hover(function() {
    var tooltip = $("<div name='tooltip' class='tooltip'>說明：本題目是為了確認填答者身分是否正確，以確保調查結果的正確性，您及小孩的身分將匿名處理，不會被辨識，敬請放心協助確認。</div>");
    $("#QID_27jo3439").append(tooltip);
    },hideTooltip);

function hideTooltip(){
    $('[name=tooltip]').remove();
}

$("#QID_gk8epwfh").hover(function() {
    if ($('input[name=p3s14t3]').val() != '') {
        replaced_name = $('Input[name=p3s14t3]').val();
    }else{
        replaced_name = name_in_db;
    }
    var tooltip2 = $("<div name='tooltip2' class='tooltip'>說明：本份問卷都請根據"+replaced_name+"的情況填答。請儘量由學生之家長或監護人親自填答，勿由他人代答。以維持資料正確性。</div>");
    $("#QID_gk8epwfh").prepend(tooltip2);
    $("#QID_gk8epwfh").children('h4').html('<strong>1-1.</strong> 您是'+replaced_name+'的');
    },hideTooltip2);

function hideTooltip2(){
    $('[name=tooltip2]').remove();
}

$('input[name=p3s14t3]').change(function() {
    if ($('input[name=p3s14t3]').val() != '') {
        replaced_name = $('Input[name=p3s14t3]').val();
    }else{
        replaced_name = name_in_db;
    }
    $("#QID_gk8epwfh").children('h4').html('<strong>1-1.</strong> 您是'+replaced_name+'的');
});*/

$('select[name=p3s5]').change(function() {
    if ($('select[name=p3s5]').val()!='-9') {
        $("select[name=p3s4]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s5]').val()
        }, function(data) {
            $('select[name=p3s4]').children('option[value!=-9]').remove();
            for( var i in data ){
                $('select[name=p3s4] > option[value=-9]').after('<option value="'+i+'">'+data[i]+'</option>');
            }
            $("select[name=p3s4]").prop('disabled', false);
        }).error(function(e){
            console.log(e);
        });
    } else {
        $('select[name=p3s4]').children('option[value!=-9]').remove();
    }
});

$('select[name=p3s2]').change(function() {
    if ($('select[name=p3s2]').val()!='-9') {
        $("select[name=p3s1]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s2]').val()
        }, function(data) {
            $('select[name=p3s1]').children('option[value!=-9]').remove();
            for( var i in data ){
                $('select[name=p3s1] > option[value=-9]').after('<option value="'+i+'">'+data[i]+'</option>');
            }
            $("select[name=p3s1]").prop('disabled', false);
        }).error(function(e){
            console.log(e);
        });
    } else {
        $('select[name=p3s1]').children('option[value!=-9]').remove();
    }
});

$('select[name=p3s11]').change(function() {
    if ($('select[name=p3s11]').val()!='-9') {
        $("select[name=p3s10]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s11]').val()
        }, function(data) {
            $('select[name=p3s10]').children('option[value!=-9]').remove();
            for( var i in data ){
                $('select[name=p3s10] > option[value=-9]').after('<option value="'+i+'">'+data[i]+'</option>');
            }
            $("select[name=p3s10]").prop('disabled', false);
        }).error(function(e){
            console.log(e);
        });
    } else {
        $('select[name=p3s10]').children('option[value!=-9]').remove();
    }
});

$('select[name=p3s8]').change(function() {
    if ($('select[name=p3s8]').val()!='-9') {
        $("select[name=p3s7]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s8]').val()
        }, function(data) {
            $('select[name=p3s7]').children('option[value!=-9]').remove();
            for( var i in data ){
                $('select[name=p3s7] > option[value=-9]').after('<option value="'+i+'">'+data[i]+'</option>');
            }
            $("select[name=p3s7]").prop('disabled', false);
        }).error(function(e){
            console.log(e);
        });
    } else {
        $('select[name=p3s7]').children('option[value!=-9]').remove();
    }
});

$("#QID_s57b6nls").find('table').find('th').css("width","100px");
$("#QID_u0qh1w6u").find('table').find('th').css("width","100px");