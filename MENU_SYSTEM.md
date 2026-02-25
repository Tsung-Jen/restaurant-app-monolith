# PDF Menu System Documentation

## Overview

This restaurant menu system provides:
- **Simple PDF Viewer** - Displays your restaurant menu PDF
- **Page Navigation** - Previous/Next controls for multi-page PDFs
- **Integration** - Links from your landing page
- **Responsive Design** - Works on all devices

## Architecture

### Files Created

1. **Components**
   - `resources/js/Components/PDFViewer.vue` - PDF viewer component using PDF.js

2. **Pages**
   - `resources/js/Pages/Menu.vue` - Menu page with PDF viewer
   - `resources/js/Pages/Landing.vue` - Updated with menu link

3. **Routes** (in `routes/web.php`)
   - `GET /menu` → Menu.vue

4. **Public Assets**
   - `public/menus/menu.pdf` - Your restaurant menu (place here)

## How It Works

### PDF Viewer Component
The `PDFViewer.vue` component:
- Uses `pdfjs-dist` library to render PDFs
- Accepts two props: `pdfUrl` and `title`
- Provides previous/next page navigation
- Shows current page number and total pages
- Handles loading state
- Responsive canvas rendering

### Menu Page
The `Menu.vue` page:
- Displays the PDF viewer
- Provides a back to home link
- Styled with your restaurant colors (red/yellow)
- Clean, simple interface

### Routing Flow
```
Landing.vue → (Click "View Full Menu") → Menu.vue → PDF Viewer
```

## Setup Instructions

### Step 1: Create Your Menu PDF

**Option 1: Canva (Recommended)**
1. Visit https://www.canva.com/create/menus/
2. Choose a menu template
3. Customize with your items and prices
4. Export as PDF
5. Download

**Option 2: Microsoft Word**
1. Create a document with your menu
2. File → Export as PDF
3. Save

**Option 3: Google Docs**
1. Create a document
2. File → Download → PDF Document
3. Save

**Option 4: LibreOffice**
1. Create a document
2. File → Export as PDF
3. Save

### Step 2: Place PDF in Public Directory

1. Save your PDF as `menu.pdf`
2. Place it in: `public/menus/menu.pdf`

That's it! The menu will automatically appear at `/menu`

## Customization

### Change Colors

Edit `resources/js/Pages/Menu.vue`:
- `bg-red-600` → Your primary color
- `bg-yellow-50` → Your background color
- `text-white` → Your text color

### Change Text

**Menu Title:**
```vue
<h1 class="text-4xl font-bold mb-2">Our Menu</h1>
```

**Button Text in Landing.vue:**
```vue
View Full Menu with PDF
```

**PDF Viewer Title:**
```vue
<PDFViewer
    pdf-url="/menus/menu.pdf"
    title="Restaurant Menu"
/>
```

### Style the PDF Viewer

Edit `resources/js/Components/PDFViewer.vue`:
- Adjust canvas styling
- Change button colors
- Modify fonts and spacing

## Dependencies

- **pdfjs-dist** - PDF rendering (already installed)
- **@inertiajs/vue3** - Routing (already installed)
- **Vue 3** - Framework (already installed)
- **Tailwind CSS** - Styling (already installed)

## File Structure

```
restaurant-monolith/
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   │   └── PDFViewer.vue      
│   │   └── Pages/
│   │       ├── Menu.vue            
│   │       └── Landing.vue         
├── public/
│   └── menus/
│       ├── menu.pdf              (← Place your PDF here)
│       └── README.md             
├── routes/
│   └── web.php                   
└── ...
```

## Development Commands

```bash
# Start development server
npm run dev

# Build for production
npm run build

# Start Laravel server
php artisan serve

# Visit in browser
http://localhost:8000
```

## Troubleshooting

### PDF not displaying
**Problem**: "Loading PDF..." persists or blank canvas
**Solution**:
- Check that `menu.pdf` exists in `public/menus/`
- Verify the file is a valid PDF
- Open DevTools (F12) → Console for error messages
- Check the file path in PDFViewer component matches

### Navigation buttons not responding
**Problem**: Previous/Next buttons don't work
**Solution**:
- Clear browser cache (Ctrl+Shift+Delete)
- Run `npm run dev` to rebuild assets
- Check browser console for JavaScript errors

### Styling looks wrong
**Problem**: Colors or fonts don't match design
**Solution**:
- Run `npm run dev` to rebuild Tailwind CSS
- Clear browser cache
- Check Tailwind config in `tailwind.config.js`

### Page not found
**Problem**: Get 404 error when visiting /menu
**Solution**:
- Make sure Laravel server is running (`php artisan serve`)
- Check route is registered in `routes/web.php`
- Restart the servers

## Performance Tips

1. **Optimize PDF size**: Keep under 5MB
   - Compress images before creating PDF
   - Use online PDF compressor tools
   
2. **Use efficient PDF creation**: Canva compresses automatically

3. **Cache**: PDFs are automatically cached by browser

## Future Enhancements

Possible additions:
- Download PDF button
- Print-friendly version
- Multiple menu PDFs (breakfast, lunch, dinner)
- Allergen information
- QR code for mobile viewing
- Search functionality
- Favorites/bookmarks

## Support Resources

- **PDF.js Documentation**: https://mozilla.github.io/pdf.js/
- **Vue 3 Documentation**: https://vuejs.org/
- **Inertia.js Documentation**: https://inertiajs.com/
- **Canva**: https://www.canva.com/create/menus/
- **Tailwind CSS**: https://tailwindcss.com/

---

**System Created**: February 23, 2026  
**Status**: Ready to use  
**Framework**: Laravel + Vue 3 + Inertia.js
