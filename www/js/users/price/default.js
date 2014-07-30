$(function() {
    //$(".accordion h4:first").addClass("active");
    $(".accordion div").hide();
    $(".accordion h4").click(function(){
        $(this).next("div").slideToggle().siblings("div").slideUp();
        $(this).toggleClass("active");
        $(this).siblings("h4").removeClass("active");
    });

    $(".accordion h4").hover(function(){
            //$(this).addClass('hover-active');
            $(this).toggleClass("hover-active");
        },
        function() {            
            //$(this).removeClass('hover-active');
            $(this).toggleClass("hover-active");
        })
});
