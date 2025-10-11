# Pets Appointment Management System

## Project Overview

This is a comprehensive veterinary clinic appointment management system built with PHP, MySQL, HTML, CSS, and JavaScript. The system allows pet owners to register their pets, book appointments, and manage their veterinary care needs through an intuitive web interface.

## Features

### For Pet Owners
- **Pet Registration**: Register pets with owner information
- **Appointment Booking**: Schedule veterinary appointments
- **View Appointments**: Check appointment status and details
- **Receipt Generation**: Download appointment receipts (when approved)

### For Administrators
- **Admin Dashboard**: Manage appointments, pets, and owners
- **Appointment Approval**: Approve or cancel appointments
- **Receipt Generation**: Generate professional receipts for approved appointments
- **Data Management**: View and manage all system data

## Technical Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (ES6)
- **Libraries**: FPDF (for receipt generation)
- **Architecture**: MVC-like structure with partials

## Project Structure

```
Pets_Appointment_MS/
├── config.php                 # Database configuration and utility functions
├── index.php                  # Home page with clinic information
├── about.php                  # About us page
├── contact.php                # Contact information and form
├── faq.php                    # Frequently asked questions
├── register_pet.php           # Pet registration form
├── book_appointment.php       # Appointment booking system
├── view_appointments.php      # View and manage appointments
├── admin_login.php            # Administrator login
├── admin_dashboard.php        # Admin control panel
├── fetch_pets.php             # AJAX endpoint for pet lookup
├── generate_receipt.php       # Detailed receipt generator
├── generate_receipt_professional.php # Compact receipt generator
├── generate_receipt_compact.php # Ultra-compact receipt generator
├── pets_db.sql               # Database schema and sample data
├── partials/
│   ├── header.php            # Common header with navigation
│   └── footer.php            # Common footer with links
├── assets/
│   ├── css/main.css          # Main stylesheet
│   ├── js/main.js            # JavaScript functionality
│   └── bgVideo/              # Background media files
├── lib/
│   ├── fpdf.php              # PDF generation library
│   └── fpdf_complete.php     # Complete FPDF library
└── receipts/                 # Generated receipt files
```

## Database Schema

The system uses a MySQL database with three main tables:

### Owners Table
- `id` (Primary Key)
- `owner_name`
- `email`
- `phone`
- `address`

### Pets Table
- `id` (Primary Key)
- `pet_name`
- `type`
- `age`
- `owner_id` (Foreign Key to Owners)

### Appointments Table
- `id` (Primary Key)
- `pet_id` (Foreign Key to Pets)
- `date`
- `time`
- `service`
- `status` (Pending/Approved/Cancelled)

### Admin Table
- `id` (Primary Key)
- `username`
- `password` (hashed)

## Installation Instructions

### Prerequisites
- XAMPP/WAMP/LAMP server
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

### Setup Steps

1. **Clone/Download Project**
   ```bash
   git clone [repository-url]
   # OR download and extract ZIP file
   ```

2. **Setup Database**
   - Start XAMPP/WAMP server
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `pets_db`
   - Import the `pets_db.sql` file to create tables and sample data

3. **Configure Database Connection**
   - Open `config.php`
   - Update database credentials if needed:
     ```php
     $db_host = 'localhost';
     $db_user = 'root';
     $db_pass = '';
     $db_name = 'pets_db';
     ```

4. **Deploy Project**
   - Copy project folder to your web server directory
   - For XAMPP: `C:\xampp\htdocs\Pets_Appointment_MS`
   - For WAMP: `C:\wamp64\www\Pets_Appointment_MS`

5. **Access Application**
   - Open browser and navigate to: `http://localhost/Pets_Appointment_MS`
   - Default admin credentials: `admin` / `admin123`

## Key Features Explained

### 1. Pet Registration System
- **File**: `register_pet.php`
- **Features**: 
  - Owner information collection
  - Pet details registration
  - Duplicate owner prevention
  - Database transactions for data integrity
  - Client-side validation

### 2. Appointment Booking
- **File**: `book_appointment.php`
- **Features**:
  - Dynamic pet loading via AJAX
  - Date/time selection
  - Service type selection
  - Real-time form validation

### 3. Admin Dashboard
- **File**: `admin_dashboard.php`
- **Features**:
  - Appointment management
  - Status updates (Pending/Approved/Cancelled)
  - Pet and owner management
  - Receipt generation
  - Data deletion capabilities

### 4. Receipt Generation
- **Files**: `generate_receipt*.php`
- **Features**:
  - Multiple receipt formats
  - Auto-print functionality
  - Professional styling
  - PDF-ready output

## Security Features

1. **Input Sanitization**: All user inputs are sanitized using the `sanitize()` function
2. **Prepared Statements**: All database queries use prepared statements to prevent SQL injection
3. **Session Management**: Admin authentication uses PHP sessions
4. **Password Hashing**: Admin passwords are hashed using PHP's `password_hash()`
5. **XSS Prevention**: Output is escaped using `htmlspecialchars()`

## Learning Objectives

This project demonstrates:

1. **PHP Programming**:
   - Object-oriented concepts
   - Database connectivity with MySQLi
   - Session management
   - File handling
   - Error handling

2. **Database Design**:
   - Relational database concepts
   - Primary and foreign keys
   - JOIN operations
   - Transactions

3. **Frontend Development**:
   - Responsive web design
   - CSS Grid and Flexbox
   - JavaScript AJAX
   - Form validation
   - User experience design

4. **Web Security**:
   - Input validation and sanitization
   - SQL injection prevention
   - XSS prevention
   - Authentication and authorization

## Common Issues and Solutions

### Issue: Database Connection Failed
**Solution**: Check XAMPP/WAMP is running and database credentials in `config.php`

### Issue: Receipt Not Generating
**Solution**: Ensure `receipts/` directory has write permissions

### Issue: AJAX Not Working
**Solution**: Check browser console for JavaScript errors and verify `fetch_pets.php` is accessible

### Issue: Admin Login Not Working
**Solution**: Verify admin credentials in database or reset password using PHP script

## Future Enhancements

1. **Email Notifications**: Send appointment confirmations via email
2. **Payment Integration**: Add payment processing for services
3. **Calendar Integration**: Sync with Google Calendar
4. **Mobile App**: Develop companion mobile application
5. **Advanced Reporting**: Add analytics and reporting features
6. **Multi-language Support**: Internationalization
7. **Backup System**: Automated database backups

## Contributing

This is a student project designed for educational purposes. Feel free to:
- Add new features
- Improve existing functionality
- Fix bugs
- Enhance documentation
- Optimize performance

## License

This project is created for educational purposes. Feel free to use and modify as needed.

## Contact

For questions or support regarding this project, please refer to the documentation or contact your instructor.

---

**Note**: This project is designed to teach web development concepts and may not be suitable for production use without additional security measures and testing.
