<?php
// Fehlermeldungen anzeigen, aber nur wenn man im Localhost ist
require_once('displayserrors.php');

// Eine Session Sitzung starten
session_start();

// Header einfügen
include('templates/fixed-header.php');

// Ist der User eingeloggt, zeige bitte den Button unten rechts an
if(isset($_SESSION['userid'])){
    echo '<div>
        <a class="btnfirst" data-aos="zoom-in-up" data-aos-delay="1000" data-aos-easing="ease-in-back" data-aos-once="true"><button class="btn btnMenuFirst">&#10133;</button></a>
        <a href="logout.php"><button class="btn btnMenuSecond ">&#128163;</button></a>
        <a href="dashboard.php"><button class="btn btnMenuThree ">&#128221;</button></a>
        </div>';
}
?>
<main>
	<div class="errorPageContainer">
		<h1 data-aos="zoom-in-up" data-aos-delay="100" data-aos-easing="ease-in-back" data-aos-once="true">Something went wrong!</h1>
		<h1 data-aos="zoom-in-up" data-aos-delay="200" data-aos-easing="ease-in-back" data-aos-once="true">A technician is on his way and looks at the whole thing!</h1>
		<h1 data-aos="zoom-in-up" data-aos-delay="300" data-aos-easing="ease-in-back" data-aos-once="true">Either this page doesn't exist or you don't have the required rights!</h1>
		<h1 data-aos="zoom-in-up" data-aos-delay="400" data-aos-easing="ease-in-back" data-aos-once="true"><a href="index.php">PLEASE GO TO THE HOME SITE!</a></h1>
	</div>
</main>
<?php
// Footer einfügen
include('templates/fixed-footer.php');
?>