$(document).ready(function(){
        
    $('input[name="username"]').on('blur', function(){
        
        if($(this).val() === ''){
            $('.helper').fadeIn();
            $('.helper').html('Enter your username.');
        } else {
            $('.helper').fadeOut();
        }
        
    });
    
    $('input[name="password"]').on('blur', function(){
        
        if($(this).val() === ''){
            $('.helper').fadeIn();
            $('.helper').html('Enter your password.');
        } else {
            $('.helper').fadeOut();
        }
    });
    
    $('input[name="username"]').bind('keypress', function(e) {
	if(e.keyCode==13){
		loginAction();
	}
    });
    
    $('input[name="password"]').bind('keypress', function(e) {
	if(e.keyCode==13){
		loginAction();
	}
    });

    $('._loginBtn').on('click', function(){
        
        loginAction();

    });
    
    
    
    function loginAction(){
        
        var userName = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        
        if (userName == '' || password == ''){
            $('.helper').fadeIn();
            $('.helper').html('Username and password cannot be blank.');
        }
        
        
        $.post('login.php', {username:userName, password:password}, function(result){
                      
           result = jQuery.parseJSON(result);
           
           if(result.status != '200'){
            $('.helper').fadeIn();
            $('.helper').html(result.message);
           } else {
               
               $('.helper').fadeOut();
               window.location = 'admin/index.php';
               
           }
            
        });
        
    }

});