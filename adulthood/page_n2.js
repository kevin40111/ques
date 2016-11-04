
var heads = $("#QID_m5ewlwcv thead tr:first th:gt(1)");
$("#QID_2ddl8by6").find("thead tr:first").append(heads);


$("#QID_2ddl8by6 thead tr:first th").css('width', '15px').css('vertical-align', 'top').css('padding', '2px');
$("#QID_2ddl8by6 thead tr:first th:eq(5)").css('border-right', '2px solid #555');

$("#QID_2ddl8by6 thead").prepend(
    '<tr><th></th><th></th>'+
    '<th colspan="4" style="text-align: left;vertical-align: top;width:120px;padding:10px;border-right: 2px solid #555">A.您覺得以下每個要素對於成年有多重要</th>'+
    '<th colspan="3" style="text-align: left;vertical-align: top;width:100px;padding:10px">B.請指出成年要素符合您目前現況之程度</th></tr>');


var gg = $("#QID_m5ewlwcv").find("tbody tr");

$("#QID_2ddl8by6").find("tbody tr").each(function(index, tr) {
    $(tr).find('td:last').css('border-right', '2px solid #555');
    gg.eq(index).children('td:gt(1)').each(function(j, td) {
        $(tr).append(td);
    });   
});

$("#QID_m5ewlwcv").parent().css('display', 'none');

