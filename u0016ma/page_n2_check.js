var patt_email = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
var patt_is_cellphone = /^09+/;
var patt_cellphone = /^09[\d]{8,10}$/;
var patt_home_number = /^[\d#-]{10,20}$/;

if( !patt_email.test($('input[name=p2s4t1]').val()) ) {
    $('#QID_sdeapfxz').parent().addClass('mark');
    alert('常用電子信箱 格式錯誤');
    $scope.disabled = false;
    return false;
}else{
    $('#QID_sdeapfxz').parent().removeClass('mark');
}

if( $('input[name=p2s1c1]:checked').val() == 1 && !patt_cellphone.test($('input[name=p2s3t1]').val()) ) {
    $('#QID_ptf9dsam').parent().addClass('mark');
    alert('手機 格式錯誤');
    $scope.disabled = false;
    return false;
}else{
    $('#QID_ptf9dsam').parent().removeClass('mark');
}
