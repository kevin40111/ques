$('#QID_04v0b3on .flex-50 md-checkbox')[0].id = 'mdbx1'
$('#QID_04v0b3on .flex-50 md-checkbox')[1].id = 'mdbx2'
$('#QID_04v0b3on .flex-50 md-checkbox')[2].id = 'mdbx3'
$('#QID_04v0b3on .flex-50 md-checkbox')[3].id = 'mdbx4'

$('input[name=p4q2]').click(function() {
    $.getJSON('public/class', {}, function( data ) {
        if(data.p3q2c1 == 1) {$('#mdbx1').attr('disabled', true)}
        if(data.p3q2c2 == 1) {$('#mdbx2').attr('disabled', true)}
        if(data.p3q2c3 == 1) {$('#mdbx3').attr('disabled', true)}
        if(data.p3q2c4 == 1) {$('#mdbx4').attr('disabled', true)}
    });
});
