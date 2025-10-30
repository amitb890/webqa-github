# Roboto Font Setup Instructions for PDF Export

## 📋 Overview
Your PDF export is now configured to use **Roboto font** for Twitter Tags and Open Graph Tags sections. The system will automatically fallback to **Helvetica** if Roboto fonts are not loaded.

## ✅ Current Status
- ✅ Code is ready to use Roboto fonts
- ✅ Automatic fallback to Helvetica if fonts not found
- ✅ Bold labels in Twitter and Open Graph sections
- ⚠️ **Action Required**: Add Roboto font base64 files

---

## 🚀 Step-by-Step Setup

### **Step 1: Download Roboto Fonts**
1. Go to [Google Fonts - Roboto](https://fonts.google.com/specimen/Roboto)
2. Click "Download family"
3. Extract the ZIP file
4. Locate these three files:
   - `Roboto-Regular.ttf` (400 weight)
   - `Roboto-Medium.ttf` (500 weight)
   - `Roboto-Bold.ttf` (700 weight)

### **Step 2: Convert Fonts to Base64**

#### **Option A: Using Online Tool (Easiest)**
1. Visit: https://www.giftofspeed.com/base64-encoder/
2. Upload `Roboto-Regular.ttf`
3. Copy the generated base64 string
4. Repeat for `Roboto-Medium.ttf`
5. Repeat for `Roboto-Bold.ttf`

#### **Option B: Using Node.js Script**
Create a file `convert-fonts.js`:

```javascript
const fs = require('fs');

// Convert Roboto-Regular (400 weight)
const regularFont = fs.readFileSync('Roboto-Regular.ttf');
const regularBase64 = regularFont.toString('base64');
fs.writeFileSync('roboto-regular-base64.txt', regularBase64);
console.log('✅ Roboto-Regular converted to base64');

// Convert Roboto-Medium (500 weight)
const mediumFont = fs.readFileSync('Roboto-Medium.ttf');
const mediumBase64 = mediumFont.toString('base64');
fs.writeFileSync('roboto-medium-base64.txt', mediumBase64);
console.log('✅ Roboto-Medium converted to base64');

// Convert Roboto-Bold (700 weight)
const boldFont = fs.readFileSync('Roboto-Bold.ttf');
const boldBase64 = boldFont.toString('base64');
fs.writeFileSync('roboto-bold-base64.txt', boldBase64);
console.log('✅ Roboto-Bold converted to base64');
```

Run it:
```bash
node convert-fonts.js
```

### **Step 3: Add Base64 Strings to Your Project**

Open `public/new-assets/js/roboto-fonts.js` and replace the empty strings:

```javascript
window.ROBOTO_FONTS = {
    regular: "AAEAAAASAQAABAAgR0RFRg...", // Paste your Roboto-Regular base64 here (400 weight)
    medium: "AAEAAAASAQAABAAgR0RFRg...",  // Paste your Roboto-Medium base64 here (500 weight)
    bold: "AAEAAAASAQAABAAgR0RFRg..."     // Paste your Roboto-Bold base64 here (700 weight)
};
```

### **Step 4: Include the Font File in Your HTML**

Add this line **BEFORE** the `export-pdf.js` script in your HTML:

```html
<!-- Load Roboto fonts for PDF -->
<script src="public/new-assets/js/roboto-fonts.js"></script>

<!-- Load PDF export script -->
<script src="public/new-assets/js/export-pdf.js"></script>
```

---

## 🧪 Testing

### **1. Check if Fonts are Loaded**
Open browser console when exporting PDF. You should see:
```
✅ Roboto fonts loaded successfully (Regular, Medium, Bold)
```

If fonts are not loaded, you'll see:
```
⚠️ Roboto fonts not found in window.ROBOTO_FONTS, using Helvetica
   Required: regular, medium, and bold font files
```

### **2. Verify PDF Output**
- Export a PDF
- Check Twitter Tags and Open Graph Tags sections
- Labels should appear in **Roboto Medium (500 weight)**
- Values should appear in **Roboto Regular (400 weight)**

---

## 📁 File Structure

```
public/new-assets/js/
├── export-pdf.js              # Main PDF export logic (updated)
├── roboto-fonts.js            # Font base64 storage (needs your data)
└── ROBOTO_SETUP_INSTRUCTIONS.md  # This file
```

---

## 🔧 Technical Details

### How It Works:
1. When PDF export button is clicked, `export-pdf.js` checks for `window.ROBOTO_FONTS`
2. If found, it loads fonts using jsPDF's `addFileToVFS()` and `addFont()` methods
3. Sets `window.PDF_FONT_FAMILY = "Roboto"`
4. All Twitter and Open Graph sections use this font dynamically
5. If not found, falls back to `"helvetica"`

### Font Usage:
- **Twitter Tags**:
  - Title: Roboto Regular (400), 11px
  - Labels: Roboto Medium (500), 10px
  - Values: Roboto Regular (400), 10px
  - Badge: Roboto Regular (400)

- **Open Graph Tags**:
  - Title: Roboto Regular (400), 11px
  - Labels: Roboto Medium (500), 10px
  - Values: Roboto Regular (400), 10px
  - Badge: Roboto Regular (400)

---

## ❓ Troubleshooting

### Problem: Console shows "fonts not found"
**Solution**: Make sure `roboto-fonts.js` is loaded BEFORE `export-pdf.js`

### Problem: PDF still using Helvetica
**Solution**: 
1. Check browser console for errors
2. Verify base64 strings are not empty
3. Ensure base64 strings are valid (no line breaks or extra characters)

### Problem: PDF generation fails
**Solution**: 
1. Check if base64 strings are too long (might cause memory issues)
2. Try converting fonts again
3. Check browser console for specific error messages

---

## 📝 Alternative: Use Helvetica (No Setup Required)

If you prefer not to set up Roboto fonts, the system will automatically use **Helvetica** for both labels and values (all text will have the same weight). This provides a clean, professional appearance without any additional setup.

---

## 🎯 Quick Start (4 Steps)

1. **Download** Roboto fonts (Regular, Medium, Bold) from Google Fonts
2. **Convert** all three fonts to base64 using online tool
3. **Paste** base64 strings into `roboto-fonts.js`
4. **Include** `roboto-fonts.js` script in your HTML before `export-pdf.js`

That's it! Your PDFs will now use Roboto font family with Medium (500) weight for labels. 🎉

---

## 📞 Need Help?

If you encounter any issues, check:
- Browser console for error messages
- Network tab to ensure `roboto-fonts.js` is loading
- File paths are correct in your HTML

---

**Last Updated**: October 2025
**Version**: 1.0

