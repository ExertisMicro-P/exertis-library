$(document).ready(function(){
   
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            loginAction();

            return false;
        }
    });
    
    $('input[type="text"], input[type="password"]').on('blur', function(){
        
        var value = $(this).val();
        var currField = $(this).attr('placeholder');
        
        if(value == ''){
            $('.helper').html('Please enter '+currField);
            $('.helper').removeClass('success');
            $('.helper').fadeIn();
            
            $('.frontHelper').html('Please enter '+currField);
            $('.frontHelper').removeClass('success');
            $('.frontHelper').fadeIn();
        } else {
            $('.frontHelper').fadeOut();
        }
        
    });
    
    $('._saveUserBtn').on('click', function(){
        
        $(this).fadeOut();
        $('.helper').fadeOut();
        $('.loading').fadeIn();
        
        $.post('insert.php', $('#form').serializeArray(), function(result){
            $('.loading').fadeOut();
            $('._saveUserBtn').fadeIn();
            
           result = jQuery.parseJSON(result);
           
           if(result.status != '200'){
            $('.helper').fadeIn();
            $('.helper').removeClass('success');
            $('.helper').html(result.message);
           } else {
            $('.helper').html(result.message);
            $('.helper').addClass('success');
            $('.helper').fadeIn();
           }
        });
    });
    
    $('._saveEditUserBtn').on('click', function(){
        
        $(this).fadeOut();
        $('.helper').fadeOut();
        $('.loading').fadeIn();
        
        $.post('update.php', $('#form').serializeArray(), function(result){
            
            $('.loading').fadeOut();
            $('._saveEditUserBtn').fadeIn();
            
           result = jQuery.parseJSON(result);
           
           if(result.status != '200'){
            $('.helper').fadeIn();
            $('.helper').removeClass('success');
            $('.helper').html(result.message);
           } else {
            $('.helper').html(result.message);
            $('.helper').addClass('success');
            $('.helper').fadeIn();
           }
        });
    });
    
    
    $('._saveBtn').on('click', function(){
        
        $(this).fadeOut();
        $('.helper').fadeOut();
        $('.loading').fadeIn();
        
        $.post('insert.php', $('#form').serializeArray(), function(result){
            $('.loading').fadeOut();
            $('._saveBtn').fadeIn();
            
           result = jQuery.parseJSON(result);
           
           if(result.status != '200'){
            $('.helper').fadeIn();
            $('.helper').removeClass('success');
            $('.helper').html(result.message);
           } else {
            $('.helper').html(result.message);
            $('.helper').addClass('success');
            $('.helper').fadeIn();
           }
        });
    });
    
    
    $('._saveEditBtn').on('click', function(){
        
        $(this).fadeOut();
        $('.helper').fadeOut();
        $('.loading').fadeIn();
        
        $.post('update.php', $('#form').serializeArray(), function(result){
            
            $('.loading').fadeOut();
            $('._saveEditBtn').fadeIn();
            
           result = jQuery.parseJSON(result);
           
           if(result.status != '200'){
            $('.helper').fadeIn();
            $('.helper').removeClass('success');
            $('.helper').html(result.message);
           } else {
            $('.helper').html(result.message);
            $('.helper').addClass('success');
            $('.helper').fadeIn();
           }
        });
    });
        
    
    $('._accessBtn').on('click', function(){
        loginAction();
    });
    
    
    function loginAction(){
        
        $(this).fadeOut();
        $('.frontHelper').fadeOut();
        $('.frontLoading').fadeIn();
        
        $.post('access.php', $('#form').serializeArray(), function(result){
            
            $('.frontLoading').fadeOut();
            $('._accessBtn').fadeIn();
            
           result = jQuery.parseJSON(result);
           
           if(result.status != '200'){
            $('.frontHelper').fadeIn();
            $('.frontHelper').removeClass('success');
            $('.frontHelper').html(result.message);
           } else {
            $('._accessBtn').fadeOut(100);
            $('.frontHelper').html(result.message);
            $('.frontHelper').addClass('success');
            $('.frontHelper').fadeIn();
            
            setTimeout(function(){
                window.location.href = "files.php";
            }, 1000);
           }
        });
        
    }
    
    
    
});


function randomPwd(){
    
    $.get('/backend/admin/permissions/randomPwd.php', function(result){
       
        $('input[name="password"]').val(result);
        
    });
    
}