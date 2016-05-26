$(function(){
	$.getJSON('public/school', function( data ) {
	    if (data.private_school == true) {
	    	$('input[name=p10q2sc9]').attr('disabled',false);
	    } else {
	    	$('input[name=p10q2sc9]').attr('disabled',true);
	    	$('input[name=p10q2sc9]').prop('checked', false);
	    }
	});
});