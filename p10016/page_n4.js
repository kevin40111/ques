$('#QID_qa4jbq9d :input').click(function(){
    if ( $('#QID_qa4jbq9d :input:checked').length > 3 ) {
        alert('限選三個項目');
        $(this).prop('checked', false);
    }
});