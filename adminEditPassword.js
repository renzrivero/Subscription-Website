function signupValidation(event){
	var result = true;
	
	var password = document.forms.signupForm.password.value;
	
	const minPasswordLength = 8;
	
    var passwordPattern = /^(\S*)?\d+(\S*)?$/;
	
	document.getElementById("passwordMessage").innerHTML ="";
		

	if ( (password.length < minPasswordLength) || (!passwordPattern.test(password)) ) 
	{
		document.getElementById("passwordMessage").innerHTML="Please enter the password correctly (8 characters long, at lease one non-letter)<br>";
		result = false;
	}
			
	if(result == false)
    {    
        event.preventDefault();
    }
}