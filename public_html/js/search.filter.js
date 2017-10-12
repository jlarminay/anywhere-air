$(function(){

	//updated js for continent filter drop down also uncheck countries when continent is checked and unchecks continent when country is checked.

	/* Sort By */
	$('#sort_toggle').click(function() {
		$('#sort_show').slideToggle("fast");
	});
	
	/* Status */
	$('#status_toggle').click(function() {
		$('#status_show').slideToggle("fast");
	});
	
	/* Continent */
	$('#continent_toggle').click(function() {
		$('#continent_show').slideToggle("fast");
	});

	/* Bottle */
	$('#bottle_toggle').click(function() {
		$('#bottle_show').slideToggle("fast");
	});
	
	/* Price */
	$('#price_toggle').click(function() {
		$('#price_show').slideToggle("fast");
	});
	
	/* Weight */
	$('#weight_toggle').click(function() {
		$('#weight_show').slideToggle("fast");
	});
	
	/* -------------------------------------------------------- */
	$("#all_hide").click(function() {
		$('#sort_show').hide("fast");
		$('#status_show').hide("fast");
		$('#continent_show').hide("fast");
		$('#bottle_show').hide("fast");
		$('#price_show').hide("fast");
		$('#weight_show').hide("fast");
		$('#all_show').show();
		$('#all_hide').hide();
	});
	$("#all_show").click(function() {
		$('#sort_show').show("fast");
		$('#status_show').show("fast");
		$('#continent_show').show("fast");
		$('#bottle_show').show("fast");
		$('#price_show').show("fast");
		$('#weight_show').show("fast");
		$('#all_hide').show();
		$('#all_show').hide();
	});
	
	$(".continent u").click(function() {
		$(this).parent().next().slideToggle("fast");
	});

	$(".country li input").change(function() {
		if($(this).val()) {
			$(this).parent().parent().prev().children("input[name='continent']").prop("checked",false);
		}
	});
	
	$(".continent input").change(function() {
		if($(this).val()) {
			$(this).parent().next().find("input[type='checkbox']").prop('checked',false);
		}
	});

});