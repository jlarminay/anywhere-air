$(function(){

	$("#org_pass").keyup(function() {
		if ($("#org_pass").val().length > 0) {
			$("#re_pass").slideDown("fast");
		} 
		else {
			$("#re_pass").slideUp("fast");
		}
	});
	
});