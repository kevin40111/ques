$(function(){
    var disableQues = function() {
        $.getJSON('public/disableQues', function( data ) {
        	if (data) {
        		$('input[name=p8q1sc9]').prop('disabled',true);
        		$('input[name=p8q1sc10]').prop('disabled',true);
        		$('input[name=p8q1sc11]').prop('disabled',true);
        		$('input[name=p8q1sc12]').prop('disabled',true);
        	}
        });
    }

    disableQues();
});
