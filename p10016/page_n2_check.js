var patt_email = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
var patt_is_cellphone = /^09+/;
var patt_cellphone = /^09[\d]{8,10}$/;
var patt_home_number = /^[\d#-]{10,20}$/;

if( !patt_email.test($('input[name=p2q1t1]').val()) ) {
    $('#QID_sw8az1zb').parent().addClass('mark');
    alert('電子信箱 格式錯誤');
    return false;
}else{
    $('#QID_sw8az1zb').parent().removeClass('mark');
}

if (!patt_home_number.test($('input[name=p2q1t2]').val()) ) {
    $('#QID_sw8az1zb').parent().addClass('mark');
    alert('手機或室內電話 格式錯誤');
    return false;
}else{
    $('#QID_sw8az1zb').parent().removeClass('mark');
}
