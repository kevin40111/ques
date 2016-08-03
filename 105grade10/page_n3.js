
$('select[name=p3s26],select[name=p3s25]').change(function(){    
	if ($('select[name=p3s26]').val()!='-9' && $('select[name=p3s25]').val()!='-9') {        
        $("select[name=p3s23]").prop('disabled', true);
        $.getJSON('public/school', {
            citycode: $('select[name=p3s26]').val(),
            category: $('select[name=p3s25]').val()
        } ,function(data) {
            $("select[name=p3s23]").children('option[value!=-9][value!=999999]').remove();
            for(id in data){
                $('select[name=p3s23] > option[value=-9]').after('<option value="'+id+'">'+data[id]+'</option>');
            }
            $("select[name=p3s23]").prop('disabled', false);
        }).error(function(e){
            console.log(e);
        });
    } else {
        $("select[name=p3s23]").children('option[value!=-9][value!=999999]').remove();
    }
});

$('select[name=p3s20]').change(function() {    
    if ($('select[name=p3s20]').val()!='-9') {
        $("select[name=p3s19]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s20]').val()
        }, function(data) {	
            $('select[name=p3s19]').children('option[value!=-9]').remove();
            for( var i in data ){
                $('select[name=p3s19] > option[value=-9]').after('<option value="'+i+'">'+data[i]+'</option>');
            }
            if (data.length != 0) { $("select[name=p3s19]").prop('disabled', false);}
        }).error(function(e){
            console.log(e);
        });
    } else {
        $('select[name=p3s19]').children('option[value!=-9]').remove();
    }
});

$('select[name=p3s11]').change(function() {    
    if ($('select[name=p3s11]').val()!='-9') {
        $("select[name=p3s10]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s11]').val()
        }, function(data) { 
            $('select[name=p3s10]').children('option[value!=-9]').remove();
            for( var i in data ){
                $('select[name=p3s10] > option[value=-9]').after('<option value="'+i+'">'+data[i]+'</option>');
            }
            if (data.length != 0) { $("select[name=p3s10]").prop('disabled', false);}
        }).error(function(e){
            console.log(e);
        });
    } else {
        $('select[name=p3s10]').children('option[value!=-9]').remove();
    }
});

$('select[name=p3s7]').change(function() {    
    if ($('select[name=p3s7]').val()!='-9') {
        $("select[name=p3s6]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s7]').val()
        }, function(data) { 
            $('select[name=p3s6]').children('option[value!=-9]').remove();
            for( var i in data ){
                $('select[name=p3s6] > option[value=-9]').after('<option value="'+i+'">'+data[i]+'</option>');
            }
            if (data.length != 0) { $("select[name=p3s6]").prop('disabled', false);}
        }).error(function(e){
            console.log(e);
        });
    } else {
        $('select[name=p3s6]').children('option[value!=-9]').remove();
    }
});

$('select[name=p3s3]').change(function() {    
    if ($('select[name=p3s3]').val()!='-9') {
        $("select[name=p3s2]").prop('disabled', true);
        $.getJSON('public/area', {
            citycode: $('select[name=p3s3]').val()
        }, function(data) { 
            $('select[name=p3s2]').children('option[value!=-9]').remove();
            for( var i in data ){
                $('select[name=p3s2] > option[value=-9]').after('<option value="'+i+'">'+data[i]+'</option>');
            }
            if (data.length != 0) { $("select[name=p3s2]").prop('disabled', false);}
        }).error(function(e){
            console.log(e);
        });
    } else {
        $('select[name=p3s2]').children('option[value!=-9]').remove();
    }
});