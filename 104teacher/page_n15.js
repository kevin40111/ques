$('input[name=p15q1c4]').click(function() {
	if ($(this).is(':checked')) {
		$('#QID_glaieybj,#QID_u7p9eaaq,#QID_hzffkgjd,#QID_q159dj1p').qhide();
	} else {
		$('#QID_glaieybj,#QID_u7p9eaaq,#QID_hzffkgjd,#QID_q159dj1p').qshow();
	}
});