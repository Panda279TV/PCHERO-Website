<?php
// Header einfügen
include('templates/header.php');
?>
<main class="dashboardPadding">
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
    die('<div class="dieFlex">
    	<h1 class="dieWidth">
    	<a href="login.php">PLEASE LOGIN FIRST!</a>
    	</h1>
    	</div>');
// Andernfalls zeige den Button unten rechts an, wenn der User eingeloggt ist
} else {
    echo '<div>
        <a class="btnfirst" data-aos="zoom-in-up" data-aos-delay="1000" data-aos-easing="ease-in-back" data-aos-once="true"><button class="btn btnMenuFirst">&#10133;</button></a>
        <a href="logout.php"><button class="btn btnMenuSecond ">&#128163;</button></a>
        <a href="dashboard.php"><button class="btn btnMenuThree ">&#128221;</button></a>
        </div>';
}


// Wenn der User auf was klickt, wird die Seite ja neu geladen und so wird die Zeit von 0 auf erneuert
// Macht der User aber nichts, dann wird hochgezählt und nach der Zeit wird er ausgeloggt
// Ist der User auf anderen Seiten, wird trotzdem hochgezählt um so einen Diebstahl von anderen Leuten, die am PC sind zu verhindern
if(time() - $_SESSION['timestamp'] > 900) {
    unset($_SESSION);
    session_destroy();
    session_unset();
    echo '<script> alert("You have been logged out for inactivity!\nThis is just for your and our safety!"); window.location.href = "index.php"; </script>';
    exit;
} else {
    $_SESSION['timestamp'] = time();
}


// Ausgeben welcher usertype gerade eingeloggt ist
// var_dump($_SESSION['usertypes']);

	// Den Vornamen, Nachnamen und die ID werden abgefragt, den man beim Login gespeichert hat
	$userid = $_SESSION['userid'];
	$userfirstname = $_SESSION['userfirstname'];
	$userlastname = $_SESSION['userlastname'];
	$userlastlogin = $_SESSION['userlastlogin'];


	// Verbindung zur Datenbank wird hergestellt
	require_once('database.php');

	// Die Formulare werden in Variablen gespeichert, so kann ich genau die Usertypes aufteilen in 3 Formulare
	$editUserOwnData = '<form action="" method="post" enctype="multipart/form-data">
		<input class="btn btnEditTable" type="submit" name="edit" value="Edit-Own-Data"> <br>
		</form>';

	$editDashboardAdminData = '<form action="" method="post" enctype="multipart/form-data">
		<input class="btn btnEditTable" type="submit" name="edit" value="Edit-Own-Data"> <br>
		<input class="btn btnEditTable" type="submit" name="edit" value="Show-Contact-Form"> <br>
		<input class="btn btnEditTable" type="submit" name="edit" value="Components-Database">
		</form>';

	$editDashboardSuperAdminData = '<form action="" method="post" enctype="multipart/form-data">
		<input class="btn btnEditTable" type="submit" name="edit" value="Edit-Own-Data"> <br>
		<input class="btn btnEditTable" type="submit" name="edit" value="Show-Contact-Form"> <br>
		<input class="btn btnEditTable" type="submit" name="edit" value="User-Database"> <br>
		<input class="btn btnEditTable" type="submit" name="edit" value="Components-Database">
		</form>';


// Wenn er User ist, führe den Code aus
if($_SESSION['usertype'] == "User") {

	// User wird persönlich mit seinen Anmeldedaten begrüßt
	echo '<h1 class="centerWidth"> Hello '.$userfirstname.' '.$userlastname.' ! </h1>';

	echo '<h3 class="centerWidth"> Your Last Login was '.$userlastlogin.' ! </h3>';

	// User wird mit einer Herzlichen Nachricht angesprochen
	echo '<h3 class="centerWidth"> Im glad you logged in again! <br> The whole team wishes you a nice day! </h2>';


	echo $editUserOwnData;

	echo '<br><br><div style="border-bottom: 15px solid black;"></div><br>';


	// Post werte werden abgefragt und dann werden Funktionen ausgeführt
	if (!isset($_POST['edit'])) $_POST['edit'] = "";
	if (!isset($_POST['editU'])) $_POST['editU'] = "";

	if ($_POST['edit'] == 'Edit-Own-Data') {
		echo editUserEntry($dbh);
	} elseif ($_POST['editU'] == 'Update'){
		echo updateUserEntry($dbh);
	}


// Wenn er Admin ist, führe den Code aus
} elseif ($_SESSION['usertype'] == "Admin") {

	// User wird persönlich mit seinen Anmeldedaten begrüßt
	echo '<h1 class="centerWidth"> Hello '.$userfirstname.' '.$userlastname.' ! </h1>';

	echo '<h3 class="centerWidth"> Your Last Login was '.$userlastlogin.' ! </h3>';

	echo '<h3 class="centerWidth"> You will be logged out automatically if you do nothing on the dashboard after 15 minutes! </h2>';

	echo '<br><h1 class="centerWidth"> Please be careful when Editing, Deleting and Adding new Files and Users! </h1>';


	echo $editDashboardAdminData;

	echo '<br><br><div style="border-bottom: 15px solid black;"></div><br>';


	// Post werte werden abgefragt und dann werden Funktionen ausgeführt
	if (!isset($_POST['edit'])) $_POST['edit'] = "";
	if (!isset($_POST['editU'])) $_POST['editU'] = "";

	if ($_POST['edit'] == 'Edit-Own-Data') {
		echo editUserEntry($dbh);
	} elseif ($_POST['editU'] == 'Update'){
		echo updateUserEntry($dbh);
	} elseif ($_POST['edit'] == 'Show-Contact-Form'){
		echo '<pre class="showOverflowHidden">';
		print_r(showContactEntrys($dbh));
		echo '</pre>';
	} elseif ($_POST['edit'] == 'Previous'){
		echo '<pre class="showOverflowHidden">';
		print_r(previousContact($dbh));
		echo '</pre>';
	} elseif ($_POST['edit'] == 'Next'){
		echo '<pre class="showOverflowHidden">';
		print_r(nextContact($dbh));
		echo '</pre>';
	}

	// Admin Bereich wird hinzugefügt
	require_once('admindashboard.php');


// Wenn er SuperAdmin ist, führe den Code aus
} elseif ($_SESSION['usertype'] == "SuperAdmin") {

	// User wird persönlich mit seinen Anmeldedaten begrüßt
	echo '<h1 class="centerWidth"> Hello '.$userfirstname.' '.$userlastname.' ! </h1>';

	echo '<h3 class="centerWidth"> Your Last Login was '.$userlastlogin.' ! </h3>';

	// User wird mit einer Herzlichen Nachricht angesprochen
	echo '<h3 class="centerWidth"> Im glad you logged in again! <br> The whole team wishes you a nice day! </h2>';

	echo '<h3 class="centerWidth"> You will be logged out automatically if you do nothing on the dashboard after 15 minutes! </h2>';

	echo '<br><h1 class="centerWidth"> Please be careful when Editing, Deleting and Adding new Files and Users! </h1>';


	echo $editDashboardSuperAdminData;

	echo '<br><br><div style="border-bottom: 15px solid black;"></div><br>';


	// Post werte werden abgefragt und dann werden Funktionen ausgeführt
	if (!isset($_POST['edit'])) $_POST['edit'] = "";
	if (!isset($_POST['editU'])) $_POST['editU'] = "";

	if ($_POST['edit'] == 'Edit-Own-Data') {
		echo editUserEntry($dbh);
	} elseif ($_POST['editU'] == 'Update'){
		echo updateUserEntry($dbh);
	} elseif ($_POST['edit'] == 'Show-Contact-Form'){
		echo '<pre class="showOverflowHidden">';
		print_r(showContactEntrys($dbh));
		echo '</pre>';
	} elseif ($_POST['edit'] == 'Previous'){
		echo '<pre class="showOverflowHidden">';
		print_r(previousContact($dbh));
		echo '</pre>';
	} elseif ($_POST['edit'] == 'Next'){
		echo '<pre class="showOverflowHidden">';
		print_r(nextContact($dbh));
		echo '</pre>';
	}

	// Admin Bereich wird hinzugefügt
	require_once('admindashboard.php');
}


// Funktion Previous, schaut ob die Zahl größer als 0 ist und zeigt dann diese Id an, falls es nicht mehr größer ist, dann bitte ID=1 anzeigen
function previousContact ($dbh){

		$previous = "0";
		$previous = $_POST['id'];
		$lastID = $_POST['lastId'];
		$previous--;

	if ($previous > 0) {
		$data = $dbh -> prepare("SELECT * FROM Contact WHERE id = :id LIMIT 1");

		$data -> execute(array(":id" => $previous));

		$result = $data -> fetch(PDO::FETCH_ASSOC);

		echo '<form id="previousContact" class="centerNextPrevious" action="dashboard.php#previousContact" method="post">
			<input type="hidden" name="id" value="'.$result['id'].'">
			<input type="hidden" name="lastId" value="'.$lastID.'">
			<input class="btn btnNext" type="submit" name="edit" value="Next"> 
			<input class="btn" type="submit" name="edit" value="Previous"><br></form>';

		return $result;
	} else {
		$data = $dbh -> prepare("SELECT * FROM Contact WHERE id = '1' LIMIT 1");

		$data -> execute();

		$result = $data -> fetch(PDO::FETCH_ASSOC);

		echo '<form id="previousContact" class="centerNextPrevious" action="dashboard.php#previousContact" method="post">
			<input type="hidden" name="id" value="'.$result['id'].'">
			<input type="hidden" name="lastId" value="'.$lastID.'">
			<input class="btn btnNext" type="submit" name="edit" value="Next"> 
			<input class="btn" type="submit" name="edit" value="Previous"><br></form>';

		return $result;
	}

}


// Funktion Next, schaut ob die Zahl größer als lastID ist und zeigt dann diese Id an, falls es nicht mehr kleiner ist, dann bitte letzte ID anzeigen
function nextContact ($dbh){

		$next = "0";
		$next = $_POST['id'];
		$lastID = $_POST['lastId'];
		$next++;

	if ($next < $lastID) {
		$data = $dbh -> prepare("SELECT * FROM Contact WHERE id = :id LIMIT 1");

		$data -> execute(array(":id" => $next));

		$result = $data -> fetch(PDO::FETCH_ASSOC);

		echo '<form id="nextContact" class="centerNextPrevious" action="dashboard.php#nextContact" method="post">
			<input type="hidden" name="id" value="'.$result['id'].'">
			<input type="hidden" name="lastId" value="'.$lastID.'">
			<input class="btn btnNext" type="submit" name="edit" value="Next"> 
			<input class="btn" type="submit" name="edit" value="Previous"><br></form>';

		return $result;
	} else {
		$data = $dbh -> prepare("SELECT * FROM Contact ORDER BY id DESC LIMIT 1");

		$data -> execute();

		$result = $data -> fetch(PDO::FETCH_ASSOC);

		echo '<form id="nextContact" class="centerNextPrevious" action="dashboard.php#nextContact" method="post">
			<input type="hidden" name="id" value="'.$result['id'].'">
			<input type="hidden" name="lastId" value="'.$lastID.'">
			<input class="btn btnNext" type="submit" name="edit" value="Next"> 
			<input class="btn" type="submit" name="edit" value="Previous"><br></form>';

		return $result;
	}


}


// Zeigt die letzte Spalte vom Kontakt an. Also die letzte ID und auch nur die und nicht alle auf einmal
function showContactEntrys ($dbh){
	// $data = $dbh -> prepare("SELECT * FROM Contact LIMIT 1");
	$data = $dbh -> prepare("SELECT * FROM Contact ORDER BY id DESC LIMIT 1");

	$data -> execute();

	$result = $data -> fetch(PDO::FETCH_ASSOC);

	$lastID = $result['id'];

	echo '<form id="showContact" class="centerNextPrevious" action="dashboard.php#showContact" method="post">
		<input type="hidden" name="id" value="'.$result['id'].'">
		<input type="hidden" name="lastId" value="'.$lastID.'">
		<input class="btn btnNext" type="submit" name="edit" value="Next"> 
		<input class="btn" type="submit" name="edit" value="Previous"><br></form>';

	return $result;
}


// Die Funktion editiert Daten, die in der Datenbank sind
// Die Daten werden in einem Formular angezeigt und dort kann man diese bearbeiten
function editUserEntry ($dbh){
	$userid = $_SESSION['userid'];

	$data = $dbh -> prepare("SELECT * FROM User WHERE id = :id");

	$data -> execute(array(":id" => $userid));

	$result = $data -> fetch();

	echo '<br>
		<div class="row">
		<form class="col s-10 m-8 l-6 xl-4 formEntry" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="'.$result['id'].'">
		<input type="hidden" name="valuepassword" value="'.$result['password'].'">
		<h1 class="centerWidth">Edit Your Data</h1>

		<table cellpadding="15" border="3">
		<tr>
			<td class="col s-12"><label class="col s-12" for="firstname">Firstname:</label></td>
			<td class="col s-12"><input class="col s-12" type="text"  name="firstname" value="'.$result['firstname'].'"></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="lastname">Lastname:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" name="lastname" value="'.$result['lastname'].'"></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12"  for="email">Email:</label></td>
			<td class="col s-12"><input class="col s-12" type="email" name="email" value="'.$result['email'].'"></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="password">Password:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" name="password" value=""></td>
		</tr>

		<tr>
			<td class="col s-12"><label class="col s-12" for="password2">Password Repeat:</label></td>
			<td class="col s-12"><input class="col s-12" type="text" name="password2" value=""></td>
		</tr>

		<tr>
			<td colspan="5">
			<input class="btn btnEditAll" type="submit" name="editU" value="Update"></td>
		</tr>
		</table>
		</form>
		</div>';
}


// Die Funktion updatet die editierten Daten, die in der Datenbank sind
// Die Daten werden in einem Formular angezeigt und dort kann man diese bearbeiten und dann wird das editierte in der Datenbank aktualisiert
function updateUserEntry ($dbh){
	// Es werden sich alle Eingaben geholt und durch die trim_input_User Funktion gejagt
    // Ucfirst() macht den ersten Buchstaben groß, damit alle Namen den ersten Buchstaben groß haben
	$firstname = trim_input_User(ucfirst($_POST['firstname']));
    $lastname = trim_input_User(ucfirst($_POST['lastname']));
    $email = trim_input_User($_POST['email']);
    $password = trim_input_User($_POST['password']);
    $password2 = trim_input_User($_POST['password2']);

    if($password != $password2 || empty($password2)) {
    	$passwordPrepared = $_POST['valuepassword'];
    }

    if (!empty($_POST["password"])) {
    	$password = trim_input_User($_POST['password']);
    	$passwordPrepared = password_hash($password, PASSWORD_DEFAULT);
    } else {
    	$passwordPrepared = $_POST['valuepassword'];
    }

    $data = $dbh -> prepare("UPDATE User SET
			
			firstname=:firstname,
			lastname=:lastname,
			email=:email,
			password=:password

			WHERE id=:id");

   	$data -> execute(array(':firstname' => $firstname, ':lastname' => $lastname, ':email' => $email, ':password' => $passwordPrepared, ':id' => $_POST['id']));

		
		if($data -> rowCount() === 1) {
		    return '<h1 class="dashboardSuccess"> Entry successfully updated! </h1>';
		} else {
		    return '<h1 class="dashboardError"> Entry not updated! Either you didnt change anything or it didnt work! </h1>';
		}
}


// Funktion, damit man kein Script oder ähnliche Sachen ausführen kann. Des Weiteren werden alle Operatoren, Leerzeichen und HTML Tags ignoriert und gelöscht bei der Eingabe
function trim_input_User($data) {  
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
</main>
<?php
// Footer einfügen
include('templates/footer.php');
?>