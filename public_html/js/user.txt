$(function(){	
	
	var master = new Array();
	
	var email = 	new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
	var address = 	new RegExp(/^[a-zA-Z0-9-\/] ?([a-zA-Z0-9-\/]|[a-zA-Z0-9-\/] )*[a-zA-Z0-9-\/]$/);
	var city =		new RegExp(/^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/);
	var state =		new RegExp(/^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/);
	var country =	new RegExp(/^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/);
	var zip_us =	new RegExp(/(^\d{5}$)|(^\d{5}-\d{4}$)/);
	var zip_can =	new RegExp(/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/);
	var phone =		new RegExp(/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/);
	
	//-----STARTUP CHECKS
	//fist
	var good = $('<i class="fa fa-check" style="color:green;"></i>');
	value = $('#name_first').val();
	if (value.length > 0){
		$(".name_first_check").text('');
		$(".name_first_check").append(good);
	}
	//last
	var good = $('<i class="fa fa-check" style="color:green;"></i>');
	value = $('#name_last').val();
	if (value.length > 0){
		$(".name_last_check").text('');
		$(".name_last_check").append(good);
	}
	//email
	var good = $('<i class="fa fa-check" style="color:green;"></i>');
	value = $('#email').val();
	if (email.test(value)){
		$(".email_check").text('');
		$(".email_check").append(good);
	}
	//address
	var good = $('<i class="fa fa-check" style="color:green;"></i>');
	value = $('#address').val();
	if (address.test(value)){
		$(".address_check").text('');
		$(".address_check").append(good);
	}
	//city
	var good = $('<i class="fa fa-check" style="color:green;"></i>');
	value = $('#city').val();
	if (city.test(value)){
		$(".city_check").text('');
		$(".city_check").append(good);
	}
	//state
	var good = $('<i class="fa fa-check" style="color:green;"></i>');
	value = $('#state').val();
	if (state.test(value)){
		$(".state_check").text('');
		$(".state_check").append(good);
	}
	//country
	var good = $('<i class="fa fa-check" style="color:green;"></i>');
	value = $('#country').val();
	if (country.test(value)){
		$(".country_check").text('');
		$(".country_check").append(good);
	}
	//zip
	var good = $('<i class="fa fa-check" style="color:green;"></i>');
	value = $('#zip').val();
	if (zip_can.test(value)){
		$(".zip_check").text('');
		$(".zip_check").append(good);
	}
	//phone
	var good = $('<i class="fa fa-check" style="color:green;"></i>');
	value = $('#phone').val();
	if (phone.test(value)){
		$(".phone_check").text('');
		$(".phone_check").append(good);
	}
	
	//-----KEYUP
	//-----name_first
	$("#name_first").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value = $('#name_first').val();
		if (value.length > 0){
			$(".name_first_check").text('');
			$(".name_first_check").append(good);
			master[0] = 0;
		}
		else {
			$(".name_first_check").text('');
			$(".name_first_check").append(bad);
			master[0] = 1;
		}
    });
	
	//-----name_last
	$("#name_last").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value = $('#name_last').val();
		if (value.length > 0){
			$(".name_last_check").text('');
			$(".name_last_check").append(good);
			master[1] = 0;
		}
		else {
			$(".name_last_check").text('');
			$(".name_last_check").append(bad);
			master[1] = 1;
		}
    });
	
	//-----pass
	$("#new_pass_confirm").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value1 = $('#new_pass').val();
		value2 = $('#new_pass_confirm').val();
		if (value1 == value2){
			$(".new_pass_confirm_check").text('');
			$(".new_pass_confirm_check").append(good);
			master[9] = 0;
		}
		else {
			$(".new_pass_confirm_check").text('');
			$(".new_pass_confirm_check").append(bad);
			master[9] = 1;
		}
    });
	
	//-----email
	$("#email").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value = $('#email').val();
		if (email.test(value)){
			$(".email_check").text('');
			$(".email_check").append(good);
			master[2] = 0;
		}
		else {
			$(".email_check").text('');
			$(".email_check").append(bad);
			master[2] = 1;
		}
    });
	
	//-----address
	$("#address").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value = $('#address').val();
		if (address.test(value)){
			$(".address_check").text('');
			$(".address_check").append(good);
			master[3] = 0;
		}
		else {
			$(".address_check").text('');
			$(".address_check").append(bad);
			master[3] = 1;
		}
    });
	
	//-----city
	$("#city").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value = $('#city').val();
		if (city.test(value)){
			$(".city_check").text('');
			$(".city_check").append(good);
			master[4] = 0;
		}
		else {
			$(".city_check").text('');
			$(".city_check").append(bad);
			master[4] = 1;
		}
    });
	
	//-----state
	$("#state").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value = $('#state').val();
		if (state.test(value)){
			$(".state_check").text('');
			$(".state_check").append(good);
			master[5] = 0;
		}
		else {
			$(".state_check").text('');
			$(".state_check").append(bad);
			master[5] = 1;
		}
    });
	
	//-----country
	$("#country").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value = $('#country').val();
		if (country.test(value)){
			$(".country_check").text('');
			$(".country_check").append(good);
			master[6] = 0;
		}
		else {
			$(".country_check").text('');
			$(".country_check").append(bad);
			master[6] = 1;
		}
    });
	
	//-----zip
	$("#zip").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value = $('#zip').val();
		if (zip_can.test(value)){
			$(".zip_check").text('');
			$(".zip_check").append(good);
			master[7] = 0;
		}
		else {
			$(".zip_check").text('');
			$(".zip_check").append(bad);
			master[7] = 1;
		}
    });
	
	//-----phone
	$("#phone").keyup(function(){
		var good = $('<i class="fa fa-check" style="color:green;"></i>');
		var bad = $('<i class="fa fa-times" style="color:red;"></i>');
        value = $('#phone').val();
		if (phone.test(value)){
			$(".phone_check").text('');
			$(".phone_check").append(good);
			master[8] = 0;
		}
		else {
			$(".phone_check").text('');
			$(".phone_check").append(bad);
			master[8] = 1;
		}
    });
	
	$("input").keyup(function(){
		var i = 0;
		var count = 0;
		while (i < master.length){
			if (master[i]){
				count += master[i];
			}
			i++;
		}
		if (count > 0){
			$("input[type='submit']").attr('disabled','disabled');
		}
		else {
			$("input[type='submit']").removeAttr('disabled');
		}
	});
	
});