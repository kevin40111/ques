$(function(){
	$.getJSON('public/school', function( data ) {
	    if (data.private_school == true) {
	    	$('input[name=p13q4sc11]').attr('disabled',false);
	    } else {
	    	$('input[name=p13q4sc11]').attr('disabled',true);
	    	$('input[name=p13q4sc11]').prop('checked', false);
	    }
	});
});