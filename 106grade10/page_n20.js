// 帶入地區
n20_32 = $('#QID_ss6hs7cm > h4').html();
n20_33 = $('#QID_gc6iep9k > h4').html();
n20_34 = $('#QID_gmmgh59n > h4').html();
$('input[name=p20s6]').change(function(){
    text = $(this).val() < 21 ? $(this).parent().find('label').text().trim() : '';
    $('#QID_ss6hs7cm > h4').html(n20_32.replace('當地', text+'當地'));
    $('#QID_gc6iep9k > h4').html(n20_33.replace('居住', text+'居住'));
    $('#QID_gmmgh59n > h4').html(n20_34.replace('工作', text+'工作'));
});