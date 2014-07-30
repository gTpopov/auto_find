function repeat_import() {
    $.ajax({
        url: "/users/ajprice/import",
        type: 'get',
        data: {'currency':$('#form-currency input[type="radio"]:checked').val()},
        success: function(data, textStatus){

            if (data == "end") {
                $("#progress-bar .bar").attr('style','width:100%')
                setTimeout(
                    function() {
                        $("#progress-bar").css({display:'none'});
                        $(".qq-upload-button").css({display:'block'});
                        $(".qq-upload-list").html("<li><span class='success'>Импорт успешно завершен</span></li>");
                    }, 1500);
            }
            else if(data == "incorrect") {
                $("#progress-bar").css({display:'none'});
                $(".qq-upload-button").css({display:'block'});
                $(".qq-upload-list").html("<li>Таблица не соответствует формату.</li>");
            }
            else {
                repeat_import();
                var pr = $.cookie('fn');
                (pr!=null)?$("#progress-bar .bar").attr('style','width:'+pr+'%'):$("#progress-bar .bar").attr('style','width:3%');
                (pr!=null)?$(".qq-upload-list .percentUpload").html(pr):$(".qq-upload-list .percentUpload").html('3');
            }
        },
        complete: function(xhr, textStatus){
            if (textStatus != "success") {
                repeat_import();
                var pr = $.cookie('fn');
                (pr!=null)?$("#progress-bar .bar").attr('style','width:'+pr+'%'):$("#progress-bar .bar").attr('style','width:3%');
                (pr!=null)?$(".qq-upload-list .percentUpload").html(pr):$(".qq-upload-list .percentUpload").html('3');
            }
        },
        beforeSend: function() {
            $("#progress-bar .progress-striped").css({display:'block'});
            $(".qq-upload-button").css({display:'none'});
            $(".qq-upload-list").css({borderTop:'1px solid #C3C3C3'}).html("<li><span>Идет импорт данных (<span class='percentUpload'>3</span>%). Это может занят несколько минут.</span></li>");
            $("#progress-bar .bar").attr('style','width:3%');
        }
    });
}


