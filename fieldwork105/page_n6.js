$(function () {
    var select_city        = $('select[name=p6s8]');
    var select_area        = $('select[name=p6s6]');
    var select_ps          = $('select[name=p6s4]');
    var select_stage       = $('select[name=p6s5]');
    var select_school      = $('select[name=p6s2]');

    var load_school = function() {
        if (select_city.val() == -9 || select_area.val() == -9 || select_ps.val() == -9 || select_stage.val() == -9 ) return;
        select_school.prop('disabled', true);
        $.getJSON('public/school', {ps: select_ps.val(), stage: select_stage.val(), city: select_city.val(), area: select_area.val()}, function( data ) {
            select_school.children('option').not('[value=9999997],[value=-9]').remove();
            for (var i in data) {
                var option = $('<option value="'+i+'">'+data[i]+'</option>');
                select_school.children('option[value=9999997]').before(option);
            }
            select_school.prop('disabled', false);
        });
    }

    var load_area = function() {
        if (select_city.val() == -9) return;
        select_area.prop('disabled', true);
        $.getJSON('public/area', {city: select_city.val()}, function( data ) {
            select_area.children('option').not('[value=-9]').remove();
            for (var i in data) {
                var option = $('<option value="'+i+'">'+data[i]+'</option>');
                select_area.children('option[value=-9]').after(option);
            }
            select_area.prop('disabled', false);
        });
    }

    select_city.change(function() {
        load_school();
    });

    select_area.change(function() {
        load_school();
    });

    select_ps.change(function() {
        load_school();
    });

    select_stage.change(function() {
        load_school();
    });

    select_city.change(function() {
        load_area();
    });
});