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

// Error Variable leer setzen
$error_msg = "";

// Schaut ob die $_SESSION logincount vorhanden und etwas drinne ist, ansonsten setzte sie auf 0
if (!isset($_SESSION['logincount'])) {
    $_SESSION['logincount'] = 0;
}

// Lass dir die Session Variable logincount ausgeben und schauen wie hoch der Counter ist
// var_dump($_SESSION['logincount']);

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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = false;

    // Es werden sich alle Eingaben geholt und durch die trim_input Funktion gejagt
    $email = trim_input($_POST['email']);
    $password = trim_input($_POST['password']);
    $currentTimestamp = date("Y-m-d H:i:s");

    $statement = $dbh -> prepare("SELECT * FROM User WHERE email = :email");
    
    $statement -> execute(array('email' => $email));
    
    $user = $statement -> fetch();

    // Überprüfen was dabei herauskommt
    // echo "<pre>";
    // var_dump($user);
    // echo "<pre>";

    // Wenn die Variable Email oder Password leer sind, dann gib eine Fehlermeldung aus
    if ($email == "" || $password == "") {
        $errorMessage = '<h4 class="loginError">Please enter an Email and a Password!</h4>';
    
    // Stimmt das Passwort mit der Email von der Datenbank mit ein, dann mach bitte weiter und führe die anderen Sachen aus
    } elseif ($user !== false && password_verify($password, $user['password'])) {
        $error = false;

        $data = $dbh -> prepare("UPDATE User SET
            
            lastlogin=:lastlogin

            WHERE email=:email");

        $data -> execute(array('email' => $email, ':lastlogin' => $currentTimestamp));


        // Die Keys in der Variable $_SESSION speichern und das wird dann später ausgegeben und dient dazu zu wissen ob jemand eingeloggt ist und welchen Status er besitzt
        $_SESSION['userid'] = $user["id"];
        $_SESSION['usertype'] = $user["usertype"];
        $_SESSION['userfirstname'] = $user["firstname"];
        $_SESSION['userlastname'] = $user["lastname"];
        $_SESSION['userlastlogin'] = $user["lastlogin"];
        $_SESSION['timestamp']=time();
        
        
        // Wenn man sich richtig eingeloggt hat, dann wird der Logincount auf 0 zurückgesetzt
        $_SESSION['logincount'] = 0;
        
        // Testen was bei der $_SESSION rauskommt
        // var_dump($_SESSION);

        // Wenn alles erfolgreich war dann alles unterbrechen und die Meldung anzeigen und weiter zum Dahsboard verlinken
        die('<div style="width: 100vw; height: 100vh; display: flex; text-align: center; align-content: center; align-items: center; flex-wrap: wrap; justify-content: center;">
            <h1 style="width: 100%; padding: 3%; background: green; color:white;"> Login successful!</h1>
            <h1 style="width: 100%;">
            <a href="dashboard.php">Continue to Dashboard!</a>
            </h1>
            </div>');
    
    // Wenn die Email oder das Passwort nicht stimmt, dann soll eine Fehlermeldung kommen und durch den error = true wird der logincount erhöht, siehe eins unten drunter
    } else {
        $errorMessage = '<h4 class="loginError">E-mail or Password are invalid!</h4>';
        $error = true;
    }

    // Wenn auf den Button Login gedrückt wird und man eine falsche Email oder ein falsches Passwort eingegeben hat, dann wird die Session logincount erhöht und gezählt
    if ($error == true){
        $_SESSION['logincount']++;

        // Die Session logincount wird ausgegeben um zu schauen wie hoch der Count ist
        // var_dump($_SESSION['logincount']);

        // Ist die Session über 3 (also 4 und höher) mal dann wird man gesperrt
        if ($_SESSION['logincount'] > 3) {
            // Leert sicherheitshalber die Session
            unset($_SESSION);
            // Stellt sicher, dass User trotzdem geblockt bleibt
            $_SESSION['logincount'] = 4;
            session_destroy();
            // Weiterleitung zu der Error Page
            header("Location: 404.php");
        }
    }
}
?>
<?php
// Header einfügen
include('templates/fixed-header.php');
?>
<main>
	<div class="row loginContainer">
		<form class="col s-10 m-8 l-6 xl-5 loginForm" action="" method="post">
			<?php // Fehlermeldung anzeigen lassen, falls Email oder Password falsch sind
			if(isset($errorMessage)) {
			    echo $errorMessage;
			} ?>
                <input class="col s-12" type="hidden" name="xsrf-token" value="">
			<label class="col s-12">E-Mail:</label>
                <input class="col s-12" type="email" placeholder="Your Email!" name="email" autofocus>
			<label class="col s-12">Password:</label>
                <input class="col s-12" type="password" placeholder="Your Password!" name="password">
                    <button class="col s-12 btn" type="submit" name="login" value="Login">LOGIN</button>
                        <h3><a class="col s-12" href="registration.php">REGISTRATION?</a></h3>
		</form>
	</div>
</main>
<?php
// Footer einfügen
include('templates/fixed-footer.php');
?>