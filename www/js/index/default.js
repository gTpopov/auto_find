$(function(){
    $("#searchMain").autocomplete("/ajax/query", {
        delay:10,
        minChars:2,
        matchSubset:1,
        autoFill:true,
        matchContains:1,
        cacheLength:1,
        selectFirst:true,
        formatItem:liFormatQuery,
        maxItemsToShow:10
    });

    $("#list-city").autocomplete("/ajax/city", {
        delay:10,
        minChars:2,
        matchSubset:1,
        autoFill:true,
        matchContains:1,
        cacheLength:1,
        selectFirst:true,
        formatItem:liFormatCity,
        maxItemsToShow:3,
        //width:245,
        extraParams: {act:"listCity"}
    });

    $("#list-country").change(function(){
        selectItem(this.value);
        $('#list-city').val('');
    });

});

function liFormatQuery (row, i, num) {

    var result = "<a href='void(0)' onclick='document.location.href=\"/index/index?q="+row[0]+"\"'>" + row[0] + "</a>"+" "+"<span class='qnt'>"+row[1]+" результ(ов)</span>";
    return result;
}

function selectItem(id) {
    $.ajax({
        url: "/ajax/idcountry",
        type: 'get',
        dataType: "json",
        cashe: false,
        data: {'country_id':id,'act':'country_id'}
    });
}
// city
function liFormatCity (row, i, num)
{
    var result = row[0]+' ('+row[1]+')';
    return result;
}

//Limit chars
function isNotMax(e){
    e = e || window.event;
    var target = e.target || e.srcElement;
    var code=e.keyCode?e.keyCode:(e.which?e.which:e.charCode)

    switch (code){
        case 13:
        case 8:
        case 9:
        case 46:
        case 37:
        case 38:
        case 39:
        case 40:
        return true;
    }

    return target.value.length <= target.getAttribute('maxlength');
}

function CalculateChars(TextElementId, CaptionElementId) {
    var s = document.getElementById(TextElementId).value;
    document.getElementById(CaptionElementId).innerHTML = 500-s.length;
}

