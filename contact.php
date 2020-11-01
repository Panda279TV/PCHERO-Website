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

// Error Variablen werden leer gemacht, damit sie als leer angezeigt werden und keine Anfangsfehlermeldungen kommen
$errorfirstname = $errorlastname = $erroremail = $errormessage = $errorcheckbox = $sentError = $sentSuccess = $firstname = $lastname = $email = $message = $checkbox = "";

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
    $firstname = trim_input(ucfirst($_POST['firstname']));
    $lastname = trim_input(ucfirst($_POST['lastname']));
    $email = trim_input($_POST['email']);
    $message = trim_input($_POST['message']);
    $checkbox = $_POST['agbcheckbox'];
    
    // Schaut ob der Vorname alles beinhaltet, was ich mit preg_match vorgegeben habe
    if(!preg_match('/^[a-zäöüÄÖÜ ]{2,50}$/i', $firstname)) {
        $errorfirstname = '<p class="contactError"> Please enter a valid First Name! <p>';
        $error = true;
    }
    // Schaut ob der Nachname alles beinhaltet, was ich mit preg_match vorgegeben habe
    if(!preg_match('/^[a-zäöüÄÖÜ ]{2,50}$/i', $lastname)) {
        $errorlastname = '<p class="contactError"> Please enter a valid Last Name! <p>';
        $error = true;
    }
    // Schaut ob die E-Mail alles beinhaltet, was ich mit preg_match vorgegeben habe
    if(!preg_match('/^[a-z0-9_.+-]{2,60}@[a-zA-Z0-9.-]{2,20}.[a-zA-Z]{2,10}$/i', $email)) {
        $erroremail = '<p class="contactError"> Please enter a valid E-Mail Address! <p>';
        $error = true;
    }
    // Schaut ob die Textarea alles beinhaltet, was ich mit preg_match vorgegeben habe
    if(!preg_match('/^[a-zäöü0-9_.,\'#!?+ -]{20,5000}$/i', $message)) {
        $errormessage = '<p class="contactError"> Please enter a message to us! <p>';
        $error = true;
    }
    // Schaut ob die Checkbox angeklickt wurde
    if (!isset($checkbox)) {
        $errorcheckbox = '<p class="contactError"> Please accept the AGBS! <p>';
        $error = true; 
    }
    
    // Wenn es keine Fehler bei der Registration gab, dann soll alles was eingegeben wurde in die Datenbank importiert werden
    // Desweiteren wird das Passwort in gehashter Form gespeichert, sodass es schwieriger auszulesen ist
    if(!$error) {
        $statement = $dbh -> prepare("INSERT INTO Contact (firstname, lastname, email, message) VALUES (:firstname, :lastname, :email, :message)");
        
        $result = $statement -> execute(array('firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'message' => $message));
        
        // Wir überprüfen ob es geklappt hat mit Bool
        if($result == true) {
        	$sentSuccess = '<h3 class="sentSucces"> THE FORM WAS SENT SUCCESSFULLY!<h3>';
            $firstname = $lastname = $email = "";
        } else {
        	$sentError = '<h3 class="sentError"> UNFORTUNATELY AN ERROR OCCURRED DURING SAVING. PLEASE TRY IT AGAIN! </h3>';
        }
    } 
}
?>
<?php
// Header einfügen
include('templates/header.php');
?>
	<main>
		<div class="faqHeading"><h1>FAQ</h1></div>
			<ul class="collapsible popout">
				<li>
			    	<div class="collapsible-header" data-aos="zoom-in-up" data-aos-delay="150" data-aos-easing="ease-in-back" data-aos-once="true">
			      		<p>When can I wait with new products?</p>
			      		<span class="badge"><i class="material-icons">&plus;</i></span>
			  		</div>
			    		<div class="collapsible-body"><p>We try to add new products as soon as possible. Unfortunately, we cannot say exactly when new things will be added. Just wait a round and have a cup of tea!</p></div>
			  	</li>
			  	<li>
			    	<div class="collapsible-header" data-aos="zoom-in-up" data-aos-delay="300" data-aos-easing="ease-in-back" data-aos-once="true">
			      		<p>I can't log in?</p>
			      		<span class="badge"><i class="material-icons">&plus;</i></span>
			  		</div>
			    		<div class="collapsible-body"><p>Have you registered yet? Wait 1-3 minutes and update your browser or delete the cache. Then check carefully if you have spelled your email or password correctly. If it still doesn't work, please send us an email with your email address to support@pchero.com</p></div>
			  	</li>
			  	<li>
			    	<div class="collapsible-header" data-aos="zoom-in-up" data-aos-delay="450" data-aos-easing="ease-in-back" data-aos-once="true">
			      		<p>I can't register?</p>
			      		<span class="badge"><i class="material-icons">&plus;</i></span>
			  		</div>
			    		<div class="collapsible-body"><p>Please check if you have entered all data correctly. For example, we do not allow code lines or other pages in the inputs. Try updating the browser again or clearing the cache.</p></div>
			  	</li>
			    <li>
			    	<div class="collapsible-header" data-aos="zoom-in-up" data-aos-delay="600" data-aos-easing="ease-in-back" data-aos-once="true">
			      		<p>My account is locked or deleted, what can I do?</p>
			      		<span class="badge"><i class="material-icons">&plus;</i></span>
			  		</div>
			    			<div class="collapsible-body"><p>Just send an email to support@pchero.com and tell us your email address and what exactly happened.</p></div>
			  	</li>
			    <li>
			    	<div class="collapsible-header" data-aos="zoom-in-up" data-aos-delay="750" data-aos-easing="ease-in-back" data-aos-once="true">
			      		<p>What's the best way to reach you?</p>
			      		<span class="badge"><i class="material-icons">&plus;</i></span>
			  		</div>
			    			<div class="collapsible-body"><p>By phone to +49 62736 728372398 , by email to info@pchero.com and you can also use the contact form and send it. We will contact you as soon as possible.</p></div>
			  	</li>
			</ul>
			<div class="row contactContainer">
			    <form class="col s-10 m-8 l-6 xl-5" id="formContactScroll" action="contact.php#formContactScroll" method="post">
			    	<div><?= $sentSuccess . $sentError;?></div>
			    	<label class="col s-12">Firstname:</label>
                		<input class="col s-12" type="text" placeholder="Max" name="firstname" value="<?= $firstname; ?>" autofocus>
                    		<div><?= $errorfirstname;?></div>
            		<label class="col s-12">Lastname:</label>
                		<input class="col s-12" type="text" placeholder="Mustermann" name="lastname" value="<?= $lastname; ?>">
                    		<div><?= $errorlastname;?></div>
            		<label class="col s-12">E-Mail:</label>
                		<input class="col s-12" type="email" placeholder="MaxMustermann@web.de" name="email" value="<?= $email; ?>">
                    		<div><?= $erroremail?></div>
                    <label class="col s-12">Message (Minimum 20 Chars):</label>
                    	<textarea class="col s-12" rows="3" placeholder="Hello PC Hero Team! I wanted to thank you for your efforts and did! Furthermore, I wanted to ask when new products will be released? greet Max Mustermann" name="message" value="<?= $message; ?>"></textarea>
                    		<div class="contactTopMargin"><?= $errormessage;?></div>
                    <label class="col s-12">Accept the AGB's: </label>
                		<input class="col s-12" type="checkbox" name="agbcheckbox">
                    		<div><?= $errorcheckbox;?></div>
                   	<button class="col s-12 btn" name="send" value="send">SEND</button>
			    </form>
			</div>
	</main>
<?php
// Footer einfügen
include('templates/footer.php');
?>