$(function(){
	
	if ($.cookie('error') != null){
		var num = ($.cookie('error'));
		
		if (num == '1'){
			var error = 'Error 001 \nUsername and/or Password Incorrect'
		}
		else if (num == '2'){
			var error = 'Error 002 \nIncorrect Query To MySQL'
		}
		else if (num == '3'){
			var error = 'Error 003 \nPasswords Do Not Match'
		}
		else if (num == '4'){
			var error = 'Error 004 \nUsername and/or Email Already In Use'
		}
		else if (num == '5'){
			var error = 'Error 005 \nMySQL Insert Failed'
		}
		else if (num == '6'){
			var error = 'Error 006 \nNo Master Password Entered'
		}
		else if (num == '7'){
			var error = 'Error 007 \nMaster Password Incorrect'
		}
		else if (num == '8'){
			var error = 'Error 008 \nMySQL Injection Detected'
		}
		else {
			var error = 'Error 000 \nError With The Error Message'
		}
		
		alert(error);
		document.cookie = 'error=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/~comp19900/;';

	}
	
});