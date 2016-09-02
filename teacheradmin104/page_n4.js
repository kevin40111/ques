$(function () {
    var num = 0;
    var count = 0;
    var ques = [];
    for (var i = 2; i <= 6; i++) {
        var inputs = [];
        var selects = [];
        for (var j = 1; j <= 3; j++) {
            inputs.push('input[name=p4q'+i+'t'+j+']');
            selects.push('s'+count);
            count ++;
        }
        ques[num] = {};
        ques[num].inputs = inputs;
        ques[num].selects = selects;
        num ++;
    }

    var load_school = function() {
        $.getJSON('public/school', function( data ) {
            var option = '<option value="-9">請選擇</option>';
            for (var i in data) {
                option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            var count = 0;
            var x = 0;
            for(var i in ques) {
                for(var j in ques[i].inputs) {
                    count++;
                    if (count > 3) {count = 1;}
                    $(ques[i].inputs[j]).css({"position": "absolute", "z-index": "-100","left":"-999999px"});
                    $(ques[i].inputs[j]).after('<label>第'+count+'所 : </label><select name="s'+x+'" data="'+ques[i].inputs[j]+'">'+option+'</select>');
                    $('select[name=s'+x+']').change(function() {
                        var input      = $(this).attr('data');
                        var selected   = $(this).find('option:selected');
                        set_school(input,selected,option);
                    });
                    x++;
                }
            }
        });
    }

    var set_school = function (input,selected,option) {
       ;
        var school = selected.val();
        $(input).val(school);
        $(input).trigger("change");

        disable_school(input,option);
    }
    var disable_school = function (input,option) {
        var key = 0;
        for (var i in ques) {
            for (var j in ques[i].inputs) {
                if (ques[i].inputs[j] == input) {
                    key = i;
                    break;
                }
            }
        }
        for (var i in ques[key].inputs) {
            $('select[name="'+ques[key].selects[i]+'"] option').removeAttr('disabled');
        }

        for (var i in ques[key].inputs) {
            var elem1 = $('select[name="'+ques[key].selects[i]+'"]');
            for (var j = 0 ; j < ques[key].inputs.length; j++) {
                if (ques[key].inputs[i] != ques[key].inputs[j] && elem1.val() != '-9') {
                    $('select[name="'+ques[key].selects[j]+'"] option[value=' + elem1.val() + ']').prop('disabled',true);
                }
            }
        }
    }

    load_school();
});

