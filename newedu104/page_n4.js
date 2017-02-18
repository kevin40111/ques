var _class = [];
    $.getJSON('public/class', {}, function( data ) {
        // $('#QID_04v0b3on .flex-50 md-checkbox')[0].remove()
        /*if(data.p3q2c1 == 1) {$('#QID_04v0b3on .flex-50 md-checkbox')[0].hide()}
        if(data.p3q2c2 == 1) {$('#QID_04v0b3on .flex-50 md-checkbox')[1].remove()}
        if(data.p3q2c3 == 1) {$('#QID_04v0b3on .flex-50 md-checkbox')[2].remove()}
        if(data.p3q2c4 == 1) {$('#QID_04v0b3on .flex-50 md-checkbox')[3].remove()}*/
        console.log(data);
        console.log($('#QID_04v0b3on .flex-50 md-checkbox'));
        /*console.log($('#QID_04v0b3on .flex-50 md-checkbox')[2]);
        console.log($('#QID_04v0b3on .flex-50 md-checkbox')[3]);*/
    });
    // console.log($('#QID_04v0b3on input').prop('checked', true));
  // $('#QID_04v0b3on .flex-50 md-checkbox').remove();

$('input[name=p4q2]').click(function() {
    $('#QID_04v0b3on .flex-50 md-checkbox').trigger( "click" , function() {
        alert();
    });
    /*$.getJSON('public/class', {}, function( data ) {
        console.log(data.);
        data.p3q2c1 == 1 ? $('input[name=p4s1c1']).prop('disabled', true) : null;
        data.p3q2c2 == 1 ? $('input[name=p4s1c1']).prop('disabled', true) : null;
        data.p3q2c3 == 1 ? $('input[name=p4s1c1']).prop('disabled', true) : null;
        data.p3q2c4 == 1 ? $('input[name=p4s1c1']).prop('disabled', true) : null;
    });*/
});

// $('#QID_04v0b3on').children().children('#lb0').prop('checked', true)
// console.log($('#QID_04v0b3on').children().children('#lb0').prop('checked', true));
// $('#lb0').prop('checked', true);
