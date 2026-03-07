<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./contactus.css">
  <link rel="stylesheet" href="./header.css">
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
      <div class="contact-wrapper fade-in">
        <div class="contact-container">
          <div class="contact-left">
            <div class="contact-header">
              <i class="fas fa-phone-alt"></i>
              <h2>CONTACT</h2>
            </div>
            <p class="contact-desc">Connecting people, a conversation with ease</p>
            
            <div class="contact-info-grid">
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-text">
                  <h4>Address</h4>
                  <p><a href="https://www.facebook.com/ravimodularcabinet" target="_blank" rel="noopener">Visit Our Location</a></p>
                </div>
              </div>
              
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-text">
                  <h4>Email</h4>
                  <p><a href="mailto:ravimodularcabinet@gmail.com">ravimodularcabinet@gmail.com</a></p>
                </div>
              </div>
              
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fab fa-facebook"></i>
                </div>
                <div class="contact-text">
                  <h4>Facebook</h4>
                  <p><a href="https://www.facebook.com/ravimodularcabinet" target="_blank" rel="noopener">@ravimodularcabinet</a></p>
                </div>
              </div>
              
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fab fa-instagram"></i>
                </div>
                <div class="contact-text">
                  <h4>Instagram</h4>
                  <p><a href="https://www.instagram.com/ravimodular0121/" target="_blank" rel="noopener">@ravimodular0121</a></p>
                </div>
              </div>
            </div>
          </div>

          <div class="contact-right">
            <div class="contact-header">
              <i class="fas fa-comments"></i>
              <h2>FEEDBACK</h2>
            </div>
            <p class="contact-desc">Feedback is the compass that points us towards improvement</p>
            
            <div class="contact-info-grid">
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-text">
                  <h4>KOLEHIYO Address</h4>
                  <p><a href="https://www.facebook.com/ravimodularcabinet" target="_blank" rel="noopener">Company Location</a></p>
                </div>
              </div>
              
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-text">
                  <h4>KOLEHIYO Email</h4>
                  <p><a href="mailto:kolehiyo21@gmail.com">kolehiyo21@gmail.com</a></p>
                </div>
              </div>
              
              <div class="contact-icon">
                <div class="icon-wrapper">
                  <i class="fas fa-info-circle"></i>
                </div>
                <div class="contact-text">
                  <h4>About KOLEHIYO</h4>
                  <p><a href="https://sites.google.com/view/kolehiyo/home" target="_blank" rel="noopener">Learn More</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Map Section -->
        <div class="map-section fade-in">
          <h3><i class="fas fa-map"></i> Find Us</h3>
          <div class="map-placeholder">
            <i class="fas fa-map-marked-alt"></i>
            <p>Interactive map coming soon</p>
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