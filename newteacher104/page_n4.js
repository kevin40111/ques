$(function () {
    var radio_type    = $('input[name=p4q1]');
    var select_school = $('select[name=p4s1]');
    
    var reload_school = function(element) {
        $.getJSON('public/school', function( data ) {
            element.children('option').not('[value=999999],[value=-9]').remove();
            for (var i in data) {
                var option = $('<option value="'+data[i].id+'">'+data[i].name+'</option>');
                element.children('option[value=999999]').before(option);
            }
        });
    }
    
    radio_type.click(function() {   
        reload_school(select_school);
    });

});

