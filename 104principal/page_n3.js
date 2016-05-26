$('#lb4').attr('disabled',true);
$('#lb12').attr('disabled',true);

var checked_count = 0;
$('#QID_ev5z6qyn').children().children().children().not('div').find('input:checkbox').click(function() {
	checked_count = $('#QID_ev5z6qyn').children().children().children().not('div').find('input:checkbox:checked').length;
	if (checked_count >= 3) {
		$('#QID_ev5z6qyn').children().children().children().not('div').find('input:checkbox').not('input:checkbox:checked').attr('disabled',true);
	} else {
		$('#QID_ev5z6qyn').children().find('input:checkbox').attr("disabled", false);
	}
});
