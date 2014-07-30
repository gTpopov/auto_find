$(function(){

   $('ul.list-items .items li').hover(
       function() {
           $(this).css({
               border:'1px solid #dedede',
               background:'#F8F8F8 url("/images/edit.png") right 3px no-repeat'
           });
       },
       function() {
           $(this).css({
               borderTop:'1px solid #ffffff',
               borderLeft:'1px solid #ffffff',
               borderRight:'1px solid #ffffff',
               background:'none'
           });
       }
   );

    $('.dropdown').click(function(){
        $('.change-rate').slideToggle(300);
    });

    $('.tooltip-status').hover(function() {$('.content-tooltip-status').show();},function() {$('.content-tooltip-status').hide();});
    $('.tooltip-condition').hover(function() {$('.content-tooltip-condition').show();},function() {$('.content-tooltip-condition').hide();});
    $('.tooltip-valuta').hover(function() {$('.content-tooltip-valuta').show();},function() {$('.content-tooltip-valuta').hide();});
    $('.tooltip-update').hover(function() {$('.content-tooltip-update').show();},function() {$('.content-tooltip-update').hide();});
    $('.tooltip-rate').hover(function() {$('.content-tooltip-rate').show();},function() {$('.content-tooltip-rate').hide();});

});


