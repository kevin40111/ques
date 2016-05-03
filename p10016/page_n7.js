$('#QID_kvzwk8yv :input').click(function(){
    if ( $('#QID_kvzwk8yv :input:checked').length > 3 ) {
        alert('限選三個項目');
        $(this).prop('checked', false);
    }
});