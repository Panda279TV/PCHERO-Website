<?php
// Fehlermeldungen anzeigen, aber nur wenn man im Localhost ist
require_once('displayserrors.php');

// Eine Session Sitzung starten
session_start();

// Header einfügen
include('templates/absolute-header.php');

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
	<div class="carousel carousel-slider">
		<a class="carousel-item" href="#one!"><img src="img/slide-home-1-pixabay.jpg" alt="pc-components-slide-1"></a>
		<a class="carousel-item" href="#two!"><img src="img/slide-home-2-pixabay.jpg" alt="pc-components-slide-2"></a>
	    <a class="carousel-item" href="#three!"><img src="img/slide-home-3-pixabay.jpg" alt="pc-components-slide-3"></a>
	    <a class="carousel-item" href="#five!"><img src="img/slide-home-4-pixabay.jpg" alt="pc-components-slide-4"></a>
	    	<a class="arrow prev">&#10094;</a>
			<a class="arrow next">&#10095;</a>
	</div>
	<div class="row container-heroimg">
		<div class="col s-11 m-11 l-10 xl-9 main-heroimg">
			<h1>Configure something unique!</h1>
				<a href="configurator.php" class="btn btncards">CONFIGURATOR</a>

		</div>
	</div>

	<div class=" cards-flex">
		<a href="configurator.php">
			<div class="card-container" data-aos="zoom-in-up" data-aos-delay="125" data-aos-easing="ease-in-back" data-aos-once="true">
			    <div class="card">
			        <div class="card-image">
			        	<img src="img/guenstige-komponenten-home-pixabay.jpg" alt="cheap-components">
			        </div>
			        <div class="card-content">
			        	<span class="card-title">Cheap Components</span>
			        		<p>We have super cheap components. In addition we only have the best of the best. Click me and go directly to the Configurator and choose the best and cheapest components!</p>
			        </div>
			    </div>
			</div>
		</a>
		<a href="configurator.php">
			<div class="card-container" data-aos="zoom-in-up" data-aos-delay="250" data-aos-easing="ease-in-back" data-aos-once="true">
			    <div class="card">
			        <div class="card-image">
			        	<img src="img/große-auswahl-home-pixabay.jpg" alt="brand-Name-products">
			        </div>
			        <div class="card-content">
			        	<span class="card-title">Brand-Name Products</span>
			        		<p>You want branded products, we have them. From Intel to AMD, from Nvidia to Samsung. We have not only the best brands, but also real secret tip brands. Click me and go directly to the Configurator and choose the best branded products!</p>
			        </div>
			    </div>
			</div>
		</a>
		<a href="configurator.php">
			<div class="card-container" data-aos="zoom-in-up" data-aos-delay="375" data-aos-easing="ease-in-back" data-aos-once="true">
				<div class="card">
				    <div class="card-image">
				        <img src="img/große-auswahl-home-pixabay.jpg" alt="many-products">
				    </div>
			        <div class="card-content">
			        	<span class="card-title">Many Products</span>
			        		<p>We have over 1000+ selection of components. We will extend these again and again. We want to try to have as many components as possible to give you such a huge choice. Click me and go directly to the Configurator and choose over 1000+ products!</p>
			        </div>
				</div>
			</div>
		</a>
	</div>
</main>
<?php
// Footer einfügen
include('templates/footer.php');
?>