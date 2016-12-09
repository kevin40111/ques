
/*
 * load areas
 */

$('select[name=p2s2]').change(function() {
    $("select[name=p2s1]").prop('disabled', true);
    $.getJSON('public/areas', {city_code: this.value}, function(data) {
        console.log(data);
        $('select[name=p2s1]').children('option[value!=-9]').remove();
        for (var i in data.areas) {
            $('select[name=p2s1]').append('<option value="'+data.areas[i].code+'">'+data.areas[i].name+'</option>');
        }
        if (data.areas.length != 0) {
            $("select[name=p2s1]").prop('disabled', false);
        }
    }).error(function(e){
        console.log(e);
    });
});

/*
 * load hight schools
 */

var highSchoolsSets = {p2s8: 'p2s5', p2s7: 'p2s4', p2s6: 'p2s3'};

$('select[name=p2s8],select[name=p2s7],select[name=p2s6]').change(function() {
    var toElement = $('select[name='+highSchoolsSets[this.name]+']');
    toElement.prop('disabled', true);
    $.getJSON('public/highSchools', {city_code: this.value}, function(data) {
        toElement.children('option[value!=-9]').remove();
        for (var i in data.highSchools) {
            toElement.append('<option value="'+data.highSchools[i].code+'">'+data.highSchools[i].name+'</option>');
        }
        if (data.highSchools.length != 0) {
            toElement.prop('disabled', false);
        }
    }).error(function(e){
        console.log(e);
    });
});


/*
 * load categories
 */

$("select[name=p2s15],select[name=p2s13],select[name=p2s11]").prop('disabled', true);
$.getJSON('public/categories', {}, function(data) {
    $('select[name=p2s15]').children('option[value!=-9]').remove();
    $('select[name=p2s13]').children('option[value!=-9]').remove();
    $('select[name=p2s11]').children('option[value!=-9]').remove();
    for (var i in data.categories) {
        $('select[name=p2s15]').append('<option value="'+data.categories[i].code+'">'+data.categories[i].name+'</option>');
        $('select[name=p2s13]').append('<option value="'+data.categories[i].code+'">'+data.categories[i].name+'</option>');
        $('select[name=p2s11]').append('<option value="'+data.categories[i].code+'">'+data.categories[i].name+'</option>');
    }
    if (data.categories.length != 0) {
        $("select[name=p2s15],select[name=p2s13],select[name=p2s11]").prop('disabled', false);
    }
}).error(function(e){
    console.log(e);
});

var categoriesSets = {p2s15: 'p2s14', p2s13: 'p2s12', p2s11: 'p2s10'};

$('select[name=p2s15],select[name=p2s13],select[name=p2s11]').change(function() {
    var toElement = $('select[name='+categoriesSets[this.name]+']');
    toElement.prop('disabled', true);
    $.getJSON('public/departments', {category: this.value}, function(data) {
        toElement.children('option[value!=-9]').remove();
        for (var i in data.departments) {
            toElement.append('<option value="'+data.departments[i].code+'">'+data.departments[i].name+'</option>');
        }
        if (data.departments.length != 0) {
            toElement.prop('disabled', false);
        }
    }).error(function(e){
        console.log(e);
    });
});

