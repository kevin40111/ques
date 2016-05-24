$(function () {
    var input_school = [];

    for (var i = 2; i <= 6; i++) {
        for (var j = 1; j <= 3; j++) {
            input_school.push('input[name=p4q'+i+'t'+j+']'); 
        }
    }

    var reload_school = function() {
        $.getJSON('public/school', function( data ) {
            var option = '<option value="-9">請選擇</option>';
            for (var i in data) {
                option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            var count = 0;
            for(var i in input_school) {
                count++;
                if (count > 3) {count = 1;}
                $(input_school[i]).css({"position": "absolute", "z-index": "-100","left":"-999999px"});
                $(input_school[i]).after('<label>第'+count+'所 : </label><select name="s'+i+'">'+option+'</select>');
                $('select[name=s'+i+']').change(function() {
                    var num         = $(this).attr('name').split('s')[1];
                    var selected    = $(this).find('option:selected');
                    set_school(input_school[num],selected);
                });
            } 
        });
    }

    var set_school = function (to,source) {
        var school = source.text();
        if (source.val() == '-9') {
            school = '';
        }
        $(to).val(school);
        $(to).trigger("change");
    }

    reload_school();
});

