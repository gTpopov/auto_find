/*
$(function(){
    $(".list-city").autocomplete("/ajax/city", {
        delay:10,
        minChars:2,
        matchSubset:1,
        autoFill:true,
        matchContains:1,
        cacheLength:1,
        selectFirst:true,
        formatItem:liFormatCity,
        maxItemsToShow:7,
        //width:245,
        extraParams: {act:"listCity"}
    });

    $("#list-country").change(function(){
        selectItem(this.value);
        $('#list-city').val('');
    });

});
function selectItem(id) {
    $.ajax({
        url: "/ajax/idcountry",
        type: 'get',
        dataType: "json",
        cashe: false,
        data: {'country_id':id,'act':'country_id'}
    });
}
function liFormatCity (row, i, num)
{
    var result = row[0]+' ('+row[1]+')';
    return result;
}
*/
