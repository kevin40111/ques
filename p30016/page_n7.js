$('#QID_j2j54t9m :input').click(function(){
    if ( $('#QID_j2j54t9m :input:checked').length > 3 ) {
        alert('限選三個項目');
        $(this).prop('checked', false);
    }
});