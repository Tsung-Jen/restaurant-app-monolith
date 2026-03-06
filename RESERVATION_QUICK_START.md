# Restaurant Reservation System - Quick Start Guide

## What Was Built
A complete online restaurant reservation system with:
- ✅ Customer reservation form with validation
- ✅ Admin calendar-based dashboard
- ✅ Capacity management (max 55 guests per session)
- ✅ Email confirmation notifications
- ✅ Lunch and Dinner sessions

## Quick Start (5 Steps)

### Step 1: Database is Ready
No action needed - the `reservations` table already exists in your MySQL database.

### Step 2: Start Development Server
```bash
cd c:\Users\USER\Desktop\restaurant-monolith
npm run dev
php artisan serve
```

### Step 3: Access Reservation Form
Visit in your browser:
```
http://localhost:8000/reservations/create
```

Fill out the form:
- **Surname** (required) - Your name
- **Phone Number** (required) - Format: +1 (555) 123-4567
- **Email** (optional) - For confirmation
- **Date** (required) - Today or later
- **Session** (required) - Lunch (12-3 PM) or Dinner (6-11 PM)
- **Time** (required) - Pick a time
- **Guests** (required) - 1 to 55 people
- **Notes** (optional) - Special requests

Click "Complete Reservation" → See success modal → Click "Return to Home"

### Step 4: Test Fully Booked
Try making 2 reservations for 55 guests each on the same date/session:
- 1st one succeeds
- 2nd one shows: "Reservations are fully booked."

### Step 5: Admin Dashboard
Login to your account, then visit:
```
http://localhost:8000/reservations/admin/dashboard
```

You'll see:
- 📅 Calendar view of all reservations
- 👥 Capacity counter: "Lunch: 30/55, Dinner: 42/55"
- 🔴 Red highlighting when fully booked
- Click reservation → Confirm or Delete
- Navigate months with Previous/Next buttons

## File Reference

| File | Purpose |
|------|---------|
| `app/Models/Reservation.php` | Database model & capacity logic |
| `app/Http/Controllers/ReservationController.php` | Request handling |
| `app/Http/Requests/StoreReservationRequest.php` | Form validation rules |
| `app/Mail/ReservationConfirmation.php` | Email notification class |
| `resources/js/Pages/Reservations/Create.vue` | Reservation form UI |
| `resources/js/Pages/Reservations/AdminDashboard.vue` | Admin calendar UI |
| `database/migrations/2026_02_26_000003_create_reservations_table.php` | Database schema |

## Validation Examples

❌ **Invalid:**
- Surname: "" (empty)
- Phone: "123" (too short)
- Email: "not-an-email" (invalid)
- Date: "2026-02-25" (in the past)
- Guests: "0" or "56" (out of range)

✅ **Valid:**
- Surname: "John Smith"
- Phone: "+1 (555) 123-4567"
- Email: "john@example.com"
- Date: "2026-03-15"
- Guests: "4"

## Email Notifications

Emails are currently set to **log mode** (development).

To see where confirmation emails are saved, check:
```
storage/logs/laravel.log
```

To enable real emails, edit `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

## Common Issues

### Reservations table doesn't exist?
```bash
php artisan migrate
```

### Form not submitting?
- Check browser console for errors
- Ensure all required fields are filled
- Check network tab to see API response

### Admin dashboard not showing reservations?
- Make sure you're logged in
- Check that reservations exist in database
- Try refreshing the page

### Emails not being sent?
- Check `.env` MAIL_MAILER setting
- If using log driver, check `storage/logs/laravel.log`
- For SMTP, verify your credentials

## Testing Checklist

- [ ] Create a reservation → See success modal
- [ ] Submit form with missing surname → See red error
- [ ] Try 56 guests → See validation error
- [ ] Book 55 guests for lunch → Next lunch reservation fails
- [ ] Login and see admin dashboard
- [ ] Click reservation in calendar → See details modal
- [ ] Confirm a reservation → Status changes
- [ ] Delete a reservation → Removed from calendar

## Next Steps

When you're ready to:
- **Send Real Emails**: Update MAIL_MAILER in .env
- **Customize Capacity**: Edit `Reservation::isSessionFullyBooked()` in model
- **Add More Sessions**: Add to enum in migration and update form
- **Restrict Dates**: Add logic to close on certain dates
- **Send SMS**: Install a package and add to controller

## Questions?

Refer to `RESERVATION_SYSTEM.md` for detailed documentation.
