$(function(){
	
	setTimeout(function(){
		if (bowser.msie) {
			$('#container').blur();
			$('#popup').slideToggle("fast");
		}
	},3000);

	$("#end").click(function() {
		$('#popup').slideToggle("fast");
	});
	
});