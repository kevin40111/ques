var checked_count = 0;
$('#QID_7f2vdq5p').children().children().children().not('div').find('input:checkbox').click(function() {
	checked_count = $('#QID_7f2vdq5p').children().children().children().not('div').find('input:checkbox:checked').length;
	if (checked_count >= 3) {
		$('#QID_7f2vdq5p').children().children().children().not('div').find('input:checkbox').not('input:checkbox:checked').attr('disabled',true);
	} else {
		$('#QID_7f2vdq5p').children().find('input:checkbox').attr("disabled", false);
	}
});
