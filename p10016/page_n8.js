$('#QID_h683g1kh :input').click(function(){
    if ( $('#QID_h683g1kh :input:checked').length > 3 ) {
        alert('限選三個項目');
        $(this).prop('checked', false);
    }
});

$('#QID_x2dophyq :input').click(function(){
    if ( $('#QID_x2dophyq :input:checked').length > 3 ) {
        alert('限選三個項目');
        $(this).prop('checked', false);
    }
});