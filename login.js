function loginValidation(event)
{
	const minimumPasswordLength = 8;
	
    var usernameInput = document.forms.loginForm.loginUsername.value;
	var passwordInput = document.forms.loginForm.loginPassword.value;
	
	var result = true;
	
	var usernamePattern = /^\w+$/;
	var passwordPattern = /^(\S*)?\d+(\S*)?$/;
	
	document.getElementById("usernameMessageLogin").innerHTML ="";
    document.getElementById("passwordMessageLogin").innerHTML ="";

    
    if ( (usernameInput == "") || (usernameInput == null) || (!usernamePattern.test(usernameInput)) )
    {
    	document.getElementById("usernameMessageLogin").innerHTML="Username not found. Try again or create an account! <br>";
    	result = false;
    }
    
    if ( (passwordInput == "") || (passwordInput == null) || (passwordInput.length < minimumPasswordLength) || (!passwordPattern.test(passwordInput)) ) 
    {
    	document.getElementById("passwordMessageLogin").innerHTML="Wrong password. Try again! <br>";
        result = false;
    }
    
    if(result == false)
    {    
        event.preventDefault();
    }
}