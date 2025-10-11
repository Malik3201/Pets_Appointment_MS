<?php
// Set page title for header
$page_title = 'Pets Care - Professional Veterinary Care';
require __DIR__ . '/partials/header.php';
?>

<!-- Hero Section with Local Background Video -->
<section class="hero" data-bg="assets/bgVideo/Hero-bg-video.mp4">
    <!-- Local Video Background -->
    <video class="hero-video-bg" autoplay muted loop playsinline poster="assets/bgVideo/main_bg.jpg">
        <source src="assets/bgVideo/Hero-bg-video.mp4" type="video/mp4">
        <!-- Fallback image if video doesn't load -->
        <div class="hero-fallback" style="background-image: url('assets/bgVideo/main_bg.jpg');"></div>
        Your browser does not support the video tag.
    </video>
    
    <div class="hero-content">
        <h1>Trusted Veterinary Care for Your Beloved Pets</h1>
        <p>Professional medical services, compassionate care, and state-of-the-art facilities to keep your pets healthy and happy.</p>
			<div class="cta-group">
            <a href="book_appointment.php" class="btn btn--primary">Book Appointment</a>
            <a href="#services" class="btn btn--white">Explore Services</a>
		</div>
	</div>
</section>

<!-- About Our Clinics Section -->
<section class="section" data-bg="assets/bgVideo/main_bg.jpg">
    <div class="container">
        <div class="section-content">
            <div class="section-header">
                <h2 class="section-title">About Our Clinics</h2>
                <p class="section-subtitle">Providing comprehensive veterinary care with state-of-the-art facilities and experienced professionals dedicated to your pet's health and wellbeing.</p>
	</div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number">25+</span>
                    <span class="stat-label">Years of Experience</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">15</span>
                    <span class="stat-label">Certified Specialists</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">8</span>
                    <span class="stat-label">Medical Departments</span>
		</div>
                <div class="stat-card">
                    <span class="stat-number">5</span>
                    <span class="stat-label">Branch Locations</span>
		</div>
	</div>
		</div>
	</div>
</section>

<!-- Services Grid Section -->
<section class="section" id="services" data-bg="assets/bgVideo/main_bg.jpg">
    <div class="container">
        <div class="section-content">
            <div class="section-header">
	<h2 class="section-title">Our Services</h2>
                <p class="section-subtitle">Comprehensive veterinary care covering all aspects of your pet's health, from routine checkups to specialized treatments.</p>
            </div>
            
            <div class="services-grid">
                <div class="service-card red-frame">
                    <div class="card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3>Wellness Exam</h3>
                    <p>Comprehensive health checkups to ensure your pet is in optimal condition with preventive care and early detection.</p>
                    <a href="#" class="btn btn--ghost">Explore More</a>
                </div>
                
                <div class="service-card red-frame">
                    <div class="card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3>Grooming</h3>
                    <p>Professional grooming services including bathing, nail trimming, and styling to keep your pet looking and feeling great.</p>
                    <a href="#" class="btn btn--ghost">Explore More</a>
                </div>
                
                <div class="service-card red-frame">
                    <div class="card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
		</div>
			<h3>Vaccinations</h3>
                    <p>Essential vaccinations to protect your pet from common diseases and maintain their long-term health and immunity.</p>
                    <a href="#" class="btn btn--ghost">Explore More</a>
                </div>
                
                <div class="service-card red-frame">
                    <div class="card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                        </svg>
                    </div>
                    <h3>Laboratory</h3>
                    <p>Advanced diagnostic testing and laboratory services for accurate diagnosis and monitoring of your pet's health conditions.</p>
                    <a href="#" class="btn btn--ghost">Explore More</a>
                </div>
                
                <div class="service-card red-frame">
                    <div class="card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                        </svg>
                    </div>
                    <h3>Dentistry</h3>
                    <p>Professional dental care including cleanings, extractions, and oral health treatments to maintain your pet's dental hygiene.</p>
                    <a href="#" class="btn btn--ghost">Explore More</a>
                </div>
                
                <div class="service-card red-frame">
                    <div class="card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3>Surgery</h3>
                    <p>Advanced surgical procedures performed by experienced veterinarians in our state-of-the-art operating facilities.</p>
                    <a href="#" class="btn btn--ghost">Explore More</a>
		</div>
		</div>
		</div>
	</div>
</section>

<!-- Testimonials Section -->
<section class="section" data-bg="assets/bgVideo/main_bg.jpg">
    <div class="container">
        <div class="section-content">
            <div class="section-header">
                <h2 class="section-title">What Our Clients Say</h2>
                <p class="section-subtitle">Hear from pet owners who trust us with their beloved companions' health and wellbeing.</p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial">
                    <p>The staff at Pets & Vets treated my dog Max with such care and compassion. The facility is clean, modern, and the veterinarians are highly knowledgeable. I couldn't ask for better care for my furry family member.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">SM</div>
                        <div class="testimonial-info">
                            <h4>Sarah Mitchell</h4>
                            <p>Owner of Max (Golden Retriever)</p>
                            <div class="testimonial-stars">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial">
                    <p>When my cat Luna needed emergency surgery, the team at Pets & Vets was incredible. They explained everything clearly, kept me updated throughout the process, and Luna made a full recovery. I'm so grateful for their expertise and care.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">DJ</div>
                        <div class="testimonial-info">
                            <h4>David Johnson</h4>
                            <p>Owner of Luna (Persian Cat)</p>
                            <div class="testimonial-stars">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial">
                    <p>The grooming services here are outstanding. My dog Charlie always looks and smells amazing after his visits. The staff is gentle, patient, and truly cares about the animals. Highly recommend to all pet owners!</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">RW</div>
                        <div class="testimonial-info">
                            <h4>Rachel Williams</h4>
                            <p>Owner of Charlie (Poodle)</p>
                            <div class="testimonial-stars">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                        </div>
		</div>
		</div>
		</div>
		</div>
	</div>
</section>

<!-- Branches Map Section -->
<section class="section" id="branches" data-bg="assets/bgVideo/main_bg.jpg">
    <div class="container">
        <div class="section-content">
            <div class="section-header">
                <h2 class="section-title">Our Branches</h2>
                <p class="section-subtitle">Conveniently located veterinary clinics across the city, each equipped with modern facilities and experienced staff.</p>
            </div>
            
            <div class="branches-grid">
                <div class="branch-card red-frame">
                    <div class="branch-map">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <span>Interactive Map</span>
                    </div>
                    <div class="branch-info">
                        <h3>Downtown Clinic</h3>
                        <p>Our flagship location in the heart of the city, offering comprehensive veterinary services with extended hours and emergency care.</p>
                        <a href="#" class="btn btn--ghost">Explore More</a>
                    </div>
	</div>
                
                <div class="branch-card red-frame">
                    <div class="branch-map">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <span>Interactive Map</span>
                    </div>
                    <div class="branch-info">
                        <h3>Westside Branch</h3>
                        <p>Conveniently located in the west district, specializing in routine care, grooming, and preventive medicine services.</p>
                        <a href="#" class="btn btn--ghost">Explore More</a>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>

<!-- CTA Section -->
<section class="cta-section" data-bg="assets/bgVideo/main_bg.jpg">
    <div class="container">
        <h2>Trusted Care Across Our Branches</h2>
        <p>Join thousands of pet owners who trust us with their beloved companions' health and wellbeing.</p>
        <a href="book_appointment.php" class="btn btn--white">Book Your Appointment Today</a>
	</div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>