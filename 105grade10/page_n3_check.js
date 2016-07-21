var patt_email = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;

if ($('input[name=p3s21]:checked').val()==1) {
    if (!patt_email.test($('input[name=p3s22t1]').val())) {
        alert('email 格式錯誤');
        return false;
    }
}