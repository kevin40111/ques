$('input[name=p10q1c4]').click(function() {
	if ($(this).is(':checked')) {
		$('#QID_zx61uqey,#QID_434949yo,#QID_112phyfb').qhide();
	} else {
		$('#QID_zx61uqey,#QID_434949yo,#QID_112phyfb').qshow();
	}
});

var checked_count = 0;
$('#QID_fnmx8apg').children().children().children().not('div').find('input:checkbox').click(function() {
	checked_count = $('#QID_fnmx8apg').children().children().children().not('div').find('input:checkbox:checked').length;
	if (checked_count >= 3) {
		$('#QID_fnmx8apg').children().children().children().not('div').find('input:checkbox').not('input:checkbox:checked,input[name=p10q5c11]').attr('disabled',true);
	} else {
		$('#QID_fnmx8apg').children().find('input:checkbox').attr("disabled", false);
	}
});
