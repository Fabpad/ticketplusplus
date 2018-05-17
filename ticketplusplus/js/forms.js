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

    if(form.username.value.length < 4) {
        alert("Der Benutzername muss mindestens 4 Zeichen enthalten. Bitte versuche es erneut."); 
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
    
    $("#ticketOverview").tablesorter();
    
	$("#nightmodeinput").ready(function () {
        if (sessionStorage.nightMode == '0') {
            if (document.getElementById('nightmodeinput')){
                document.getElementById('nightmodeinput').value = 'OFF';
            }
        }
        else if (sessionStorage.nightMode == '1'){
            if (document.getElementById('nightmodeinput')){
                document.getElementById('nightmodeinput').value = 'ON';
            }
        }
        else {
            if (document.getElementById('nightmodeinput')){
                document.getElementById('nightmodeinput').value = 'OFF';   // Default
            }
        }
    })
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

function tktTable(){
	var tktFilt = document.getElementById('ticketfilter');
	var val1 = tktFilt.options[tktFilt.selectedIndex].id;
	var tktSear = document.getElementById('searchtxt');
	var val2 = tktSear.value;

	location.replace("http://localhost/ticketoverview.php?filter=" + val1 + "&ftsearch=" + val2);
}	

function sortTktOv(orderby) {
	var table, rows, switching, i, x, y, shouldSwitch, forward;
	table = document.getElementById("ticketOverview");
	switching = true;
	/*Make a loop that will continue until
	no switching has been done:*/
	while (switching) {
		//start by saying: no switching is done:
		switching = false;
		rows = table.getElementsByTagName("TR");
		/*Loop through all table rows (except the
		first, which contains table headers):*/
		for (i = 1; i < (rows.length - 1); i++) {
			//start by saying there should be no switching:
			shouldSwitch = false;
			/*Get the two elements you want to compare,
			one from current row and one from the next:*/
			x = rows[i].getElementsByTagName("TD")[orderby];
			y = rows[i + 1].getElementsByTagName("TD")[orderby];
			//check if the two rows should switch place:
			if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
				//if so, mark as a switch and break the loop:
				shouldSwitch= true;
				break;
			}
		}
		if (shouldSwitch) {
			/*If a switch has been marked, make the switch
			and mark that a switch has been done:*/
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
		}
	}
}

function toggle_night_mode(){
    if(Number(sessionStorage.nightMode)=='0'){
        sessionStorage.nightMode='1';
        night_mode();
    }
    else{
        sessionStorage.nightMode='0';
        night_mode();
    }
}

function night_mode(){
    if(Number(sessionStorage.nightMode)=='0'){
        document.documentElement.style.setProperty('--main-bg',"#FFFFFF");
        document.documentElement.style.setProperty('--main-nav',"#FFFFFF");
        document.documentElement.style.setProperty('--text',"rgba(0, 0, 0, 1");
        document.documentElement.style.setProperty('--nav',"rgba(0, 0, 0, 0.5)");
        document.documentElement.style.setProperty('--nav-hover',"rgba(0, 0, 0, 0.7)");
        document.documentElement.style.setProperty('--nav-active',"rgba(0, 0, 0, 0.9)");
        document.documentElement.style.setProperty('--border',"1px solid rgba(0, 0, 0, .125)");
        document.documentElement.style.setProperty('--input',"#FFFFFF");
        document.documentElement.style.setProperty('--table',"#dddddd");
        if (document.getElementById('nightmodeinput')){
            document.getElementById('nightmodeinput').value = 'OFF';
        }
   }
   else{
        document.documentElement.style.setProperty('--main-bg',"#252526");
        document.documentElement.style.setProperty('--main-nav',"#1E1E1E");
        document.documentElement.style.setProperty('--text',"rgba(255, 255, 255, 1)");
        document.documentElement.style.setProperty('--nav',"rgba(255, 255, 255, 0.5)");
        document.documentElement.style.setProperty('--nav-hover',"rgba(255, 255, 255, 0.7)");
        document.documentElement.style.setProperty('--nav-active',"rgba(255, 255, 255, 0.9)");
        document.documentElement.style.setProperty('--border',"1px solid rgba(255, 255, 255, .125)");
        document.documentElement.style.setProperty('--input',"#333333");
        document.documentElement.style.setProperty('--table',"#606060");
        if (document.getElementById('nightmodeinput')){
            document.getElementById('nightmodeinput').value = 'ON';
        }
   }
}

function changeuser(form, userid, username, uservorname, usernachname, dept, role, telnr, email) {
    if (    username == ''      || 
            uservorname == ''   || 
            usernachname == ''  || 
            telnr == ''		    ||
            email == '') {
 
        alert('Bitte füllen Sie alle Felder aus.');
        return false;
    }

    var chadel = document.createElement("input");
    form.appendChild(chadel);
    chadel.name = "change";
    chadel.type = "hidden";
    chadel.value = "TEST";

	form.submit();
    return true;
}

function deleteuser(form, userid) {

    var chadel = document.createElement("input");
    
    form.appendChild(chadel);
    chadel.name = "delete";
    chadel.type = "hidden";
    chadel.value = "TEST";

    form.submit();
    return true; 
}