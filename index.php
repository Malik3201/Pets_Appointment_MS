<?php include 'includes/header.php'; ?>

<section class="hero">
	<div class="hero-left">
		<h2 class="hero-title">Caring for your pets with ❤️ and technology</h2>
		<p class="hero-tag">Book, manage, and love your pets — all in one place.</p>
		<a class="btn hero-cta" href="book_appointment.php">Book Appointment</a>
	</div>
	<div class="hero-right">
		<img class="pet-img" src="https://pngimg.com/uploads/dog/dog_PNG50374.png" alt="Dog">
		<img class="pet-img" src="https://pngimg.com/uploads/cat/cat_PNG50531.png" alt="Cat">
		<img class="pet-img" src="https://pngimg.com/uploads/rabbit/rabbit_PNG3786.png" alt="Rabbit">
	</div>
</section>

<section class="why">
	<h2>Why Choose PetCare?</h2>
	<div class="why-grid">
		<div class="why-card reveal">
			<div class="icon">🩺</div>
			<h3>Professional Veterinary Care</h3>
			<p>Experienced staff and reliable services to keep your pets healthy.</p>
		</div>
		<div class="why-card reveal">
			<div class="icon">⏱️</div>
			<h3>Easy Online Appointments</h3>
			<p>Simple scheduling and management for busy pet parents.</p>
		</div>
		<div class="why-card reveal">
			<div class="icon">🔒</div>
			<h3>Secure & Private System</h3>
			<p>Your data is protected with modern security practices.</p>
		</div>
	</div>
</section>

<section class="highlights">
	<div class="hl-row">
		<div class="hl-card tilt-left reveal">
			<h3>Wellness Checkups</h3>
			<p>Regular health checks to keep your pet happy and thriving.</p>
		</div>
		<img class="hl-img reveal" src="https://pngimg.com/uploads/dog/dog_PNG50372.png" alt="Dog wellness">
	</div>
	<div class="hl-row" style="margin-top:20px;">
		<img class="hl-img reveal" src="https://pngimg.com/uploads/cat/cat_PNG50522.png" alt="Cat care">
		<div class="hl-card tilt-right reveal">
			<h3>Gentle Grooming</h3>
			<p>Professional grooming for a clean, comfortable, and stylish pet.</p>
		</div>
	</div>
	<div class="hl-row" style="margin-top:20px;">
		<div class="hl-card tilt-left reveal">
			<h3>Small Pet Care</h3>
			<p>Special attention for hamsters, rabbits, and more.</p>
		</div>
		<img class="hl-img reveal" src="https://pngimg.com/uploads/hamster/hamster_PNG128.png" alt="Hamster care">
	</div>
</section>

<script>
// Simple scroll reveal
var reveals = Array.prototype.slice.call(document.querySelectorAll('.reveal'));
function onScrollReveal(){
	var vh = window.innerHeight || document.documentElement.clientHeight;
	reveals.forEach(function(el){
		var rect = el.getBoundingClientRect();
		if (rect.top < vh - 60) { el.classList.add('show'); }
	});
}
document.addEventListener('scroll', onScrollReveal);
window.addEventListener('load', onScrollReveal);
</script>

<?php include 'includes/footer.php'; ?>


