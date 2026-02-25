@echo off
REM Menu PDF Generator Helper Script for Windows
REM This script provides instructions for creating menu PDFs

cls
echo.
echo ==========================================
echo Menu PDF Generator Helper
echo ==========================================
echo.
echo This script provides instructions for creating menu PDFs.
echo.
echo Option 1: Use an Online PDF Generator
echo   1. Visit: https://html2pdf.com/
echo   2. Paste the HTML content provided in MENU_SYSTEM.md
echo   3. Generate PDF
echo   4. Download and save to public\menus\
echo.
echo Option 2: Use Canva (Recommended for Best Results)
echo   1. Visit: https://www.canva.com/create/menus/
echo   2. Choose a menu template
echo   3. Customize with your menu items
echo   4. Export as PDF
echo   5. Download and save to public\menus\
echo.
echo Option 3: Use Word or LibreOffice
echo   1. Create a document with your menu
echo   2. File menu ^> Export as PDF
echo   3. Save to public\menus\
echo.
echo ==========================================
echo Menu Files Needed:
echo ==========================================
echo.
echo Required PDF files in public\menus\ directory:
echo   - appetizers.pdf
echo   - main-courses.pdf
echo   - noodles-rice.pdf
echo   - desserts.pdf
echo   - beverages.pdf
echo.
echo ==========================================
echo Next Steps:
echo ==========================================
echo.
echo 1. Visit one of the options above
echo 2. Create your menu PDFs
echo 3. Place them in: public\menus\
echo 4. Run: npm run dev
echo 5. Run: php artisan serve
echo 6. Visit: http://localhost:8000
echo.
echo Press any key to continue...
pause >nul
