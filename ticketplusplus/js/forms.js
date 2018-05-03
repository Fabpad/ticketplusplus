function formhash(form, password) {
    // Erstelle ein neues Feld für das gehashte Passwort. 
    var p = document.createElement("input");
 
    // Füge es dem Formular hinzu. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Sorge dafür, dass kein Text-Passwort geschickt wird. 
    password.value = "";
 
    // Reiche das Formular ein. 
    form.submit();
}

function changepwhash(form, old_pw, new_pw, new_pw_conf) {
	//Erstelle Elemente für die gehashten Passwörter.
	var op = document.createElement("oldPW");
	var np = document.createElement("newPW");
	var npc = document.createElement("newPWC");
	
	//Formular hinzufügen
	form.appendChild(op);
	form.appendChild(np);
	form.appendChild(npc);
	op.name = "op";
	op.type = "hidden";
	op.value = hex_sha512(old_pw.value);
	
	np.name = "np";
	np.type = "hidden";
	np.value = hex_sha512(new_pw.value);
	
	npc.name = "npc";
	npc.type = "hidden";
	npc.value = hex_sha512(new_pw_conf.value);
	
	old_pw.value = "";
	new_pw.value = "";
	new_pw_conf.value = "";
	
	form.submit();
}
 
function regformhash(form, uid, email, password, conf, role) {
     // Überprüfe, ob jedes Feld einen Wert hat
    if (uid.value == ''         || 
          email.value == ''     || 
          password.value == ''  || 
          conf.value == ''		||
		  role == 'Berechtigung des Nutzers...') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
	// Überprüfe den Benutzernamen
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.username.focus();
        return false; 
    }
 
    // Überprüfe, dass Passwort lang genug ist (min 6 Zeichen)
    // Die Überprüfung wird unten noch einmal wiederholt, aber so kann man dem 
    // Benutzer mehr Anleitung geben
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }
 
    // Mindestens eine Ziffer, ein Kleinbuchstabe und ein Großbuchstabe
    // Mindestens sechs Zeichen 
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }
 
    // Überprüfe die Passwörter und bestätige, dass sie gleich sind
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
 
    // Erstelle ein neues Feld für das gehashte Passwort.
    var p = document.createElement("input");
 
    // Füge es dem Formular hinzu. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Sorge dafür, dass kein Text-Passwort geschickt wird. 
    password.value = "";
    conf.value = "";
 
    // Reiche das Formular ein. 
    form.submit();
    return true;
}

$(document).ready(function () {
	$("#category_menu").change(function () {
	var val = $(this).val();
		
		$.post('../includes/query_specifications.php', {kategorie: `${val}`}).done(function (resp) {
			 $("#specification_menu").html(`${resp}`);
		});
	});
});

function showChangePassword(){
	var x = document.getElementById("changePasswordForm");
	if(x.style.display == "none"){
		x.style.display = "block";
	} else {
		x.style.display = "none";
	}
}

function createnewticket(form, betreff, beschreibung, user, status, priority, category, specification) {
	alert(betreff.value);
	alert(beschreibung.value);
	alert(user.value);
	alert(status);
	alert(priority);
	alert(category);
	alert(specification);
	form.submit();
    return true;
}