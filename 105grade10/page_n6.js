var checked_count = 0;
$('#QID_kr55g0d5').children().children().children().not('div').find('input:checkbox').click(function() {
	checked_count = $('#QID_kr55g0d5').children().children().children().not('div').find('input:checkbox:checked').length;
	if (checked_count >= 3) {
		$('#QID_kr55g0d5').children().children().children().not('div').find('input:checkbox').not('input:checkbox:checked').attr('disabled',true);
	} else {
		$('#QID_kr55g0d5').children().find('input:checkbox').attr("disabled", false);
	}
});