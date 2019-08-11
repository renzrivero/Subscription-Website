function signupValidation(event){
	var result = true;
	
	var username = document.forms.signupForm.username.value;
	var password = document.forms.signupForm.password.value;
    var confirmPassword = document.forms.signupForm.confirmPassword.value;
    var email = document.forms.signupForm.email.value;
    var confirmEmail = document.forms.signupForm.confirmEmail.value;
	
	const minPasswordLength = 8;
	
	var usernamePattern = /^\w+$/;
    var passwordPattern = /^(\S*)?\d+(\S*)?$/;
    var emailPattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
	
	document.getElementById("usernameMessage").innerHTML ="";
	document.getElementById("passwordMessage").innerHTML ="";
    document.getElementById("confirmPasswordMessage").innerHTML ="";
    document.getElementById("emailMessage").innerHTML ="";
    document.getElementById("confirmEmailMessage").innerHTML ="";
		
	if ( (username==null) || (username=="") || (!usernamePattern.test(username)) ) 
	{  
	    document.getElementById("usernameMessage").innerHTML="Please enter the correct username format (No spaces or other non-word characters)<br>";
	    result = false;
    }
	

	if ( (password.length < minPasswordLength) || (!passwordPattern.test(password)) ) 
	{
		document.getElementById("passwordMessage").innerHTML="Please enter the password correctly (8 characters long, at lease one non-letter)<br>";
		result = false;
	}

	if (confirmPassword != password) 
	{
		document.getElementById("confirmPasswordMessage").innerHTML= "The confirmed password should be the same as the password given above<br>";
		result = false;
	}
	
	if ( (email==null) || (email=="") || (!emailPattern.test(email)) ) 
	{	
		document.getElementById("emailMessage").innerHTML="Please enter a valid email address (username@somewhere.sth)<br>";
		result = false;
    }
    
    if (confirmEmail != email) 
	{
		document.getElementById("confirmEmailMessage").innerHTML= "The confirmed email should be the same as the email given above<br>";
		result = false;
	}
			
	if(result == false)
    {    
        event.preventDefault();
    }
}