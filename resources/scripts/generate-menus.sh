#!/bin/bash

# Menu PDF Generator Helper Script
# This script helps generate sample menu PDFs using various online tools

echo "=========================================="
echo "Menu PDF Generator Helper"
echo "=========================================="
echo ""
echo "This script provides instructions for creating menu PDFs."
echo ""
echo "Option 1: Use an Online PDF Generator"
echo "  1. Visit: https://html2pdf.com/"
echo "  2. Paste the HTML content from the templates below"
echo "  3. Generate PDF"
echo "  4. Download and save to public/menus/"
echo ""
echo "Option 2: Use Canva (Recommended)"
echo "  1. Visit: https://www.canva.com/create/menus/"
echo "  2. Choose a menu template"
echo "  3. Customize with your menu items"
echo "  4. Export as PDF"
echo "  5. Download and save to public/menus/"
echo ""
echo "Option 3: Use LibreOffice/Word"
echo "  1. Create a document with your menu"
echo "  2. File → Export as PDF"
echo "  3. Save to public/menus/"
echo ""
echo "=========================================="
echo "Sample HTML Templates Below:"
echo "=========================================="
echo ""
echo "You can copy the HTML below and use with html2pdf.com"
echo ""

cat << 'EOF'

<!-- Appetizers Menu Template -->
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: white;
        }
        h1 {
            color: #dc2626;
            text-align: center;
            font-size: 36px;
            margin-bottom: 30px;
        }
        .item {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .item-name {
            font-weight: bold;
            font-size: 16px;
            color: #333;
        }
        .item-description {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .item-price {
            font-weight: bold;
            color: #dc2626;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Appetizers</h1>
    
    <div class="item">
        <div class="item-name">Spring Rolls</div>
        <div class="item-description">Crispy rolls filled with vegetables and shrimp</div>
        <div class="item-price">€4.90</div>
    </div>

    <div class="item">
        <div class="item-name">Dumplings</div>
        <div class="item-description">Steamed pork and vegetable dumplings</div>
        <div class="item-price">€5.90</div>
    </div>

    <div class="item">
        <div class="item-name">Chicken Wings</div>
        <div class="item-description">Crispy wings with spicy sauce</div>
        <div class="item-price">€6.90</div>
    </div>

    <div class="item">
        <div class="item-name">Fried Wonton</div>
        <div class="item-description">Golden fried wontons with sweet and sour sauce</div>
        <div class="item-price">€4.50</div>
    </div>
</body>
</html>

EOF

echo ""
echo "=========================================="
echo "Instructions:"
echo "=========================================="
echo ""
echo "1. Copy the HTML template above"
echo "2. Visit: https://html2pdf.com/"
echo "3. Paste the HTML in the input area"
echo "4. Click 'Convert to PDF'"
echo "5. Download and save as 'appetizers.pdf' to 'public/menus/'"
echo ""
echo "Repeat for other menu categories:"
echo "  - main-courses.pdf"
echo "  - noodles-rice.pdf"
echo "  - desserts.pdf"
echo "  - beverages.pdf"
echo ""
echo "=========================================="
