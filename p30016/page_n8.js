$('#QID_p1i9cwrv :input').click(function(){
    if ( $('#QID_p1i9cwrv :input:checked').length > 3 ) {
        alert('限選三個項目');
        $(this).prop('checked', false);
    }
});

$('#QID_scpvnidc :input').click(function(){
    if ( $('#QID_scpvnidc :input:checked').length > 3 ) {
        alert('限選三個項目');
        $(this).prop('checked', false);
    }
});