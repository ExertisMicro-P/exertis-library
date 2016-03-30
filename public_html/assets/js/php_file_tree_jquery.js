$(document).ready( function() {
    var checkedSoFar = $("input[type='checkbox']:checked").length;
    $('.checkedSoFar').html('There are '+checkedSoFar+' folders/files checked.');
	
	// Hide all subfolders at startup
	$(".php-file-tree").find("UL").hide();
	
	// Expand/collapse on click
	$(".pft-directory A").click( function() {
		$(this).parent().find("UL:first").slideToggle("medium");
                
		if( $(this).parent().attr('className') == "pft-directory" ) { return false };
	});
        

        $("input[type='checkbox']").change(function () {
            $(this).siblings('ul')
                .find("input[type='checkbox']")
                .prop('checked', this.checked);
        
            var checkedSoFar = $("input[type='checkbox']:checked").length;
            $('.checkedSoFar').html('There are '+checkedSoFar+' folders/files checked.');
        });


        $("#foldersandfiles :checkbox").click(function(e) {
            var checked = $(this).is(':checked');
            var li = $(this).closest('li');
            li.css("font-weight", checked ? "700" : "400");
        });

});
