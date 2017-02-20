$(function () {

    $('#QID_hmvnr480 .flex-50 md-checkbox')[5].id = 'p3q4c5';
    $('#QID_hmvnr480 .flex-50 md-checkbox')[7].id = 'p3q4c7';
    $('#QID_hmvnr480 .flex-50 md-checkbox')[10].id = 'p3q4c10';
    $('#p3q4c5').attr('style', 'width: 700px');
    $('#p3q4c7').attr('style', 'width: 700px');
    $('#p3q4c10').attr('style', 'width: 700px');

    var select_school_a = $('select[name=p3s5]');
    var select_school_b = $('select[name=p3s2]');

    var load_school_a = function(value) {
        select_school_a.prop('disabled', true);
        $.getJSON('public/school', {value: value}, function( data ) {
            select_school_a.children('option').not('[value=999997],[value=-9]').remove();
            for (var i in data) {
               var option = $('<option value="'+data[i].id+'">'+data[i].name+'</option>');
               select_school_a.children('option[value=999997]').before(option);
            }
            select_school_a.prop('disabled', false);
        });
    }

    var load_school_b = function(value) {
        select_school_b.prop('disabled', true);
        $.getJSON('public/school', {value: value}, function( data ) {
            select_school_b.children('option').not('[value=999997],[value=-9]').remove();
            for (var i in data) {
               var option = $('<option value="'+data[i].id+'">'+data[i].name+'</option>');
               select_school_b.children('option[value=999997]').before(option);
            }
            select_school_b.prop('disabled', false);
        });
    }

    $('input[name=p3s7]').click(function(){
        var value = $(this).val();
        if (value <= '4') {
            load_school_a(value);
        } else {
            select_school_a.val('-9');
        }
    });

    $('input[name=p3s4]').click(function(){
        var value = $(this).val();
        if (value <= '4') {
            load_school_b(value);
        } else {
            select_school_b.val('-9');
        }
    });

});