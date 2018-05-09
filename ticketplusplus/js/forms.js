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

function changepwhash(form, old_pw, new_pw, new_pw_conf, username) {
	//Erstelle Elemente für die gehashten Passwörter.
	var op = document.createElement("input");
	var np = document.createElement("input");
	var npc = document.createElement("input");
	var user = document.createElement("input");

	if (old_pw.value == ''         || 
          new_pw.value == ''     || 
          new_pw_conf.value == '') {
 
        alert('Bitte füllen Sie alle Felder aus.');
        return false;
    }
	
	//Formular hinzufügen
	form.appendChild(op);
	form.appendChild(np);
	form.appendChild(npc);
	form.appendChild(user);
	
	op.name = "op";
	op.type = "hidden";
	op.value = hex_sha512(old_pw.value);
	
	np.name = "np";
	np.type = "hidden";
	np.value = hex_sha512(new_pw.value);
	
	npc.name = "npc";
	npc.type = "hidden";
	npc.value = hex_sha512(new_pw_conf.value);
	
	user.name = "user";
	user.type = "hidden";
	user.value = username.value;
	
	old_pw.value = "";
	new_pw.value = "";
	new_pw_conf.value = "";
	showChangePassword();
	
	form.submit();
	return true;
}
 
function regformhash(form, uid, email, password, conf, role) {
     // Überprüfe, ob jedes Feld einen Wert hat
    if (uid.value == ''         || 
          email.value == ''     || 
          password.value == ''  || 
          conf.value == ''		||
		  role == 'Berechtigung des Nutzers...') {
 
        alert('Bitte füllen Sie alle Felder aus.');
        return false;
    }
 
	// Überprüfe den Benutzernamen
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("Der Benutzername darf nur Buchstaben, Zahlen und Unterstriche enthalten."); 
        form.username.focus();
        return false; 
    }

    if(form.username.value.length > 30) {
        alert("Der Benutzername darf nur maximal 30 Zeichen enthalten. Bitte versuche es erneut."); 
        form.username.focus();
        return false; 
    }
 
    // Überprüfe, dass Passwort lang genug ist (min 6 Zeichen)
    // Die Überprüfung wird unten noch einmal wiederholt, aber so kann man dem 
    // Benutzer mehr Anleitung geben
    if (password.value.length < 6) {
        alert('Das Passwort muss mindestens 6 Zeichen lang sein.');
        form.password.focus();
        return false;
    }
 
    // Mindestens eine Ziffer, ein Kleinbuchstabe und ein Großbuchstabe
    // Mindestens sechs Zeichen 
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Das Passwort muss mindestens eine Zahl, einen Kleinbuchstaben und einen Großbuchstaben enthalten.');
        return false;
    }
 
    // Überprüfe die Passwörter und bestätige, dass sie gleich sind
    if (password.value != conf.value) {
        alert('Die beiden Passwörter stimmen nicht überein.');
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

function createnewticket(form, betreff, beschreibung, user, status, priority, category, specification, agent) {
	if (betreff.value == ''                         || 
          beschreibung.value == ''                  || 
          user.value == ''                          || 
          status == '--- Bitte wählen ---'		    ||
          priority == ' --- Bitte wählen --- '		||
          category == ' --- Bitte wählen --- '		||
          specification == ' --- Bitte wählen --- ' ||
		  agent.value == '') {
 
        alert('Bitte füllen Sie alle Felder aus.');
        return false;
    }
	
	form.submit();
    return true;
}