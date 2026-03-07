<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../CSS/contactus.css">
  <link rel="stylesheet" href="../CSS/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="icon" href="https://i.imgur.com/nMdo4LG.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title>Contact Us - Ravi Modular Cabinet</title>
</head>

<body>
  <!-- Loading Screen -->
  <div class="loading-screen">
    <div class="loader"></div>
  </div>

  <!-- Theme Toggle -->
  <button class="theme-toggle" aria-label="Toggle theme">🌙</button>

  <!-- Back to Top Button -->
  <button class="back-to-top" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
  </button>

  <div class="bodyFlex">
    <div class="headerWrapper">
      <?php include("header.php"); ?>
    </div>

    <div class="contentWrapper">
      <!-- Hero Section -->
      <div class="contact-hero fade-in">
        <div class="hero-overlay">
          <i class="fas fa-envelope-open-text"></i>
          <h1>Get In Touch</h1>
          <p>We'd love to hear from you</p>
        </div>
      </div>

      <div class="contact-wrapper fade-in">
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
            
            <form class="contact-form">
              <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Your Name" required>
              </div>
              
              <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Your Email" required>
              </div>
              
              <div class="form-group">
                <i class="fas fa-tag"></i>
                <input type="text" placeholder="Subject" required>
              </div>
              
              <div class="form-group">
                <i class="fas fa-comment-dots"></i>
                <textarea rows="5" placeholder="Your Message" required></textarea>
              </div>
              
              <button type="submit" class="submit-btn">
                <span>Send Message</span>
                <i class="fas fa-paper-plane"></i>
              </button>
            </form>
          </div>
        </div>

        <!-- Quick Links Section -->
        <div class="quick-links-section fade-in">
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
</body>

</html>