<?php
// Fehlermeldungen anzeigen, aber nur wenn man im Localhost ist
require_once('displayserrors.php');

// Eine Session Sitzung starten
session_start();

// Macht die Session Variablen leer, damit sie jemand nach dem Logout nicht hat und auslesen kann
unset($_SESSION);

// Aktuelle Session Sitzung beenden
session_destroy();
?>
<?php
// Header einfügen
include('templates/fixed-header.php');
?>
	<main>
		<div class="logoutContainer">
			<h1 data-aos="zoom-in-up" data-aos-delay="150" data-aos-easing="ease-in-back" data-aos-once="true">Logout successful!</h1>
			<h1 data-aos="zoom-in-up" data-aos-delay="300" data-aos-easing="ease-in-back" data-aos-once="true"><a href="index.php">GO TO THE HOME SITE!</a></h1>
		</div>	
	</main>
<?php
// Footer einfügen
include('templates/fixed-footer.php');
?>