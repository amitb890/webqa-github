// Code for the december 28 order Starts


document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('imagePreviewOverlay');
    const previewImg = document.getElementById('imagePreviewContent');
    const closeBtn = document.querySelector('.image-preview-close');
  
    document.addEventListener('click', (e) => {
    const el = e.target.closest('.zoomable-img');
    if (!el) return;
  
    let imageSrc = '';
  
  
    if (el.tagName === 'IMG') {
      imageSrc = el.src;
    }
  
  
    else {
      const bg = window.getComputedStyle(el).backgroundImage;
  
      if (bg && bg !== 'none') {
        imageSrc = bg.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
      }
    }
  
    if (!imageSrc) return;
  
    previewImg.src = imageSrc;
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  });
  
  
    // Close preview
    function closePreview() {
      overlay.classList.remove('active');
      previewImg.src = '';
      document.body.style.overflow = '';
    }
  
  
    
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closePreview();
    });
  });
  
  
  
  
  // Code for the december 28 order Ends