
$(':input[name=p11q1c3],:input[name=p11q1c4]').change(function() {
    if ($(this).is(':checked')) {
        $('#QID_2y4l2moo,#QID_syxxm351,#QID_ddyx9wij,#QID_9bt8itz2').qhide();
    }
});

$(':input[name=p11q1c1],:input[name=p11q1c2]').change(function() {
    if ($(this).is(':checked')) {
        $('#QID_2y4l2moo,#QID_syxxm351,#QID_ddyx9wij,#QID_9bt8itz2').qshow();
    }
});
