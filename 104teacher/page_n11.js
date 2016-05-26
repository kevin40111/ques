var checked_count_a = 0;
$('#QID_7sy2hu94').children().children().children().not('div').find('input:checkbox').click(function() {
	checked_count_a = $('#QID_7sy2hu94').children().children().children().not('div').find('input:checkbox:checked').length;
	if (checked_count_a >= 3) {
		$('#QID_7sy2hu94').children().children().children().not('div').find('input:checkbox').not('input:checkbox:checked,input[name=p11q2c7]').attr('disabled',true);
	} else {
		$('#QID_7sy2hu94').children().find('input:checkbox').attr("disabled", false);
	}
});

var checked_count_b = 0;
$('#QID_fur5jmyz').children().children().children().not('div').find('input:checkbox').click(function() {
	checked_count_b = $('#QID_fur5jmyz').children().children().children().not('div').find('input:checkbox:checked').length;
	if (checked_count_b >= 3) {
		$('#QID_fur5jmyz').children().children().children().not('div').find('input:checkbox').not('input:checkbox:checked,input[name=p11q3c12]').attr('disabled',true);
	} else {
		$('#QID_fur5jmyz').children().find('input:checkbox').attr("disabled", false);
	}
});