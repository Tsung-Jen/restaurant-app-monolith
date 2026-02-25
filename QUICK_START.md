# Quick Start Guide - PDF Menu

## What Was Created

Your restaurant now has a simple **PDF menu viewer** with:
- ✅ PDF Viewer component (renders PDF with page navigation)
- ✅ Clean menu page with back button
- ✅ Integration with your existing Landing page
- ✅ Responsive design for all devices

## Files Created

```
resources/
├── js/
│   ├── Components/
│   │   └── PDFViewer.vue          [NEW] PDF viewer component
│   └── Pages/
│       ├── Menu.vue                [NEW] Menu page
│       └── Landing.vue             [UPDATED] Added menu link

routes/
└── web.php                          [UPDATED] Added menu route

public/
└── menus/                           [NEW] Directory for PDF file
    └── README.md                    [NEW] Instructions

QUICK_START.md & Documentation files   [NEW]
```

## Setup (2 Steps)

### Step 1: Add Your PDF Menu

1. **Create a PDF menu** using one of these tools:
   - **Canva** (recommended): https://www.canva.com/create/menus/
   - Microsoft Word → Export as PDF
   - Google Docs → Download as PDF
   - Adobe InDesign
   - LibreOffice Writer

2. **Save as `menu.pdf`** in the `public/menus/` folder

That's it! Just one PDF file named `menu.pdf`.

### Step 2: Test It

1. **Start the dev server:**
   ```bash
   npm run dev
   ```

2. **In another terminal, start Laravel:**
   ```bash
   php artisan serve
   ```

3. **Visit the site:**
   - Go to http://localhost:8000
   - Click "View Full Menu"
   - You should see your PDF menu with navigation controls

## How It Works

### User Flow
```
Landing Page
    ↓
Click "View Full Menu" button
    ↓
Menu Page with PDF Viewer
    ↓
Use Previous/Next buttons to navigate pages
    ↓
Back button to return to home
```

### Technical Details
- **Frontend**: Vue 3 + Inertia.js
- **PDF Rendering**: PDF.js library
- **Styling**: Tailwind CSS
- **Route**: GET `/menu` → Menu.vue

## Customization

### Change Colors
Edit `resources/js/Pages/Menu.vue`:
- `bg-red-600` → Your primary color
- `bg-yellow-50` → Your background color

### Change Menu Button Text
In `resources/js/Pages/Landing.vue`, change:
```vue
View Full Menu with PDF
```

### Add Styling to PDF Viewer
Edit `resources/js/Components/PDFViewer.vue` and adjust the canvas styling.

## Testing Checklist

- [ ] Landing page loads
- [ ] "View Full Menu" button visible
- [ ] Button navigates to menu page
- [ ] PDF displays correctly
- [ ] Previous/Next buttons work
- [ ] Back button returns to landing page
- [ ] Works on mobile devices

## Essential Commands

```bash
# Development server
npm run dev

# Production build
npm run build

# Laravel development server
php artisan serve
```

## Troubleshooting

### PDF not showing?
- ✅ Check `menu.pdf` exists in `public/menus/`
- ✅ Check the file is a valid PDF
- ✅ Open browser DevTools (F12) → Console for errors

### Navigation not working?
- ✅ Run `npm run dev` to rebuild
- ✅ Clear browser cache (Ctrl+Shift+Delete)
- ✅ Make sure Laravel server is running

### Styles not showing?
- ✅ Run `npm run dev` to rebuild CSS
- ✅ Clear browser cache

## Next Steps

1. ✅ Create `menu.pdf`
2. ✅ Place in `public/menus/`
3. ✅ Run `npm run dev` and `php artisan serve`
4. ✅ Test at http://localhost:8000
5. ✅ Done!

---

**Status**: Ready to use
**Created**: February 23, 2026
**Framework**: Laravel + Vue 3

