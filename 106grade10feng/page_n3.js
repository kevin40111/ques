// 第4題選都沒有跳過第6題
$('input[name=p3q2c5]').change(function() {
	if ($(this).is(':checked')) {
		$('#QID_ot9i8o1b').qhide();
	} else {
		$('#QID_ot9i8o1b').qshow();
	}
});

$('#QID_a5wcj6tr .flex-50').attr('style', 'max-width: 100%');

// 請選擇置換成 please select
$('option[value="-9"]').html('Please select')

