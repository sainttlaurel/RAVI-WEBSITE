<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../CSS/contactus.css?v=2">
  <link rel="stylesheet" href="../CSS/modern.css">
  <link rel="stylesheet" href="../CSS/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="icon" href="https://i.imgur.com/nMdo4LG.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <title>Contact Us - Ravi Modular Cabinet</title>
</head>

<body>
  <div class="bodyFlex">
    <div class="headerWrapper">
      <?php include("header.php"); ?>
    </div>

    <div class="contentWrapper">
      <div class="contact-hero">
        <div class="hero-overlay">
          <i class="fas fa-envelope-open-text"></i>
          <h1>Get In Touch</h1>
          <p>We'd love to hear from you</p>
        </div>
      </div>

      <div class="contact-wrapper">
        <div class="contact-container">
          <div class="contact-left">
            <div class="contact-header">
              <i class="fas fa-phone-alt"></i>
              <h2>CONTACT US</h2>
            </div>
            <p class="contact-desc">Connecting with you is our priority</p>
            
            <div class="contact-info-grid">
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-text">
                  <h4>Visit Us</h4>
                  <p><a href="https://www.facebook.com/ravimodularcabinet" target="_blank" rel="noopener">Find Our Showroom</a></p>
                </div>
              </div>
              
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-text">
                  <h4>Email</h4>
                  <p><a href="mailto:info@example.com">info@example.com</a></p>
                </div>
              </div>
              
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fab fa-facebook"></i>
                </div>
                <div class="contact-text">
                  <h4>Facebook</h4>
                  <p><a href="https://www.facebook.com/ravimodularcabinet" target="_blank" rel="noopener">Follow Our Page</a></p>
                </div>
              </div>
              
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fab fa-instagram"></i>
                </div>
                <div class="contact-text">
                  <h4>Instagram</h4>
                  <p><a href="#" target="_blank" rel="noopener">@ourcompany</a></p>
                </div>
              </div>

              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fas fa-phone"></i>
                </div>
                <div class="contact-text">
                  <h4>Phone</h4>
                  <p><a href="tel:+1234567890">+1 (234) 567-890</a></p>
                </div>
              </div>

              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="contact-text">
                  <h4>Business Hours</h4>
                  <p>Mon-Sat: 9AM - 6PM</p>
                </div>
              </div>
            </div>
          </div>

          <div class="contact-right">
            <div class="contact-header">
              <i class="fas fa-comments"></i>
              <h2>SEND MESSAGE</h2>
            </div>
            <p class="contact-desc">Your feedback helps us improve</p>
            
            <form class="contact-form" id="contactForm">
              <input type="hidden" name="form_type" value="contact">
              
              <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" id="contact-name" placeholder="Your Name" required>
              </div>
              
              <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="contact-email" placeholder="Your Email" required>
              </div>
              
              <div class="form-group">
                <i class="fas fa-tag"></i>
                <input type="text" name="subject" id="contact-subject" placeholder="Subject" required>
              </div>
              
              <div class="form-group">
                <i class="fas fa-comment-dots"></i>
                <textarea name="message" id="contact-message" rows="5" placeholder="Your Message" required></textarea>
              </div>
              
              <button type="submit" class="submit-btn">
                <span>Send Message</span>
                <i class="fas fa-paper-plane"></i>
              </button>
            </form>
          </div>
        </div>

        <div class="quick-links-section">
          <h3><i class="fas fa-link"></i> Quick Links</h3>
          <div class="quick-links-grid">
            <a href="./forms.php" class="quick-link-card">
              <i class="fas fa-calendar-check"></i>
              <span>Book Appointment</span>
            </a>
            <a href="./gallery.php" class="quick-link-card">
              <i class="fas fa-images"></i>
              <span>View Gallery</span>
            </a>
            <a href="./aboutus.php" class="quick-link-card">
              <i class="fas fa-info-circle"></i>
              <span>About Us</span>
            </a>
            <a href="./index.php" class="quick-link-card">
              <i class="fas fa-home"></i>
              <span>Home</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="footerWrapper">
      <?php include("footer.php"); ?>
    </div>
  </div>

  <?php include("slider.php"); ?>
  <script src="../JS/modern.js"></script>
  <script>
    // Handle contact form submission
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Get form data
      const formData = new FormData(this);
      
      // Log what we're sending
      console.log('Submitting contact form with data:');
      for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
      }
      
      // Disable submit button
      const submitBtn = this.querySelector('.submit-btn');
      const originalHTML = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span>Sending...</span><i class="fas fa-spinner fa-spin"></i>';
      
      // Send data to server
      fetch('submit_contact.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        console.log('Response status:', response.status);
        return response.json();
      })
      .then(data => {
        console.log('Response data:', data);
        if (data.success) {
          alert(data.message);
          this.reset();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Fetch error:', error);
        alert('Error submitting form. Please check console for details.');
      })
      .finally(() => {
        // Re-enable submit button
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHTML;
      });
    });
  </script>
</body>
</html>
