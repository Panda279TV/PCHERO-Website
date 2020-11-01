<?php
// Fehlermeldungen anzeigen, aber nur wenn man im Localhost ist
require_once('displayserrors.php');

// Eine Session Sitzung starten
session_start();

// Header einfügen
include('templates/header.php');

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
	<div class="row aboutUsContainer">
		<h1 class="col s-10 centerWidth" data-aos="zoom-in-up" data-aos-delay="100" data-aos-easing="ease-in-back" data-aos-once="true">ABOUT US</h1>
		<p class="col s-10 centerWidth" data-aos="zoom-in-up" data-aos-delay="350" data-aos-easing="ease-in-back" data-aos-once="true">We have been in the PC business since 2000. We are and have grown steadily. Benedikt Wolf has created the business and made progress. Before he worked alone on the idea and the more successful the business became the more employees came to us. At the moment there are three of us, but we are still looking for new people who want to work for us. In the future we plan to make ourselves bigger, to recruit more employees, to add more content and products! The whole PCHERO team wishes you lots of fun surfing and buying!</p>
	</div>

	<div>
		<div class="staffContainer">
			<div class="staff">
				<img src="img/staff-1-pixabay.png" alt="staff-benedikt-wolf" data-aos="zoom-in-up" data-aos-delay="150" data-aos-easing="ease-in-back" data-aos-once="true">
					<h1 class="centerWidth" data-aos="zoom-in-up" data-aos-delay="300" data-aos-easing="ease-in-back" data-aos-once="true">Benedikt Wolf</h1>
						<p data-aos="zoom-in-up" data-aos-delay="450" data-aos-easing="ease-in-back" data-aos-once="true">I'm Benedikt and i studied webdesign for 2 years and then worked in some small and big companies. After that I wanted to become self-employed and do my own thing and created PCHERO. My hobbies are games, cycling and going to the gym.</p>
			</div>
			<div class="staff">
				<img src="img/staff-2-pixabay.png" alt="staff-julia-bauer" data-aos="zoom-in-up" data-aos-delay="150" data-aos-easing="ease-in-back" data-aos-once="true">
					<h1 class="centerWidth" data-aos="zoom-in-up" data-aos-delay="300" data-aos-easing="ease-in-back" data-aos-once="true">Julia Bauer</h1>
						<p data-aos="zoom-in-up" data-aos-delay="450" data-aos-easing="ease-in-back" data-aos-once="true">I am Julia and I have been working with PCs before and I like to assemble and disassemble them myself. I am very committed and always give my best. My hobbies are visiting fairs, reading books and swimming.</p>
			</div>
			<div class="staff">
				<img src="img/staff-3-pixabay.png" alt="staff-boris-becker" data-aos="zoom-in-up" data-aos-delay="150" data-aos-easing="ease-in-back" data-aos-once="true">
					<h1 class="centerWidth" data-aos="zoom-in-up" data-aos-delay="300" data-aos-easing="ease-in-back" data-aos-once="true">Boris Beckers</h1>
						<p data-aos="zoom-in-up" data-aos-delay="450" data-aos-easing="ease-in-back" data-aos-once="true">My name is Boris and yes I like to play tennis, but I am not the famous Boris Becker. I like to play computer games that have high demands on the PC and I always have the best components at the start. My hobbies are playing football, gambling and going to the casino.</p>
			</div>
			<div class="staff">
				<img src="img/staff-0-yourname-pixabay.png" alt="staff-your-name" data-aos="zoom-in-up" data-aos-delay="150" data-aos-easing="ease-in-back" data-aos-once="true">
					<h1 class="centerWidth" data-aos="zoom-in-up" data-aos-delay="300" data-aos-easing="ease-in-back" data-aos-once="true">Your Name</h1>
						<p data-aos="zoom-in-up" data-aos-delay="450" data-aos-easing="ease-in-back" data-aos-once="true">This field is empty, that's a pity. Here you could stand and fill the field as you like. Apply with us. Write your application and all the documents to job@pchero.com</p>
			</div>
		</div>
	</div>	
</main>
<?php
// Footer einfügen
include('templates/footer.php');
?>