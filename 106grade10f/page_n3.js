// 產生第二題 就讀學校
$('select[name=p3s12],select[name=p3s11]').change(function(){
	if ($('select[name=p3s12]').val()!='-9' && $('select[name=p3s11]').val()!='-9') {
        $("select[name=p3s9]").prop('disabled', true);
        $.getJSON('public/school', {
            citycode: $('select[name=p3s12]').val(),
            category: $('select[name=p3s11]').val()
        } ,function(data) {
            $("select[name=p3s9]").children('option[value!=-9][value!=999999]').remove();
            for(id in data){
                $('select[name=p3s9] > option[value=-9]').after('<option value="'+id+'">'+data[id]+'</option>');
            }
            $("select[name=p3s9]").prop('disabled', false);
        }).error(function(e){
            console.log(e);
        });
    } else {
        $("select[name=p3s9]").children('option[value!=-9][value!=999999]').remove();
    }
});
// 產生 3-2 居住地址
$('select[name=p3s6]').change(function() {
    if ($('select[name=p3s6]').val()!='-9') {
        $("select[name=p3s5]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s6]').val()
        }, function(data) {
            $('select[name=p3s5]').children('option[value!=-9]').remove();
            for( var i in data ){
                $('select[name=p3s5] > option[value=-9]').after('<option value="'+i+'">'+data[i]+'</option>');
            }
            if (data.length != 0) { $("select[name=p3s5]").prop('disabled', false);}
        }).error(function(e){
            console.log(e);
        });
    } else {
        $('select[name=p3s5]').children('option[value!=-9]').remove();
    }
});
// 第4題選都沒有跳過第6題
$('input[name=p3q2c5]').change(function() {
	if ($(this).is(':checked')) {
		$('#QID_ot9i8o1b').qhide();
	} else {
		$('#QID_ot9i8o1b').qshow();
	}
});

$('#QID_a5wcj6tr .flex-50').attr('style', 'max-width: 100%');