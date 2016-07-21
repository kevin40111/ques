changeCountry('');

$('input[name=p17q1]').change(function(){
	var country = $(this).val() != '21' ? $(this).parent().find('label').text().trim() : '';
	changeCountry(country);
});

$('input[name=p17s2t1]').keyup(function(){
	var country = $(this).val();
	changeCountry(country);
});

function changeCountry(country) {
	$('#QID_dh73sv2g').children('h4').html('<strong>3-8.</strong> 請問你是否會講'+country+'當地的官方語言');
	$('#QID_vgx2u72i').children('h4').html('<strong>3-9.</strong> 請問你是否曾到'+country+'居住或拜訪？');
	$('#QID_le82n9oa').children('h4').html('<strong>3-10.</strong> 請問你將來是否有意願到'+country+'工作或求學？');
}