$('#QID_ddypceu8 :input').click(function(){
    if ( $('#QID_ddypceu8 :input:checked').length > 3 ) {
        alert('限選三個項目');
        $(this).prop('checked', false);
    }
});