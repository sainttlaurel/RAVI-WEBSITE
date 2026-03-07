// Dropdown JS Start [ kurut0 ]
function dropDownFunc() {
  var headCont = document.querySelector(".headerContent");
  var dropBod = document.querySelector(".navDropdown");
  
  if(dropBod.style.top === "10px" || dropBod.style.top === "") {
    headCont.style.boxShadow = "1px 1px 10px #0F0F0F";
    dropBod.style.top = "70px";
  }
  else {
    headCont.style.boxShadow = "none";
    dropBod.style.top = "10px";
  }
}
// Dropdown JS End [ kurut0 ]

// Loading Screen
window.addEventListener('load', function() {
  const loadingScreen = document.querySelector('.loading-screen');
  if (loadingScreen) {
    setTimeout(() => {
      loadingScreen.classList.add('hidden');
    }, 800);
  }
});

// Back to Top Button
const backToTopBtn = document.querySelector('.back-to-top');
if (backToTopBtn) {
  window.addEventListener('scroll', function() {
    if (window.pageYOffset > 300) {
      backToTopBtn.classList.add('visible');
    } else {
      backToTopBtn.classList.remove('visible');
    }
  });

  backToTopBtn.addEventListener('click', function() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

// Theme Toggle
const themeToggle = document.querySelector('.theme-toggle');
const htmlElement = document.documentElement;

// Check for saved theme preference
const currentTheme = localStorage.getItem('theme') || 'dark';
htmlElement.setAttribute('data-theme', currentTheme);

if (themeToggle) {
  // Update icon based on current theme
  updateThemeIcon(currentTheme);

  themeToggle.addEventListener('click', function() {
    const theme = htmlElement.getAttribute('data-theme');
    const newTheme = theme === 'dark' ? 'light' : 'dark';
    
    htmlElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeIcon(newTheme);
  });
}

function updateThemeIcon(theme) {
  if (themeToggle) {
    themeToggle.innerHTML = theme === 'dark' ? '☀️' : '🌙';
  }
}

// Scroll Animations
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }
  });
}, observerOptions);

// Observe all fade-in elements
document.addEventListener('DOMContentLoaded', function() {
  const fadeElements = document.querySelectorAll('.fade-in');
  fadeElements.forEach(el => observer.observe(el));
});

// Appointment Next Button [ Mobile View ]

var inputDone = false;

function appointNextBtn() {
  var email = document.getElementById("email").value;
  var phone = document.getElementById("phone").value;
  var date = document.getElementById("date").value;

  if(email.trim() === "") {
    alert("Please enter a valid Email Address.")
    return;
  }

  if(!/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/.test(phone)) {
    alert("Please enter a valid Phone Number");
    return;
  }

  if(date.trim() === "") {
    alert("Please enter a valid Date");
    return;
  }

  inputDone = true;
  updateAppointStyle();
}

function updateAppointStyle() {
  var clientInput = document.querySelector(".clientInputs");
  var slots = document.querySelector(".availableSlots");
  var nextBtn = document.getElementById("nextBtn");
  var submitBtn = document.getElementById("submitBtn");

  if(!inputDone) {
    return;
  }

  if(window.matchMedia("(max-width: 768px").matches) {
    if(clientInput.style.display === "flex" || clientInput.style.display === "") {
      clientInput.style.display = "none";
    }
    slots.style.display = "table";
    submitBtn.style.display = "block";
  }
  else {
    clientInput.style.display = "flex";
  }
}

window.addEventListener("resize", updateAppointStyle);

function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
  }
}

function shuffleImages() {
  const imageElements = document.querySelectorAll('.container .box .rows img');
  const imageSources = Array.from(imageElements).map(img => img.src);

  shuffleArray(imageSources);

  imageElements.forEach((img, index) => {
      img.src = imageSources[index];
  });
}

window.addEventListener('load', shuffleImages);


// Gallery Image Modal
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('imageModal');
  const modalImg = document.getElementById('modalImage');
  const modalCaption = document.querySelector('.modal-caption');
  const closeModal = document.querySelector('.modal-close');
  
  // Add click event to all gallery images
  const galleryImages = document.querySelectorAll('.container .box .rows img');
  galleryImages.forEach((img, index) => {
    img.addEventListener('click', function() {
      if (modal && modalImg) {
        modal.style.display = 'block';
        modalImg.src = this.src;
        if (modalCaption) {
          modalCaption.textContent = this.alt || `Image ${index + 1}`;
        }
      }
    });
  });

  // Close modal
  if (closeModal) {
    closeModal.addEventListener('click', function() {
      if (modal) {
        modal.style.display = 'none';
      }
    });
  }

  // Close modal when clicking outside image
  if (modal) {
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  }

  // Gallery Search
  const searchInput = document.getElementById('gallerySearch');
  if (searchInput) {
    searchInput.addEventListener('input', function(e) {
      const searchTerm = e.target.value.toLowerCase();
      const images = document.querySelectorAll('.container .box .rows img');
      
      images.forEach(img => {
        const alt = img.alt.toLowerCase();
        const parent = img.parentElement;
        
        if (alt.includes(searchTerm)) {
          img.style.display = 'block';
        } else {
          img.style.display = 'none';
        }
      });
    });
  }

  // Gallery Filter Buttons
  const filterButtons = document.querySelectorAll('.filter-btn');
  filterButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      // Remove active class from all buttons
      filterButtons.forEach(b => b.classList.remove('active'));
      // Add active class to clicked button
      this.classList.add('active');
      
      const filter = this.getAttribute('data-filter');
      const images = document.querySelectorAll('.container .box .rows img');
      
      images.forEach(img => {
        if (filter === 'all') {
          img.style.display = 'block';
        } else {
          const alt = img.alt.toLowerCase();
          if (alt.includes(filter)) {
            img.style.display = 'block';
          } else {
            img.style.display = 'none';
          }
        }
      });
    });
  });
});
