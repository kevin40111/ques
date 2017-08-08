// 帶入地區
n21_38 = $('#QID_hkz7e64u > h4').html();
n21_39 = $('#QID_flb6wmbf > h4').html();
n21_310 = $('#QID_762pge11 > h4').html();
$('input[name=p21s6]').change(function(){
    text = $(this).val() < 21 ? $(this).parent().find('label').text().trim() : '';
    $('#QID_hkz7e64u > h4').html(n21_38.replace('當地', text+'當地'));
    $('#QID_flb6wmbf > h4').html(n21_39.replace('居住', text+'居住'));
    $('#QID_762pge11 > h4').html(n21_310.replace('工作', text+'工作'));
});