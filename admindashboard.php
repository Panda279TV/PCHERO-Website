<?php
// Fehlermeldungen anzeigen, aber nur wenn man im Localhost ist
require_once('displayserrors.php');

// Eine Session Sitzung starten
session_start();

// Überprüft ob der User eingeloggt ist
if(!isset($_SESSION['userid'])) {
	// Wenn der User nicht eingeloggt ist, dann bitte alles zerstören und die Fehlermeldung anzeigen
	// Alle Session werden gelöscht
	unset($_SESSION);
	session_destroy();
    die('<div style="width: 100vw; height: 100vh; display: flex; text-align: center; align-content: center; align-items: center; flex-wrap: wrap; justify-content: center;">
    	<h1 style="width: 100%">
    	<a href="login.php">PLEASE LOGIN FIRST!</a>
    	</h1>
    	</div>');

// Überprüft ob es ein User ist und dann bitte zerstöre alles in dem Bereich mit die
// Der User hat nichts im Admin Dashboard verloren und deswegen muss er sich neu einloggen
// Die Sitzung und die Sessions werden gelöscht
} elseif ($_SESSION['usertype'] == "User") {
	unset($_SESSION);
	session_destroy();
	die('<div class="dieFlex">
		<h1 class="dieWidth">ACCESS RIGHTS DENIED!</h1>
		<h1 class="dieWidth">
		<a href="index.php">PLEASE GO TO THE HOME PAGE!</a>
		</h1>
		</div>');
}


// Verbindung zur Datenbank wird hergestellt
require_once('database.php');


// Wenn man auf Ja klickt beim löschen, dann wird die löschen funktion ausgeführt
if (!isset($_POST['confirm'])) $_POST['confirm'] = "";

if ($_POST['confirm'] == "Yes") {
	echo deleteEntry($dbh, $_POST["tableID"]);
}

// Es wird geprüft ob der User ein Admin ist oder ein Superadmin
// Wenn beim Post Edit nichts drinne ist, dann mach es leer
// Wenn man auf einen Button klickt, wird der Post und der Value ausgelesen
// Passt er zu einer if elseif Bedingung, dann führe die darunter führende Funktion aus
// Und zeige auch die Datenbank an
if($_SESSION['usertype'] == "Admin") {
	if (!isset($_POST['edit'])) $_POST['edit'] = "";
	if (!isset($_POST['tableID'])) $_POST['tableID'] = "";

	if ($_POST['edit'] == 'Edit') {
		echo editEntry($dbh, $_POST["tableID"]);
	} elseif ($_POST['edit'] == 'Delete') {
		echo confirmEntry($dbh, $_POST["tableID"]);
	} elseif ($_POST['edit'] == 'Show') {
		echo '<pre class="showOverflowHidden">';
	 	print_r(showEntry($dbh, $_POST["tableID"]));
	 	echo '</pre>';
	} elseif ($_POST['edit'] == 'Update') {
		echo updateEntry($dbh, $_POST["tableID"]);
	} elseif ($_POST['edit'] == 'New') {
		echo newEntry($_POST["tableID"]);
	} elseif ($_POST['edit'] == 'Insert') {
		echo insertEntry($dbh, $_POST["tableID"]);
	} elseif ($_POST['edit'] == 'Components-Database') {
		echo allEntriesConfigurator($dbh);
	}


} elseif ($_SESSION['usertype'] == "SuperAdmin") {
	
	if (!isset($_POST['edit'])) $_POST['edit'] = "";
	if (!isset($_POST['tableID'])) $_POST['tableID'] = "";

	if ($_POST['edit'] == 'Edit') {
		echo editEntry($dbh, $_POST["tableID"]);
	} elseif ($_POST['edit'] == 'Delete') {
		echo confirmEntry($dbh, $_POST["tableID"]);
	} elseif ($_POST['edit'] == 'Show') {
		echo '<pre class="showOverflowHidden">';
	 	print_r(showEntry($dbh, $_POST["tableID"]));
	 	echo '</pre>';
	} elseif ($_POST['edit'] == 'Update') {
		echo updateEntry($dbh, $_POST["tableID"]);
	} elseif ($_POST['edit'] == 'New') {
		echo newEntry($_POST["tableID"]);
	} elseif ($_POST['edit'] == 'Insert') {
		echo insertEntry($dbh, $_POST["tableID"]);
	} elseif ($_POST['edit'] == 'Components-Database') {
		echo allEntriesConfigurator($dbh);
	} elseif ($_POST['edit'] == 'User-Database') {
		echo allEntriesUser($dbh);
	}
}


// Es soll nach dem man eine Funktion ausgeführt hat, auch die dazu gehörige Tabelle angezeigt werden
if ($_POST["tableID"] == 'User') {
	echo allEntriesUser($dbh);
}
if ($_POST["tableID"] == 'Configurator') {
	echo allEntriesConfigurator($dbh);
}


// Die Funktion zeigt alle User Daten, die in der Datenbank sind an
// Die Ausgabe wird in einer Tabelle angezeigt
function allEntriesUser($dbh){
	$data = $dbh -> prepare("SELECT * FROM User WHERE usertype = 'User' OR usertype='Admin'");

	// $data = $dbh -> prepare("SELECT * FROM User");

	$data -> execute();

	$form = '<table class="tableUser" cellpadding="10" border="3">
	<tr><td colspan="15"><h1>PC USER DATABASE</h1>
	<form action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="tableID" value="User">
		<input class="btnDashboard" type="submit" name="edit" value="New">
	</form>
	</td></tr>
	<tr>
	<td><strong>ID</strong></td>
	<td><strong>USERTYPE</strong></td>
	<td><strong>FIRSTNAME</strong></td>
	<td><strong>LASTNAME</strong></td>
	<td><strong>EMAIL</strong></td>
	<td><strong>EDITING</strong></td></td></tr>';

		foreach ($data as $entry) {
			$form .= '<tr>
		<td>'.$entry['id'].'</td>
		<td>'.$entry['usertype'].'</td>
		<td>'.$entry['firstname'].'</td>
		<td>'.$entry['lastname'].'</td>
		<td>'.$entry['email'].'</td>
		<td><form action="" method="post">
		<input type="hidden" name="id" value="'.$entry['id'].'">
		<input type="hidden" name="tableID" value="User">
		<input class="btnDashboard" type="submit" name="edit" value="Show">
		<input class="btnDashboard" type="submit" name="edit" value="Edit">
		<input class="btnDashboard" type="submit" name="edit" value="Delete">
		</form></td>
		</tr>';
		}
	$form .= '</table>';
	$dbh = null;
	return $form;
}


// Die Funktion zeigt alle Configurator Daten, die in der Datenbank sind an
// Die Ausgabe wird in einer Tabelle angezeigt
function allEntriesConfigurator($dbh){
	$data = $dbh -> prepare("SELECT * FROM Configurator");

	$data -> execute();

	$form = '<table class="tableConfigurator" cellpadding="10" border="3">
	<tr><td colspan="10"><h1>PC HERO CONFIGURATOR DATABASE</h1>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="tableID" value="Configurator">
		<input class="btnDashboard" type="submit" name="edit" value="New">
	</form>
	</td></tr>
	<tr>
	<td><strong>ID</strong></td>
	<td><strong>NAME</strong></td>
	<td><strong>HEADING</strong></td>
	<td><strong>CATEGORY</strong></td>
	<td><strong>TEXT</strong></td>
	<td><strong>IMAGE</strong></td>
	<td><strong>EDITING</strong></td></td></tr>';

		foreach ($data as $entry) {
			$form .= '<tr>
		<td>'.$entry['id'].'</td>
		<td>'.$entry['name'].'</td>
		<td>'.$entry['heading'].'</td>
		<td>'.$entry['category'].'</td>
		<td>'.$entry['text'].'</td>
		<td>'.$entry['image'].'</td>
		<td><form action="" method="post">
		<input type="hidden" name="id" value="'.$entry['id'].'">
		<input type="hidden" name="tableID" value="Configurator">
		<input class="btnDashboard" type="submit" name="edit" value="Show">
		<input class="btnDashboard" type="submit" name="edit" value="Edit">
		<input class="btnDashboard" type="submit" name="edit" value="Delete">
		</form></td>
		</tr>';
		}
	$form .= '</table>';
	$dbh = null;
	return $form;
}


// Die Funktion zeigt alle User oder Configurator Daten, die in der Datenbank sind an
// Die Ausgabe wird einfach als array zurückgegeben
function showEntry ($dbh, string $tablename){
	$data = $dbh -> prepare("SELECT * FROM $tablename WHERE id = :id LIMIT 1");

	$data -> execute(array(":id" => $_POST['id']));

	$result = $data -> fetch(PDO::FETCH_ASSOC);

	return $result;
}


// Fragt ab ob die Reihe wirklich gelöscht werden soll
// Ja wird gelöscht und nein passiert nichts
function confirmEntry ($dbh, string $tablename) {

	echo '<form class="centerWidth formConfirm" action="" method="post">
		<h1> Are you sure you want to delete that row? </h1>
		<input type="hidden" name="tableID" value="' . $tablename .'">
		<input type="hidden" name="id" value="'.$_POST['id'].'">
		<input class="btn" type="submit" name="confirm" value="Yes"> 
		<input class="btn" type="submit" name="confirm" value="No"><br></form>';
}


// Die Funktion löchst die Spalte, wo man auf den Löschen Button geklickt hat
// Die Ausgabe wird einfach als return zurückgegeben
function deleteEntry ($dbh, string $tablename) {

	$data = $dbh -> prepare("DELETE FROM $tablename WHERE id = :id");

	$predata = $data -> execute(array(":id" => $_POST['id']));

	if($data -> rowCount() === 1) {
	    return '<h1 class="adminSuccess"> Entry successfully removed! </h1>';
	} else {
	    return '<h1 class="adminError"> Entry not removed! An error has occurred!</h1>';
	}
}


// Die Funktion editiert Daten, die in der Datenbank sind
// Die Daten werden in einem Formular angezeigt und dort kann man diese bearbeiten
function editEntry ($dbh, string $tablename){
	$data = $dbh -> prepare("SELECT * FROM $tablename WHERE id = :id");

	$data -> execute(array(":id" => $_POST['id']));

	$result = $data -> fetchAll(PDO::FETCH_ASSOC);

	if ($tablename == "User") {
	
	return '<div class="row">
	<form class="col s-10 m-8 l-6 xl-4 formEntry" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="tableID" value="User">
	<input type="hidden" name="id" value="'.$_POST['id'].'">
	<input type="hidden" name="valueusertype" value="'.$result[0]['usertype'].'">
	<input type="hidden" name="valuepassword" value="'.$result[0]['password'].'">

	<table>

		<tr>
			<td class="col s-12"><label class="col s-12" for="usertype">Usertype:</label></td>
			<td class="col s-12">
			<select class="col s-12" name="usertype">
				<optgroug name="usertype">
					<option value="Zero" disabled selected><b>'.$result[0]['usertype'].'</b></option>
					<option value="User">User</option>
					<option value="Admin">Admin</option>
					<option value="SuperAdmin">SuperAdmin</option>
				</optgroup>
			</select></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="firstname">Firstname:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" name="firstname" value="'.$result[0]['firstname'].'"></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="lastname">Lastname:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" name="lastname" value="'.$result[0]['lastname'].'"></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="email">Email:</label></td>
			<td class="col s-12"><input class="col s-12" type="email" name="email" value="'.$result[0]['email'].'"></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="password">Password:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" name="password" value=""></td>
		</tr>

		<tr>
			<td>
			<input class="btn btnEditAll" type="submit" name="edit" value="Update"></td>
		</tr>
		</table>
		</form>
		</div>'; 

	} else {

	return '<div class="row">
	<form class="col s-10 m-8 l-6 xl-4 formEntry" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="tableID" value="Configurator">
	<input type="hidden" name="id" value="'.$_POST['id'].'">
	<input type="hidden" name="valuecategory" value="'.$result[0]['category'].'">
	<input type="hidden" name="valueimage" value="'.$result[0]['image'].'">
	<h1 class="centerWidth">Configurator Edit Entry</h1>

	<table>

		<tr>
			<td class="col s-12"><label class="col s-12" for="name">Name:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" name="name" value="'.$result[0]['name'].'"></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="heading">Heading:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" name="heading" value="'.$result[0]['heading'].'"></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="category">Category:</label></td>
			<td class="col s-12">
			<select class="col s-12" name="category">
					<optgroug name="category">
						<option value="zero" disabled selected>'.$result[0]['category'].'</option>
						<option value="Case">Case</option>
						<option value="Processor">Processor</option>
						<option value="GraphicsCard">GraphicsCard</option>
						<option value="RamMemory">RamMemory</option>
						<option value="Motherboard">Motherboard</option>
						<option value="CoolingSystem">CoolingSystem</option>
						<option value="Fan">Fan</option>
						<option value="SSDMemory">SSDMemory</option>
						<option value="HDDMemory">HDDMemory</option>
						<option value="Other">Other</option>
					</optgroup>
			</td></select>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="text">Text:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" name="text" value="'.$result[0]['text'].'"></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="image">Image:</label></td>
			<td class="col s-12"><input class="col s-12" type="file" name="image" value=""></td>
		</tr>
		<tr>
			<td>
			<input class="btn btnEditAll" type="submit" name="edit" value="Update"></td>
		</tr>
		</table>
		</form>
		</div>';
	}	
}


// Die Funktion updatet die editierten Daten, die in der Datenbank sind
// Die Daten werden in einem Formular angezeigt und dort kann man diese bearbeiten und dann wird das editierte in der Datenbank aktualisiert
function updateEntry ($dbh, string $tablename){
	// $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if ($tablename == "User"){

	// Es werden sich alle Eingaben geholt und durch die trim_input Funktion gejagt
    // Ucfirst() macht den ersten Buchstaben groß, damit alle Namen den ersten Buchstaben groß haben
	$firstname = trim_input(ucfirst($_POST['firstname']));
    $lastname = trim_input(ucfirst($_POST['lastname']));
    $email = trim_input($_POST['email']);
	$userfirstname = $_SESSION['userfirstname'];
	$userlastname = $_SESSION['userlastname'];
    $editedby = $userfirstname . " " . $userlastname;


    if(empty($_POST['usertype'])) {
    	$usertype = $_POST['valueusertype'];
	} else {
        $usertype = $_POST['usertype'];
    }


    if (!empty($_POST['password'])) {
    	$password = trim_input($_POST['password']);
    	$passwordPrepared = password_hash($password, PASSWORD_DEFAULT);
    } else {
    	$passwordPrepared = $_POST['valuepassword'];
    }


    $data = $dbh -> prepare("UPDATE $tablename SET
			
			usertype=:usertype,
			firstname=:firstname,
			lastname=:lastname,
			email=:email,
			password=:password,
			editedby=:editedby

			WHERE id=:id");

   	$data -> execute(array(':usertype' => $usertype, ':firstname' => $firstname, ':lastname' => $lastname, ':email' => $email, ':password' => $passwordPrepared, ':editedby' => $editedby, ':id' => $_POST['id']));

		
		if($data -> rowCount() === 1) {
		    return '<h1 class="adminSuccess"> Entry successfully updated! </h1>';
		} else {
		    return '<h1 class="adminError"> Entry not updated! Either you didnt change anything or it didnt work! </h1>';
		}

	} else {

	$name = trim_input(ucfirst($_POST['name']));
    $heading = trim_input(ucfirst($_POST['heading']));
    $text = trim_input(ucfirst($_POST['text']));
    $currentTimestamp = date("Y-m-d H:i:s");
    $userfirstname = $_SESSION['userfirstname'];
	$userlastname = $_SESSION['userlastname'];
    $editedby = $userfirstname . " " . $userlastname;

    if(empty($_POST["category"])) {
    	$category = $_POST["valuecategory"];
	} else {
        $category = $_POST['category'];
    }


    if($_FILES['image']['size'] == 0) {
    	// $newPath = "img/db-uploads/error.png";
    	$newPath = $_POST['valueimage'];
	} else {
        // Bildupload Validierung wird eingefügt
		require_once('imageupload.php');
    }


    $data = $dbh -> prepare("UPDATE $tablename SET
			
			name=:name,
			heading=:heading,
			category=:category,
			text=:text,
			image=:image,
			updated=:updated,
			editedby=:editedby

			WHERE id=:id");

    $data -> execute(array(':name' => $name, ':heading' => $heading, ':category' => $category, ':text' => $text, ':image' => $newPath, 'updated' => $currentTimestamp, ':editedby' => $editedby, ':id' => $_POST['id']));


		if($data -> rowCount() === 1) {
		    return '<h1 class="adminSuccess"> Entry successfully updated! </h1>';
		} else {
		    return '<h1 class="adminError"> Entry not updated! Either you didnt change anything or it didnt work! </h1>';
		}
	}
}


// Die Funktion fügt neue Einträge hinzu
// Es wird ein Formular angezeigt und dort kann man dann die Daten eintragen
function newEntry (string $tablename){

	if ($tablename == "User") {

	return '<div class="row">
	<form class="col s-10 m-8 l-6 xl-4 formEntry" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="">
	<input type="hidden" name="tableID" value="User">
	<h1 class="centerWidth">User New Entry</h1>

	<table>

		<tr>
			<td class="col s-12"><label class="col s-12" for="usertype">Usertype:</label></td>
			<td class="col s-12">
			<select class="col s-12" name="usertype">
				<optgroug name="länder">
					<option value="Zero" disabled selected><b>Please Select!</b></option>
					<option value="User">User</option>
					<option value="Admin">Admin</option>
					<option value="SuperAdmin">SuperAdmin</option>
				</optgroup>
			</select></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="firstname">Firstname:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" placeholder="Test" name="firstname" value=""></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="lastname">Lastname:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" placeholder="Testustis" name="lastname" value=""></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="email">Email:</label></td>
			<td class="col s-12"><input class="col s-12" type="email" placeholder="testintesting@test.test" name="email" value=""></td>
		</tr>
		<tr>
			<td class="col s-12"><label class="col s-12" for="password">Password:</label></td>
			<td class="col s-12"><input class="col s-12" type="password" placeholder="hT5673hFjksf527GBH" name="password" value=""></td>
		</tr>
		<tr>
			<td>
			<input class="btn btnEditAll" type="submit" name="edit" value="Insert"></td>
		</tr>
		</table>
		</form>
		</div>';

	} else {

	return '<div class="row">
	<form class="col s-10 m-8 l-6 xl-4 formEntry" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="">
	<input type="hidden" name="tableID" value="Configurator">
	<h1 class="centerWidth">Configurator New Entry</h1>

	<table>

		<tr>
			<td class="col s-12"><label class="col s-12" for="name">Name:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" placeholder="Air Cooler" name="name" value=""></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="heading">Heading:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" placeholder="Air Cooler HK900 300Watt" name="heading" value=""></td>
		</tr>

		<tr>
		<td class="col s-12"><label class="col s-12" for="category">Category:</label></td>
		<td class="col s-12">
		<select class="col s-12" name="category">
				<optgroug name="länder">
					<option value="zero" disabled selected><b>Please Select!</b></option>
					<option value="Case">Case</option>
					<option value="Processor">Processor</option>
					<option value="GraphicsCard">GraphicsCard</option>
					<option value="RamMemory">RamMemory</option>
					<option value="Motherboard">Motherboard</option>
					<option value="CoolingSystem">CoolingSystem</option>
					<option value="Fan">Fan</option>
					<option value="SSDMemory">SSDMemory</option>
					<option value="HDDMemory">HDDMemory</option>
					<option value="Other">Other</option>
				</optgroup>
		</td></select>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="text">Text:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" placeholder="Lorum Ipsum Lorum Ipsum Lorum Ipsum" name="text" value=""></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="image">Image:</label></td>
			<td class="col s-12"><input class="col s-12" type="file" name="image" value=""></td>
		</tr>
		<tr>
			<td>
			<input class="btn btnEditAll" type="submit" name="edit" value="Insert"></td>
		</tr>
		</table>
		</form>';
	}
}


// Die Funktion fügt neue Einträge hinzu, nachdem man einen neuen Eintrag erstellt hat
// Es wird ein Formular angezeigt und dort kann man dann die Daten eintragen. Klickt man auf Eintragen, werden die Daten in die Datenbank übernommen
function insertEntry ($dbh, string $tablename){

	if ($tablename == "User"){

    // Es werden sich alle Eingaben geholt und durch die trim_input Funktion gejagt
    // Ucfirst() macht den ersten Buchstaben groß, damit alle Namen den ersten Buchstaben groß haben
	$firstname = trim_input(ucfirst($_POST['firstname']));
    $lastname = trim_input(ucfirst($_POST['lastname']));
    $email = trim_input($_POST['email']);
    $password = trim_input($_POST['password']);

	$password_hash = password_hash($password, PASSWORD_DEFAULT);

	if(empty($_POST['usertype'])) {
    	$usertype = "User";
	} else {
        $usertype = $_POST['usertype'];
    }


    $data = $dbh -> prepare("INSERT INTO $tablename SET 
			usertype=:usertype,
			firstname=:firstname,
			lastname=:lastname,
			email=:email,
			password=:password");

    $data -> execute(array(':usertype' => $usertype, ':firstname' => $firstname, ':lastname' => $lastname, ':email' => $email, ':password' => $password_hash));

	 	if($data -> rowCount() === 1) {
	    	return '<h1 class="adminSuccess"> Entry successfully processed! </h1>';
	    } else {
	    	return '<h1 class="adminError"> Entry not processed! An error has occurred! </h1>';
	    }

	} else {

	$name = trim_input(ucfirst($_POST['name']));
    $heading = trim_input(ucfirst($_POST['heading']));
    $text = trim_input(ucfirst($_POST['text']));
    $userfirstname = $_SESSION['userfirstname'];
	$userlastname = $_SESSION['userlastname'];
    $createdby = $userfirstname . " " . $userlastname;

    if(empty($_POST['category'])) {
    	$category = "Other";
	} else {
        $category = $_POST['category'];
    }

    if($_FILES['image']['size'] == 0) {
    	$newPath = "img/db-uploads/error.png";
	} else {
        // Bildupload Validierung wird eingefügt
		require_once('imageupload.php');
    }


    $data = $dbh -> prepare("INSERT INTO $tablename SET 
			
			name=:name,
			heading=:heading,
			category=:category,
			text=:text,
			image=:image,
			createdby=:createdby");

    $data -> execute(array(':name' => $name, ':heading' => $heading, ':category' => $category, ':text' => $text, ':image' => $newPath, ':createdby' => $createdby));

	    if($data -> rowCount() === 1) {
	    	return '<h1 class="adminSuccess"> Entry successfully processed! </h1>';
	    } else {
	    	return '<h1 class="adminError"> Entry not processed! An error has occurred! </h1>';
	    }
	}
}


// Funktion, damit man kein Script oder ähnliche Sachen ausführen kann. Des Weiteren werden alle Operatoren, Leerzeichen und HTML Tags ignoriert und gelöscht bei der Eingabe
function trim_input($data) {  
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>