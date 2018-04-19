var inputEmail = document.getElementById("email");
var inputPassword = document.getElementById("password");

inputEmail.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById("login").click();
    }
});

inputPassword.addEventListener("keyup", function(event) {
	event.preventDefault();
	if (event.keyCode == 13) {
		document.getElementById("login").click();
	}
});