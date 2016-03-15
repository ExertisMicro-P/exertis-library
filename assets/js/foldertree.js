$(document).ready( function() {
    
        getfilelist();
    
            var checkedSoFar = $("input[type='checkbox']:checked").length;
            $('.checkedSoFar').html('There are '+checkedSoFar+' folders/files checked.');

	$( '#container' ).html( '<ul class="filetree start"><li class="wait">' + 'Generating Tree...' + '<li></ul>' );
	
	getfilelist( $('#container') , '../../files' );
	
	function getfilelist( cont, root ) {
	
		$( cont ).addClass( 'wait' );
			
		$.post( '../../helpers/Foldertree.php', { dir: root }, function( data ) {
                    	
			$( cont ).find( '.start' ).html( '' );
			$( cont ).removeClass( 'wait' ).append( data );
			if( '../../files' == root ) 
				$( cont ).find('UL:hidden').show();
			else 
				$( cont ).find('UL:hidden').slideDown({ duration: 500, easing: null });
			
		});
                
                
	}
        
        
	
	$( '#container' ).on('click', 'LI A', function() {
            
		var entry = $(this).parent();
		
		if( entry.hasClass('folder') ) {
			if( entry.hasClass('collapsed') ) {
						
				entry.find('UL').remove();
				getfilelist( entry, escape( $(this).attr('rel') ));
				entry.removeClass('collapsed').addClass('expanded');
			}
			else {
				
				entry.find('UL').slideUp({ duration: 500, easing: null });
				entry.removeClass('expanded').addClass('collapsed');
			}
		} else {               
                    
                    
		}
	return false;
	});
        
        
        $('#container').on('change', 'input', function(){
            
                    $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
            
                    var checkedSoFar = $("input[type='checkbox']:checked").length;
                    $('.checkedSoFar').html('There are <b>'+checkedSoFar+'</b> folders/files checked.');
        });
        
        


        
        
});