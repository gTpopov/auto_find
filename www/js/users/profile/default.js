$(function(){

    $('.mainInfo').hover(function(){$(".main-info").fadeIn(300);},function(){$(".main-info").fadeOut(300);});
    $('.securityInfo').hover(function(){$(".security-info").fadeIn(300);},function(){$(".security-info").fadeOut(300);});
    $('.emailInfo').hover(function(){$(".email-info").fadeIn(300);},function(){$(".email-info").fadeOut(300);});
    $('.logoInfo').hover(function(){$(".logo-info").fadeIn(300);},function(){$(".logo-info").fadeOut(300);});

    $('.mainInfo').click(function(){
        $('#personaDataEdit,.dl-mainInfo').slideToggle(300);

        if($('.mainInfo img').attr('src')=='/images/redactGrey.png') {
            $('.mainInfo img').attr('src','/images/saveAcceptGrey.png');
        } else {
            $('.mainInfo img').attr('src','/images/redactGrey.png');
        }
    });

    $('.securityInfo').click(function(){
        $('#securityDataEdit,.dl-securityInfo').slideToggle(300);

        if($('.securityInfo img').attr('src')=='/images/redactGrey.png') {
            $('.securityInfo img').attr('src','/images/saveAcceptGrey.png');
        } else {
            $('.securityInfo img').attr('src','/images/redactGrey.png');
        }
    });

    $('.emailInfo').click(function(){
        $('#emailDataEdit,.dl-emailInfo').slideToggle(300);

        if($('.emailInfo img').attr('src')=='/images/redactGrey.png') {
            $('.emailInfo img').attr('src','/images/saveAcceptGrey.png');
        } else {
            $('.emailInfo img').attr('src','/images/redactGrey.png');
        }
    });


    $('.logoInfo').click(function(){
        $('#logoDataEdit,.dl-logoInfo').slideToggle(300);

        if($('.logoInfo img').attr('src')=='/images/redactGrey.png') {
            $('.logoInfo img').attr('src','/images/saveAcceptGrey.png');
        } else {
            $('.logoInfo img').attr('src','/images/redactGrey.png');
        }
    });


    function str_rand() {
        var result       = '';
        var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        var max_position = words.length - 1;
        for( i = 0; i < 10; ++i ) {
            position = Math.floor ( Math.random() * max_position );
            result = result + words.substring(position, position + 1);
        }
        return result;
    }
    $('.showPassword').click(function(){
        var inputPsw = $('#password');
        if (inputPsw.attr('type') == 'password') {
            document.getElementById('password').setAttribute('type', 'text');
        } else {
            document.getElementById('password').setAttribute('type', 'password');
        }
    });
    $('.generatePassword').click(function() {
        document.getElementById('password').setAttribute('type', 'text');
        $('#password').attr('value', str_rand());
    });

});