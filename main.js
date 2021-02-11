
//validate that the two passwords match
function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('passreg');
    var pass2 = document.getElementById('confpassreg');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    if(pass1.value === pass2.value){
        //The passwords match. 
        pass2.style.backgroundColor = goodColor;
        return true;
    }else{
        //The passwords do not match.
        pass2.style.backgroundColor = badColor;
        return false;
    }
}


function register(){
    
    var xhr = new XMLHttpRequest();
	var data = new FormData(document.querySelector('form[data-form="form-1"]'));
		
	xhr.open("POST", "php/register.php", false);
	xhr.setRequestHeader("Cache-Control", "no-cache, no-store, max-age=60");
	xhr.addEventListener("readystatechange", function() {
	    
		if(xhr.readyState === 4 && xhr.status === 200) {
			if(xhr.responseText === "true") {
				alert("Your account has been succesfully created");//if login succesfull redirect to view list of documents
			}
			else {
				alert("This email already exists on our DB"); //if login is unsuccesfull alert and stay on the same page.
			}
		}
	});
	xhr.send(data);
}
// Function To send login Credential to server
function login(){
    var xhr = new XMLHttpRequest();
	var data = new FormData(document.querySelector('form[data-form="form-2"]'));
	xhr.open("POST", "php/login.php",true);
	//xhr.setRequestHeader("Cache-Control", "no-cache, no-store, max-age=30");
	xhr.addEventListener("readystatechange", function() {
		if(xhr.readyState === 4 && xhr.status === 200) {
		    //alert(xhr.responseText);
		    //window.location.assign = "doclist.php";
			if(xhr.responseText === "true") {
			    //console.log('responseText:', xhr.responseText);
				window.location.replace("doclist.php"); //if login succesfull redirect to view list of documents
			}
			else {
				alert("Incorrect username or password"); //if login is unsuccesfull alert and stay on the same page.
			}
		}
	});
	xhr.send(data);
    

}

//function to logout calls the server to delete the Session variable
function logout() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "php/logout.php", true);
	xhr.addEventListener("readystatechange", function() {
		if(xhr.readyState === 4 && xhr.status === 200) {
			window.location = "index.php";
		}
	});
	xhr.send();
}
