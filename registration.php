<?php
// Fehlermeldungen anzeigen, aber nur wenn man im Localhost ist
require_once('displayserrors.php');

// Eine Session Sitzung starten
session_start();

// Ist der User eingeloggt, zeige bitte den Button unten rechts an
if(isset($_SESSION['userid'])){
    echo '<div>
        <a class="btnfirst" data-aos="zoom-in-up" data-aos-delay="1000" data-aos-easing="ease-in-back" data-aos-once="true"><button class="btn btnMenuFirst">&#10133;</button></a>
        <a href="logout.php"><button class="btn btnMenuSecond ">&#128163;</button></a>
        <a href="dashboard.php"><button class="btn btnMenuThree ">&#128221;</button></a>
        </div>';
}

// Verbindung zur Datenbank wird hergestellt
require_once('database.php');

// Error und die normalen Variablen werden leer gemacht, damit sie als leer angezeigt werden und keine Anfangsfehlermeldungen kommen
$errorfirstname = $errorlastname = $erroremail = $errordoubleemail = $errorpassword = $errorpassword2 = $errorcheckbox = $firstname = $lastname = $email = $checkbox = "";

// Funktion, damit man kein Script oder ähnliche Sachen ausführen kann. Des Weiteren werden alle Operatoren, Leerzeichen und HTML Tags ignoriert und gelöscht bei der Eingabe
// Somit wird die Sicherheit für Cross Site Scripting gewährleistet
function trim_input($data) {  
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Wenn der Server Request Post ist (Im Formular und Button Post), dann gib bitte den ganzen Code unten drunter aus
// Die error Variable wird auf false gesetzt, wenn man sich falsch anmeldet wird die Variable auf true gesetzt und so kommt man nicht weiter
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = false;

    // Es werden sich alle Eingaben geholt und durch die trim_input Funktion gejagt
    // Das ucfirst() macht den ersten Buchstaben groß, damit alle Namen den ersten Buchstaben groß haben
    // Usertype wird auf User gesetzt, sodass alle Leute, die sich anmelden nur User sind und nicht gleich Admin oder Super Admin Rechte haben
    $firstname = trim_input(ucfirst($_POST['firstname']));
    $lastname = trim_input(ucfirst($_POST['lastname']));
    $email = trim_input($_POST['email']);
    $password = trim_input($_POST['password']);
    $password2 = trim_input($_POST['password2']);
    $checkbox = $_POST['agbcheckbox'];
    $usertype = "User";
    
        // Schaut ob der Vorname alles beinhaltet, was ich mit preg_match vorgegeben habe
        if(!preg_match('/^[a-zäöüÄÖÜ ]{2,50}$/i', $firstname)) {
            $errorfirstname = '<p class="registrationError"> Please enter a valid First Name! <p>';
            $error = true;
        }
        // Schaut ob der Nachname alles beinhaltet, was ich mit preg_match vorgegeben habe
        if(!preg_match('/^[a-zäöüÄÖÜ ]{2,50}$/i', $lastname)) {
            $errorlastname = '<p class="registrationError"> Please enter a valid Last Name! <p>';
            $error = true;
        }
        // Schaut ob die E-Mail alles beinhaltet, was ich mit preg_match vorgegeben habe
        if(!preg_match('/^[a-z0-9_.+-]{2,60}@[a-zA-Z0-9.-]{2,20}.[a-zA-Z]{2,10}$/i', $email)) {
            $erroremail = '<p class="registrationError"> Please enter a valid E-Mail Address! <p>';
            $error = true;
        }
        // Schaut ob das Passwort alles beinhaltet, was ich mit preg_match vorgegeben habe 
        if(!preg_match('/^[a-z0-9]{8,100}$/i', $password)) {
            $errorpassword = '<p class="registrationError"> Please enter a valid Password! <p>';
            $error = true;
        }
        // Schaut ob das Passwort mit dem zweiten Passwort übereinstimmt 
        if($password !== $password2 || empty($password2)) {
            $errorpassword2 = '<p class="registrationError"> The Passwords must be the same! <p>';
            $error = true;
        }
        // Schaut ob die Checkbox angeklickt wurde
        if (!isset($checkbox)) {
            $errorcheckbox = '<p class="registrationError"> Please accept the AGBS! <p>';
            $error = true; 
        }
        
        // Überprüft, dass die E-Mail-Adresse noch nicht registriert wurde, also dass es die nicht schonmal in der Datenbank existiert
        if(!$error) { 
            $statement = $dbh -> prepare("SELECT * FROM User WHERE email = :email");
            $result = $statement -> execute(array('email' => $email));
            $user = $statement -> fetch();
            
            // Wenn es die E-Mail schon gibt, dann zeig die Fehlermeldung an
            if($user !== false) {
                $errordoubleemail = '<p class="registrationError"> This e-mail address is already assigned! <p>';
                $error = true;
            }
        }
    
        // Wenn es keine Fehler bei der Registration gab, dann soll alles was eingegeben wurde in die Datenbank importiert werden
        // Desweiteren wird das Passwort in gehashter Form gespeichert, so dass es schwieriger auszulesen ist
        if(!$error) {   
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $statement = $dbh -> prepare("INSERT INTO User (usertype, firstname, lastname, email, password) VALUES (:usertype, :firstname, :lastname, :email, :password)");
            
            $result = $statement -> execute(array('usertype' => $usertype, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'password' => $password_hash));
            
            // Wir überprüfen ob es geklappt hat mit Bool
            // Sag bei True dass es geklappt hat und bei False sag nein hat nicht geklappt
            if($result == true) {
                die('<div style="width: 100vw; height: 100vh; display: flex; text-align: center; align-content: center; align-items: center; flex-wrap: wrap; justify-content: center;">
                    <h1 style="width: 100%; padding: 3%; background: green; color:white;"> You have been successfully registered! </h1>
                    <h1 style="width: 100%;"> <a href="login.php">GO TO THE LOGIN!</a> </h1>
                    </div>');
            } else {
                die('<div style="width: 100vw; height: 100vh; display: flex; text-align: center; align-content: center; align-items: center; flex-wrap: wrap; justify-content: center;">
                    <h1 style="width: 100%; padding: 3%; background: red; color:white;"> UNFORTUNATELY AN ERROR OCCURRED DURING SAVING. </h1>
                    <h1 style="width: 100%; padding: 3%; background: red; color:white;"> PLEASE TRY IT AGAIN! </h1>
                    <h1 style="width: 100%;"> <a href="registration.php">GO TO THE REGISTRATION!</a> </h1>
                    </div>');
            }
        }
}
?>
<?php
// Header einfügen
include('templates/header.php');
?>
<main>
    <div class="row registrationContainer">
        <form class="col s-10 m-8 l-6 xl-4 registrationForm" action="" method="post">
            <label class="col s-12">Firstname:</label>
                <input class="col s-12" type="text" placeholder="Max" name="firstname" value="<?= $firstname; ?>" autofocus>
                    <div><?= $errorfirstname;?></div>
            <label class="col s-12">Lastname:</label>
                <input class="col s-12" type="text" placeholder="Mustermann" name="lastname" value="<?= $lastname; ?>">
                    <div><?= $errorlastname;?></div>
            <label class="col s-12">E-Mail:</label>
                <input class="col s-12" type="email" placeholder="MaxMustermann@web.de" name="email" value="<?= $email; ?>">
                    <div><?= $erroremail . $errordoubleemail;?></div>
            <label class="col s-12">Password (Minimum 8 Chars):</label>
                <input class="col s-12" type="password" name="password">
                    <div><?= $errorpassword;?></div>
            <label class="col s-12">Repeat Password:</label>
                <input class="col s-12" type="password" name="password2">
                    <div><?= $errorpassword2;?></div>
            <label class="col s-12">Accept the AGB's:</label>
                <input class="col s-12" type="checkbox" name="agbcheckbox">
                    <div><?= $errorcheckbox;?></div>
                    <button class="col s-12 btn" name="register" value="register">REGISTER</button>
                        <h3 class="col s-12"><a href="login.php">LOGIN?</a></h3>
        </form>
    </div>
</main>
<?php
// Footer einfügen
include('templates/footer.php');
?>