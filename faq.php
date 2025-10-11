<?php
// FAQ page for Canberra Pets Care Hospital
$page_title = 'Frequently Asked Questions - Canberra Pets Care Hospital';
require __DIR__ . '/partials/header.php';
?>

<!-- FAQ Section -->
<section class="section" data-bg="assets/bgVideo/main_bg.jpg">
    <div class="container">
        <div class="section-content">
            <div class="section-header">
                <h1 class="section-title">Frequently Asked Questions</h1>
                <p class="section-subtitle">Find answers to common questions about our veterinary services and pet care.</p>
            </div>
            
            <div class="faq-container">
                <div class="faq-grid">
                    <!-- General Questions -->
                    <div class="faq-category">
                        <h3 class="faq-category-title">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            General Questions
                        </h3>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>What services do you provide?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>We provide comprehensive veterinary services including wellness exams, vaccinations, grooming, laboratory tests, dentistry, surgery, emergency care, and preventive medicine for dogs, cats, and other small animals.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>What are your operating hours?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>We are open Monday to Friday 8:00 AM - 6:00 PM, Saturday 9:00 AM - 4:00 PM, and Sunday 10:00 AM - 2:00 PM. Emergency services are available 24/7.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>Do I need to make an appointment?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>Yes, we recommend making appointments to ensure we can provide the best care for your pet. You can book online through our website or call us directly. Walk-ins are accommodated based on availability.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Appointment Questions -->
                    <div class="faq-category">
                        <h3 class="faq-category-title">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                            </svg>
                            Appointments & Scheduling
                        </h3>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>How do I book an appointment online?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>Simply visit our Book Appointment page, enter your email or phone number to load your registered pets, select your pet, choose a date and time, and submit your request. We'll confirm your appointment.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>Can I cancel or reschedule my appointment?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>Yes, you can cancel or reschedule your appointment by calling us at least 24 hours in advance. You can also view and manage your appointments through our View Appointments page.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>What should I bring to my appointment?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>Please bring your pet's vaccination records, any previous medical records, current medications, and a list of any concerns or questions you have about your pet's health.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pet Registration Questions -->
                    <div class="faq-category">
                        <h3 class="faq-category-title">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.11 3.89 23 5 23H19C20.11 23 21 22.11 21 21V9M19 9H14V4H19V9Z"/>
                            </svg>
                            Pet Registration
                        </h3>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>Do I need to register my pet before booking an appointment?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>Yes, you need to register your pet first to book appointments. This helps us maintain accurate medical records and provide the best care for your pet. Registration is quick and free.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>What information do I need to register my pet?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>You'll need your contact information (name, email, phone, address), your pet's name, type/breed, age, and any existing medical conditions or medications.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Emergency Questions -->
                    <div class="faq-category">
                        <h3 class="faq-category-title">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                            </svg>
                            Emergency Care
                        </h3>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>What should I do in case of a pet emergency?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>For emergencies, call our emergency line immediately at +61 2 3456 7891. Our emergency services are available 24/7. If your pet is in immediate danger, bring them to our clinic right away.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>What constitutes a pet emergency?</h4>
                                <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5z"/>
                                </svg>
                            </div>
                            <div class="faq-answer">
                                <p>Emergencies include difficulty breathing, severe bleeding, unconsciousness, poisoning, seizures, severe trauma, inability to urinate, or any sudden severe changes in behavior or condition.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.faq-container {
    max-width: 1200px;
    margin: 0 auto;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.faq-category {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.faq-category-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #e02222;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f3f4f6;
}

.faq-item {
    margin-bottom: 1.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item:hover {
    border-color: #e02222;
    box-shadow: 0 4px 12px rgba(224, 34, 34, 0.1);
}

.faq-question {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    background: #f9fafb;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.faq-question:hover {
    background: #f3f4f6;
}

.faq-question h4 {
    color: #1f2937;
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
}

.faq-icon {
    color: #6b7280;
    transition: transform 0.3s ease;
}

.faq-item.active .faq-icon {
    transform: rotate(180deg);
    color: #e02222;
}

.faq-answer {
    padding: 0 1.25rem;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item.active .faq-answer {
    padding: 1.25rem;
    max-height: 200px;
}

.faq-answer p {
    color: #6b7280;
    line-height: 1.6;
    margin: 0;
}

@media (max-width: 768px) {
    .faq-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .faq-category {
        padding: 1.5rem;
    }
    
    .faq-question {
        padding: 1rem;
    }
    
    .faq-item.active .faq-answer {
        padding: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
            // Close other open items
            faqItems.forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                }
            });
            
            // Toggle current item
            item.classList.toggle('active');
        });
    });
});
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>
