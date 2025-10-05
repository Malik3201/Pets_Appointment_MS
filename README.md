# Pet Care Management System

Simple PHP + MySQL web app with basic HTML/CSS. Works on XAMPP/WAMP.

## Setup
1. Copy project folder to your web root (e.g., `htdocs/Pets_Appointment_MS`).
2. Create database:
   - Open phpMyAdmin
   - Import `pet_care_db.sql` (creates DB/tables and a sample admin user)
3. Update DB credentials in `config.php` if needed.
4. Visit `http://localhost/Pets_Appointment_MS/`.

## Admin
- Login: `http://localhost/Pets_Appointment_MS/admin_login.php`
- Default credentials: username `admin`, password `admin123`

## Pages
- `index.php`, `about.php`, `services.php`, `register_pet.php`, `book_appointment.php`, `view_appointments.php`, `admin_login.php`, `admin_dashboard.php`, `contact.php`

## Notes
- Uses prepared statements and password hashing.
- Basic validation on forms; strengthen as needed.

## New Features
- Booking shows only the owner's pets: enter email/phone to filter pets in `book_appointment.php`.
- Admin Reports tab: weekly (7 days) and monthly (30 days) summaries in `admin_dashboard.php`.
- PDF receipts on approval: when status is set to Approved, a PDF is generated to `receipts/appointment_{id}.pdf` using a lightweight bundled `lib/fpdf.php`.
- User receipts: `view_appointments.php` shows a Download Receipt link for approved appointments.

## Sample PDF
- After approving an appointment in the admin dashboard, a file like `receipts/appointment_1.pdf` will be created. Open it directly or from the user page link.
