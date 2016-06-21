var patt_email = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
var patt_is_cellphone = /^09+/;
var patt_cellphone = /^09[\d]{8,10}$/;
// var patt_home_number = /^[\d#-]{10,20}$/;
var patt_home_number = /\(\d{2}\)\d{6,8}/;

if( !patt_email.test($('input[name=p2q1t1]').val()) ) {
    $('#QID_f18j1n67').parent().addClass('mark');
    alert('電子信箱 格式錯誤');
    return false;
}else{
    $('#QID_f18j1n67').parent().removeClass('mark');
}

if (!patt_cellphone.test($('input[name=p2s2t1]').val()) && $('input[name=p2s2t1]').val() != "") {
    $('#QID_xhrehm0m').parent().addClass('mark');
    alert('手機 格式錯誤');
    return false;
}else{
    $('#QID_xhrehm0m').parent().removeClass('mark');
}

if (!patt_home_number.test($('input[name=p2s1t1]').val()) && $('input[name=p2s1t1]').val() != "") {
    $('#QID_xhrehm0m').parent().addClass('mark');
    alert('室內電話 格式錯誤');
    return false;
}else{
    $('#QID_xhrehm0m').parent().removeClass('mark');
}
