// 產生第二題 就讀學校
$('select[name=p3s13],select[name=p3s12]').change(function(){
	if ($('select[name=p3s13]').val()!='-9' && $('select[name=p3s12]').val()!='-9') {
        $("select[name=p3s10]").prop('disabled', true);
        $.getJSON('public/school', {
            citycode: $('select[name=p3s13]').val(),
            category: $('select[name=p3s12]').val()
        } ,function(data) {
            $("select[name=p3s10]").children('option[value!=-9][value!=999999]').remove();
            for(id in data){
                $('select[name=p3s10] > option[value=-9]').after('<option value="'+id+'">'+data[id]+'</option>');
            }
            $("select[name=p3s10]").prop('disabled', false);
        }).error(function(e){
            console.log(e);
        });
    } else {
        $("select[name=p3s10]").children('option[value!=-9][value!=999999]').remove();
    }
});
// 產生 3-2 居住地址
$('select[name=p3s7]').change(function() {
    if ($('select[name=p3s7]').val()!='-9') {
        $("select[name=p3s5]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s7]').val()
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