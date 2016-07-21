changeCountry('');

$('input[name=p16s8]').change(function(){
	var country = $(this).val() != '21' ? $(this).parent().find('label').text().trim() : '';
	changeCountry(country);
});

$('input[name=p16s9t1]').keyup(function(){
	var country = $(this).val();
	changeCountry(country);
});

function changeCountry(country) {
	$('#QID_dca0f4al').children('h4').html('<strong>3-2.</strong>請問你是否會講'+country+'當地的官方語言');
	$('#QID_qjlcbnx8').children('h4').html('<strong>3-3.</strong>請問你是否曾到'+country+'居住或拜訪？');
	$('#QID_sc3aj02t').children('h4').html('<strong>3-4.</strong>請問你將來是否有意願到'+country+'工作或求學？');
}