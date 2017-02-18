$(function () {

    var select_school_a = $('select[name=p3s5]');
    var select_school_b = $('select[name=p3s2]');

    var load_school_a = function(element) {
        $.getJSON('public/school', {}, function( data ) {
            select_school_a.prop('disabled', true);
            select_school_a.children('option').not('[value=999997],[value=-9]').remove();
            for (var i in data) {
               var option = $('<option value="'+data[i].id+'">'+data[i].name+'</option>');
               select_school_a.children('option[value=999997]').before(option);
            }
            select_school_a.prop('disabled', false);
        });
    }

    var load_school_b = function(element) {
        $.getJSON('public/school', {}, function( data ) {
            select_school_b.prop('disabled', true);
            select_school_b.children('option').not('[value=999997],[value=-9]').remove();
            for (var i in data) {
               var option = $('<option value="'+data[i].id+'">'+data[i].name+'</option>');
               select_school_b.children('option[value=999997]').before(option);
            }
            select_school_b.prop('disabled', false);
        });
    }

    $('input[name=p3s7]').click(function(){
        if ($(this).val() == '5') {
            select_school_a.val('-9');
        }
    });

    $('input[name=p3s4]').click(function(){
        if ($(this).val() == '5' || $(this).val() == '6') {
            select_school_b.val('-9');
        }
    });

    load_school_a();
    load_school_b();

});