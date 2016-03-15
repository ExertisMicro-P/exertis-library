$(function() {
    //----- OPEN
    $('[data-popup-open]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
 
        e.preventDefault();
    });
 
    //----- CLOSE
    $('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
 
        e.preventDefault();
    });
});

$(document).ready(function() {
    $('.toggle-nav').click(function(e) {
        $(this).toggleClass('active');
                
        var status = $('.nav-ul').attr('data-status');
        
        if(status != 'active'){
        
            $('.nav-ul').slideDown(500);
            $('.nav-ul').attr('data-status', 'active');
            
        } else {
            
            $('.nav-ul').slideUp();
            $('.nav-ul').attr('data-status', '');
            
        }
        
    });
});