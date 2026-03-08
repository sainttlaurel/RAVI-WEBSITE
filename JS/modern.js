// Modern JavaScript for Ravi Cabinet Website

// Smooth Scroll for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const href = this.getAttribute('href');
    if (href !== '#' && document.querySelector(href)) {
      e.preventDefault();
      document.querySelector(href).scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Gallery Lightbox
function initGalleryLightbox() {
  const images = document.querySelectorAll('.rows img, .box img');
  
  if (images.length === 0) return;
  
  // Create lightbox HTML
  if (!document.getElementById('lightbox')) {
    const lightboxHTML = `
      <div id="lightbox" style="display:none; position:fixed; z-index:9999; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.95); justify-content:center; align-items:center;">
        <span id="lightbox-close" style="position:absolute; top:30px; right:50px; font-size:50px; color:white; cursor:pointer; transition:all 0.3s;">&times;</span>
        <img id="lightbox-img" style="max-width:90%; max-height:90%; border-radius:8px; box-shadow:0 20px 60px rgba(0,0,0,0.5);">
        <button id="lightbox-prev" style="position:absolute; left:30px; top:50%; transform:translateY(-50%); background:rgba(166,124,82,0.8); color:white; border:none; font-size:30px; padding:20px 25px; cursor:pointer; border-radius:8px;">❮</button>
        <button id="lightbox-next" style="position:absolute; right:30px; top:50%; transform:translateY(-50%); background:rgba(166,124,82,0.8); color:white; border:none; font-size:30px; padding:20px 25px; cursor:pointer; border-radius:8px;">❯</button>
      </div>
    `;
    document.body.insertAdjacentHTML('beforeend', lightboxHTML);
  }
  
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const closeBtn = document.getElementById('lightbox-close');
  const prevBtn = document.getElementById('lightbox-prev');
  const nextBtn = document.getElementById('lightbox-next');
  
  let currentIndex = 0;
  const imageArray = Array.from(images);
  
  // Open lightbox
  images.forEach((img, index) => {
    img.addEventListener('click', () => {
      currentIndex = index;
      showImage(currentIndex);
      lightbox.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    });
  });
  
  // Show image
  function showImage(index) {
    if (index >= 0 && index < imageArray.length) {
      lightboxImg.src = imageArray[index].src;
      currentIndex = index;
    }
  }
  
  // Close lightbox
  function closeLightbox() {
    lightbox.style.display = 'none';
    document.body.style.overflow = 'auto';
  }
  
  closeBtn.addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) closeLightbox();
  });
  
  // Navigation
  prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + imageArray.length) % imageArray.length;
    showImage(currentIndex);
  });
  
  nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % imageArray.length;
    showImage(currentIndex);
  });
  
  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (lightbox.style.display === 'flex') {
      if (e.key === 'Escape') closeLightbox();
      if (e.key === 'ArrowLeft') prevBtn.click();
      if (e.key === 'ArrowRight') nextBtn.click();
    }
  });
}

// Parallax Effect for Background
function initParallax() {
  const slider = document.querySelector('.slider');
  if (!slider) return;
  
  window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    slider.style.transform = `translateY(${scrolled * 0.3}px)`;
  });
}

// Lazy Loading Images
function initLazyLoad() {
  if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          if (img.dataset.src) {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
            imageObserver.unobserve(img);
          }
        }
      });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
      imageObserver.observe(img);
    });
  }
}

// Form Enhancement
function initFormEnhancement() {
  const forms = document.querySelectorAll('form');
  
  forms.forEach(form => {
    const inputs = form.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
      // Focus effect
      input.addEventListener('focus', () => {
        input.parentElement.style.transform = 'translateY(-2px)';
      });
      
      input.addEventListener('blur', () => {
        input.parentElement.style.transform = 'translateY(0)';
      });
      
      // Validation feedback
      input.addEventListener('input', () => {
        if (input.validity.valid) {
          input.style.borderColor = '#A67C52';
        } else {
          input.style.borderColor = '#e74c3c';
        }
      });
    });
    
    // Form submission
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
      submitBtn.disabled = true;
      
      // Simulate sending (replace with actual form submission)
      setTimeout(() => {
        submitBtn.innerHTML = '<i class="fas fa-check"></i> Sent!';
        setTimeout(() => {
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
          form.reset();
        }, 2000);
      }, 1500);
    });
  });
}

// Hover Sound Effect (Optional)
function addHoverEffects() {
  const cards = document.querySelectorAll('.feature-card, .service-item, .quick-link-card');
  
  cards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
    });
  });
}

// Initialize all features
document.addEventListener('DOMContentLoaded', () => {
  initGalleryLightbox();
  initParallax();
  initLazyLoad();
  initFormEnhancement();
  addHoverEffects();
  
  // Add fade-in animation to page
  document.body.style.opacity = '0';
  setTimeout(() => {
    document.body.style.transition = 'opacity 0.6s ease';
    document.body.style.opacity = '1';
  }, 100);
});

// Page visibility change
document.addEventListener('visibilitychange', () => {
  if (document.hidden) {
    console.log('Page hidden');
  } else {
    console.log('Page visible');
  }
});

// Performance monitoring
window.addEventListener('load', () => {
  const loadTime = performance.now();
  console.log(`Page loaded in ${loadTime.toFixed(2)}ms`);
});
