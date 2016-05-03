$('#QID_frsnep5q :input').click(function(){
    if ( $('#QID_frsnep5q :input:checked').length > 3 ) {
        alert('限選三個項目');
        $(this).prop('checked', false);
    }
});