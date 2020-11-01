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

// Header einfügen
include('templates/header.php');

?>
<main>
	<div class="configuratorContainer">
		<h1 class="centerWidth">CONFIGURATOR</h1>
<?php

// Verbindung zur Datenbank wird hergestellt
require_once('database.php');

// Die ganzen Buttons werden generiert und in einer Variable gespeichert
$formConfiguratorButtons = '<form class="formConfigurator" action="" method="post" enctype="multipart/form-data">
			<input class="btn" type="submit" name="edit" value="All"></input>
			<input class="btn" type="submit" name="edit" value="Case"></input>
			<input class="btn" type="submit" name="edit" value="Processor"></input>
			<input class="btn" type="submit" name="edit" value="GraphicsCard"></input>
			<input class="btn" type="submit" name="edit" value="RamMemory"></input>
			<input class="btn" type="submit" name="edit" value="Motherboard"></input>
			<input class="btn" type="submit" name="edit" value="CoolingSystem"></input>
			<input class="btn" type="submit" name="edit" value="Fan"></input>
			<input class="btn" type="submit" name="edit" value="SSDMemory"></input>
			<input class="btn" type="submit" name="edit" value="HDDMemory"></input>
			<input class="btn" type="submit" name="edit" value="Other"></input>
		</form>';

echo $formConfiguratorButtons;


echo '<br><br><div style="width: 100%; border-bottom: 15px solid black;"></div><br>';

// Mit Post wird abgefragt welcher Button geklickt wurde und dann führe diese Funktion aus
if (!isset($_POST['edit'])) $_POST['edit'] = "";

if ($_POST['edit'] == 'All') {
	echo allcategoryEntry($dbh);

} elseif ($_POST['edit'] == 'Case'){
	echo categoryEntry($dbh, "Case");

} elseif ($_POST['edit'] == 'Processor') {
	echo categoryEntry($dbh, "Processor");

} elseif ($_POST['edit'] == 'GraphicsCard') {
	echo categoryEntry($dbh, "GraphicsCard");

} elseif ($_POST['edit'] == 'RamMemory') {
	echo categoryEntry($dbh, "RamMemory");

} elseif ($_POST['edit'] == 'Motherboard') {
	echo categoryEntry($dbh, "Motherboard");

} elseif ($_POST['edit'] == 'CoolingSystem') {
	echo categoryEntry($dbh, "CoolingSystem");

} elseif ($_POST['edit'] == 'Fan') {
	echo categoryEntry($dbh, "Fan");

} elseif ($_POST['edit'] == 'SSDMemory') {
	echo categoryEntry($dbh, "SSDMemory");

} elseif ($_POST['edit'] == 'HDDMemory') {
	echo categoryEntry($dbh, "HDDMemory");
} elseif ($_POST['edit'] == 'Other') {
	echo categoryEntry($dbh, "Other");
} else {
	echo allcategoryEntry($dbh);
}

// Funktion zeigt alle Komponenten an, die es in der Datenbank Konfigurator gibt
function allcategoryEntry ($dbh){

    $data = $dbh -> prepare("SELECT * FROM Configurator");
    
   	$data -> execute();

   	// Mach eine Schleife und gib alles in der Tabelle Configurator aus, was ich möchte
	while ($row = $data -> fetch(PDO::FETCH_ASSOC))
	{
	?>
	<div class="configurator">
		<!-- <input type="radio" name="selectComponent"> -->
		<!-- <label>Select the Component</label> -->
		<h3 data-aos="zoom-in-up" data-aos-delay="100" data-aos-easing="ease-in-back" data-aos-once="true"><?php echo $row['heading']; ?></h3>
		<img src="<?php echo $row['image']; ?>" alt="<?php echo $row['image']; ?>" data-aos="zoom-in-up" data-aos-delay="200" data-aos-easing="ease-in-back" data-aos-once="true">
		<p data-aos="zoom-in-up" data-aos-delay="300" data-aos-easing="ease-in-back" data-aos-once="true"><?php echo $row['text']; ?></p>
	</div>
	<?php
	}
}
?>
<?php

// Funktion zeigt die Kategorie an, die ich in dem zweiten Parameter mit gebe
function categoryEntry ($dbh, string $categoryName){
    $data = $dbh -> prepare("SELECT * FROM Configurator WHERE category = '$categoryName'");
    
	$data -> execute();

   	// Mach eine Schleife und gib alles in der Tabelle Configurator aus, was ich möchte
	while ($row = $data -> fetch(PDO::FETCH_ASSOC))
	{
	?>
	<div class="configurator">
		<!-- <input type="radio" name="selectComponent"> -->
		<!-- <label>Select the Component</label> -->
		<h3 data-aos="zoom-in-up" data-aos-delay="100" data-aos-easing="ease-in-back" data-aos-once="true"><?php echo $row['heading']; ?></h3>
		<img src="<?php echo $row['image']; ?>" alt="<?php echo $row['image']; ?>" data-aos="zoom-in-up" data-aos-delay="200" data-aos-easing="ease-in-back" data-aos-once="true">
		<p data-aos="zoom-in-up" data-aos-delay="300" data-aos-easing="ease-in-back" data-aos-once="true"><?php echo $row['text']; ?></p>
	</div>
	<?php
	}
}
?>
	</div>
</main>
<?php
// Footer einfügen
include('templates/footer.php');
?>