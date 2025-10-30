/**
 * Roboto Font to Base64 Converter
 * 
 * Instructions:
 * 1. Download Roboto fonts from Google Fonts
 * 2. Place Roboto-Regular.ttf, Roboto-Medium.ttf, Roboto-Bold.ttf in this directory
 * 3. Run: node convert-roboto-fonts.js
 * 4. Copy the base64 strings from the generated .txt files into roboto-fonts.js
 */

const fs = require('fs');

console.log('🔄 Converting Roboto fonts to Base64...\n');

// Convert Roboto-Regular (400 weight)
try {
    const regularFont = fs.readFileSync('Roboto-Regular.ttf');
    const regularBase64 = regularFont.toString('base64');
    fs.writeFileSync('roboto-regular-base64.txt', regularBase64);
    console.log('✅ Roboto-Regular.ttf → roboto-regular-base64.txt');
} catch (error) {
    console.log('❌ Roboto-Regular.ttf not found');
}

// Convert Roboto-Medium (500 weight)
try {
    const mediumFont = fs.readFileSync('Roboto-Medium.ttf');
    const mediumBase64 = mediumFont.toString('base64');
    fs.writeFileSync('roboto-medium-base64.txt', mediumBase64);
    console.log('✅ Roboto-Medium.ttf → roboto-medium-base64.txt');
} catch (error) {
    console.log('❌ Roboto-Medium.ttf not found');
}

// Convert Roboto-Bold (700 weight)
try {
    const boldFont = fs.readFileSync('Roboto-Bold.ttf');
    const boldBase64 = boldFont.toString('base64');
    fs.writeFileSync('roboto-bold-base64.txt', boldBase64);
    console.log('✅ Roboto-Bold.ttf → roboto-bold-base64.txt');
} catch (error) {
    console.log('❌ Roboto-Bold.ttf not found');
}

console.log('\n📋 Next Steps:');
console.log('1. Open the generated .txt files');
console.log('2. Copy the base64 strings');
console.log('3. Paste into public/new-assets/js/roboto-fonts.js');
console.log('4. Reload your page and test PDF export');






