# Restaurant Reservation System - Implementation Guide

## Overview
A complete online reservation system with customer-facing reservation form and admin calendar-based dashboard for managing reservations.

## Features Implemented

### 1. Database Schema
**Reservations Table** (`reservations`)
- `id` - Primary key
- `surname` - String (required)
- `phone_number` - String (required, validated)
- `email` - String (optional)
- `reservation_date` - Date (required, must be today or later)
- `session` - Enum: 'lunch' or 'dinner' (required)
- `reservation_time` - Time (required)
- `number_of_guests` - Integer (required, 1-55)
- `notes` - Text (optional, max 500 chars)
- `status` - Enum: 'pending', 'confirmed', 'cancelled' (default: pending)
- `created_at`, `updated_at` - Timestamps
- Indexes on: `reservation_date`, `session`, `status`

### 2. Backend Components

#### Models
- **Reservation Model** (`app/Models/Reservation.php`)
  - `getByDateAndSession()` - Get all reservations for a specific date and session
  - `getTotalGuestsForSession()` - Calculate total guests for a session
  - `isSessionFullyBooked()` - Check if session is at capacity (55 guests)
  - `getRemainingCapacity()` - Get remaining spots for a session

#### Controllers
- **ReservationController** (`app/Http/Controllers/ReservationController.php`)
  - `create()` - Display reservation form
  - `store()` - Store new reservation with validation and capacity check
  - `dashboard()` - Show admin calendar dashboard
  - `show()` - View specific reservation
  - `update()` - Update reservation status (admin only)
  - `destroy()` - Delete reservation (admin only)
  - `getByDateSession()` - AJAX endpoint for checking availability

#### Form Requests
- **StoreReservationRequest** (`app/Http/Requests/StoreReservationRequest.php`)
  - Frontend and backend validation
  - Custom error messages displayed under form fields
  - Rules:
    - Surname: Required, 2-100 characters
    - Phone: Required, 10-20 characters, valid format
    - Email: Optional, valid email format
    - Date: Required, today or later
    - Session: Required, lunch or dinner
    - Time: Required, valid time format
    - Guests: Required, 1-55
    - Notes: Optional, max 500 characters

#### Email & Notifications
- **ReservationConfirmation Mailable** (`app/Mail/ReservationConfirmation.php`)
- **Email Template** (`resources/views/emails/reservation-confirmation.blade.php`)
  - Professional HTML email with reservation details
  - Confirmation message included
  - Sent only if email provided by customer

#### Routes
```php
// Customer Routes (Public)
GET  /reservations/create              - Show reservation form
POST /reservations                     - Store reservation
GET  /reservations/check-availability  - AJAX: Check session availability

// Admin Routes (Protected - requires auth)
GET  /reservations/admin/dashboard     - View calendar dashboard
GET  /reservations/{id}                - View reservation details
PATCH /reservations/{id}               - Update reservation status
DELETE /reservations/{id}              - Delete reservation
```

### 3. Frontend Components

#### Customer Reservation Form (`resources/js/Pages/Reservations/Create.vue`)
- **Fields:**
  - Surname (required) - Text input with validation
  - Phone Number (required) - Tel input with format validation
  - Email (optional) - Email input
  - Reservation Date (required) - Date picker (today or later)
  - Session (required) - Dropdown (Lunch/Dinner)
  - Reservation Time (required) - Time picker
  - Number of Guests (required) - Number input (1-55)
  - Notes (optional) - Textarea (max 500 chars)

- **Features:**
  - Real-time field validation
  - Error messages displayed in red under each field
  - "Reservations are fully booked" error when capacity reached
  - Success modal with confirmation message
  - "Return to Home" button after successful reservation
  - Loading state during submission
  - CSRF token protection
  - Responsive design (mobile-friendly)

#### Admin Dashboard (`resources/js/Pages/Reservations/AdminDashboard.vue`)
- **Calendar View:**
  - Monthly calendar grid showing all reservations
  - Navigate between months (Previous/Next buttons)
  - Color-coded reservation cards
  - Shows reservation count per date

- **Features:**
  - Capacity display for each session (Lunch: X/55, Dinner: X/55)
  - Red highlighting when session is fully booked (55+ guests)
  - Click on reservation to view details
  - Update reservation status (Pending → Confirmed)
  - Delete reservations
  - Summary cards showing:
    - Total Reservations count
    - Pending reservations count
    - Confirmed reservations count

- **Reservation Details Modal:**
  - Full reservation information
  - Status management
  - Delete action with confirmation
  - Close button

### 4. Business Logic

#### Session Management
- Two sessions: Lunch and Dinner
- Max 55 guests per session per day
- Reservations are counted regardless of status (except cancelled)

#### Capacity Checking
- Backend validation: If `(current_total + new_reservation) > 55`, return error
- Error message: "Reservations are fully booked."
- HTTP Status: 409 Conflict

#### Reservation Flow
1. Customer fills form
2. Frontend validates all fields
3. Customer submits
4. Backend validates request
5. Backend checks capacity
6. If OK: Create reservation, send email (if email provided), return success
7. If not OK: Return error message
8. Success: Show modal → Return home

### 5. Validation

#### Frontend Validation (`Create.vue`)
- Real-time validation as user types
- Error messages appear/disappear
- Form submission blocked if errors exist

#### Backend Validation (`StoreReservationRequest.php`)
- Re-validates all fields (never trust client)
- Custom error messages
- Capacity check in controller

## Installation & Setup

### 1. Database Migration
```bash
php artisan migrate
```
Creates the `reservations` table with all required fields and indexes.

### 2. Email Configuration
Edit `.env` file:
```dotenv
MAIL_MAILER=log              # For development (logs emails)
# OR for production:
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io   # Your SMTP host
MAIL_PORT=2525               # Your SMTP port
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@restaurant.com
```

### 3. Run Development Server
```bash
npm run dev
php artisan serve
```

Visit: `http://localhost:8000/reservations/create` to make a reservation
Visit: `http://localhost:8000/reservations/admin/dashboard` (requires login) for admin panel

## API Response Examples

### Successful Reservation
```json
{
  "success": true,
  "message": "The reservation is successful",
  "reservation": {
    "id": 1,
    "surname": "Smith",
    "phone_number": "+1 (555) 123-4567",
    "email": "smith@example.com",
    "reservation_date": "2026-03-15",
    "session": "dinner",
    "reservation_time": "19:00:00",
    "number_of_guests": 4,
    "notes": "Window seat preferred",
    "status": "pending",
    "created_at": "2026-02-26T10:30:00",
    "updated_at": "2026-02-26T10:30:00"
  }
}
```

### Fully Booked Error
```json
{
  "success": false,
  "message": "Reservations are fully booked.",
  "status": 409
}
```

### Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "surname": ["Please enter your surname"],
    "phone_number": ["Please enter your phone number"]
  }
}
```

## File Structure
```
app/
  ├── Models/Reservation.php
  ├── Http/
  │   ├── Controllers/ReservationController.php
  │   └── Requests/StoreReservationRequest.php
  └── Mail/ReservationConfirmation.php

database/
  └── migrations/2026_02_26_000003_create_reservations_table.php

resources/
  ├── js/Pages/Reservations/
  │   ├── Create.vue
  │   └── AdminDashboard.vue
  └── views/emails/reservation-confirmation.blade.php

routes/web.php
```

## Testing Scenarios

### Test 1: Valid Reservation
1. Go to `/reservations/create`
2. Fill all required fields
3. Submit
4. See success modal
5. Check database for new reservation

### Test 2: Validation Errors
1. Try to submit without surname
2. See error "Please enter your surname" in red
3. Fill surname
4. Error disappears

### Test 3: Fully Booked
1. Make 55 guest reservation for lunch on a date
2. Try to make another reservation for same date/lunch
3. See error "Reservations are fully booked."

### Test 4: Admin Dashboard
1. Login to system
2. Go to `/reservations/admin/dashboard`
3. See calendar with all reservations
4. Click on a reservation
5. Can confirm or delete it
6. Navigate between months

### Test 5: Email Notification
1. Check `.env` MAIL_MAILER setting
2. If using `log` driver: Check `storage/logs/laravel.log` for email content
3. If using SMTP: Email will be sent to provided address

## Future Enhancements
- SMS notifications
- Automatic email reminders 24 hours before reservation
- Customer login to manage own reservations
- Restaurant settings for capacity per session
- Holiday/closure dates
- Special event pricing
- Waitlist when fully booked
- Multiple location support
- Advanced analytics and reporting

## Notes
- Email notifications are sent only if email is provided
- Current email driver is set to 'log' for development
- All validations happen both frontend and backend
- Dates cannot be in the past
- Times must be within session hours (configure as needed)
- Cancelled reservations don't count toward capacity
- Database has indexes for optimal query performance
