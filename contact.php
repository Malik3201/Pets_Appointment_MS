<?php
// Contact page for Canberra Pets Care Hospital
$page_title = 'Contact Us - Canberra Pets Care Hospital';
require __DIR__ . '/partials/header.php';
?>

<!-- Contact Section -->
<section class="section" data-bg="assets/bgVideo/main_bg.jpg">
    <div class="container">
        <div class="section-content">
            <div class="section-header">
                <h1 class="section-title">Contact Us</h1>
                <p class="section-subtitle">Get in touch with our team for appointments, questions, or emergency care.</p>
            </div>
            
            <div class="contact-container">
                <div class="contact-grid">
                    <!-- Contact Information -->
                    <div class="contact-info-card">
                        <h3 class="contact-card-title">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            Visit Our Clinic
                        </h3>
                        
                        <div class="contact-details">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h4>Address</h4>
                                    <p>123 Veterinary Street<br>Canberra, ACT 2600<br>Australia</p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h4>Phone</h4>
                                    <p><a href="tel:+61234567890">+61 2 3456 7890</a></p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h4>Email</h4>
                                    <p><a href="mailto:info@petscare.com.au">info@petscare.com.au</a></p>
                                </div>
                            </div>
                            
                            <div class="contact-item emergency">
                                <div class="contact-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h4>Emergency</h4>
                                    <p><a href="tel:+61234567891">+61 2 3456 7891</a><br><small>24/7 Available</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Form -->
                    <div class="contact-form-card">
                        <h3 class="contact-card-title">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            Send us a Message
                        </h3>
                        
                        <form class="contact-form" method="post" action="">
                            <div class="form-group">
                                <label for="name">Your Name *</label>
                                <input type="text" id="name" name="name" required placeholder="Enter your full name">
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" placeholder="+61 2 3456 7890">
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">Subject *</label>
                                <select id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="appointment">Appointment Booking</option>
                                    <option value="emergency">Emergency Care</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="grooming">Grooming Services</option>
                                    <option value="vaccination">Vaccination</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" required placeholder="Please describe your inquiry or concern..." rows="5"></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn--primary btn--large">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Hours of Operation -->
                <div class="hours-section">
                    <h3 class="hours-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm4.2 14.2L11 13V7h1.5v5.2l4.5 2.7-.8 1.3z"/>
                        </svg>
                        Hours of Operation
                    </h3>
                    
                    <div class="hours-grid">
                        <div class="hours-item">
                            <div class="day">Monday - Friday</div>
                            <div class="time">8:00 AM - 6:00 PM</div>
                        </div>
                        <div class="hours-item">
                            <div class="day">Saturday</div>
                            <div class="time">9:00 AM - 4:00 PM</div>
                        </div>
                        <div class="hours-item">
                            <div class="day">Sunday</div>
                            <div class="time">10:00 AM - 2:00 PM</div>
                        </div>
                        <div class="hours-item emergency">
                            <div class="day">Emergency Services</div>
                            <div class="time">24/7 Available</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-container {
    max-width: 1200px;
    margin: 0 auto;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-top: 2rem;
}

.contact-info-card,
.contact-form-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.contact-card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #e02222;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 2rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f3f4f6;
}

.contact-details {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.contact-item.emergency {
    background: rgba(239, 68, 68, 0.05);
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #ef4444;
}

.contact-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background: rgba(224, 34, 34, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #e02222;
}

.contact-content h4 {
    color: #1f2937;
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
}

.contact-content p {
    color: #6b7280;
    margin: 0;
    line-height: 1.5;
}

.contact-content a {
    color: #e02222;
    text-decoration: none;
    font-weight: 500;
}

.contact-content a:hover {
    text-decoration: underline;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    color: #374151;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    background: white;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #e02222;
    box-shadow: 0 0 0 3px rgba(224, 34, 34, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.hours-section {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 2.5rem;
    margin-top: 3rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.hours-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #e02222;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 2rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f3f4f6;
}

.hours-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.hours-item {
    padding: 1.5rem;
    background: #f9fafb;
    border-radius: 8px;
    text-align: center;
    transition: all 0.3s ease;
}

.hours-item:hover {
    background: #f3f4f6;
    transform: translateY(-2px);
}

.hours-item.emergency {
    background: rgba(239, 68, 68, 0.05);
    border: 2px solid rgba(239, 68, 68, 0.2);
}

.hours-item .day {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.hours-item .time {
    color: #6b7280;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .contact-info-card,
    .contact-form-card,
    .hours-section {
        padding: 1.5rem;
    }
    
    .hours-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require __DIR__ . '/partials/footer.php'; ?>