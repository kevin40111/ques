var patt_email = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
var patt_is_cellphone = /^09+/;
var patt_cellphone = /^09[\d]{8,10}$/;
// var patt_home_number = /^[\d#-]{10,20}$/;
//var patt_home_number = /\(\d{2}\)\d{6,8}/;

if( (!patt_email.test($('input[name=p6q4t2]').val()) && $('input[name=p6q4t2]').val() != "") && (!patt_cellphone.test($('input[name=p6q4t1]').val()) && $('input[name=p6q4t1]').val() != "")) {
    $('#QID_bt0s26ld').parent().addClass('mark');
    alert('「電子信箱」與「手機」 格式錯誤');
    return false;
}else if( !patt_email.test($('input[name=p6q4t2]').val()) && $('input[name=p6q4t2]').val() != ""){
    $('#QID_bt0s26ld').parent().addClass('mark');
    alert('電子信箱 格式錯誤');
    return false;
}else if( !patt_cellphone.test($('input[name=p6q4t1]').val()) && $('input[name=p6q4t1]').val() != "" ){
	$('#QID_bt0s26ld').parent().addClass('mark');
	alert('手機 格式錯誤');
    return false;
}else{
	$('#QID_bt0s26ld').parent().removeClass('mark');
}
