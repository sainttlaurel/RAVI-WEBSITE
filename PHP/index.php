<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../CSS/index.css">
  <link rel="stylesheet" href="../CSS/modern.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="icon" href="https://i.imgur.com/nMdo4LG.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <title>Ravi Modular Cabinet - Premium Cabinetry Solutions</title>
</head>

<body>
  <div class="bodyFlex">
    <div class="headerWrapper">
      <?php include("header.php"); ?>
    </div>

    <div class="contentWrapper">
      <!-- Hero Section -->
      <div class="homeTitle">
        <img class="custom-header" src="https://i.imgur.com/q3fiLLR.png" alt="Ravi Modular Cabinet Logo">
        <p class="quote">Where Function Meets Aesthetic Harmony in Every Architectural Space</p>
        <div class="cta-buttons">
          <a href="./gallery.php" class="btn btn-primary">
            <i class="fas fa-images"></i> View Gallery
          </a>
          <a href="./forms.php" class="btn btn-secondary">
            <i class="fas fa-calendar-check"></i> Book Appointment
          </a>
        </div>
      </div>

      <!-- Features Section -->
      <div class="features-section">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-drafting-compass"></i>
          </div>
          <h3>Custom Design</h3>
          <p>Tailored solutions crafted for your unique space and lifestyle</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-gem"></i>
          </div>
          <h3>Premium Materials</h3>
          <p>Finest quality wood and sustainable materials</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-tools"></i>
          </div>
          <h3>Expert Craftsmanship</h3>
          <p>Precision installation by skilled professionals</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-leaf"></i>
          </div>
          <h3>Eco-Friendly</h3>
          <p>Sustainable practices for a better tomorrow</p>
        </div>
      </div>

      <!-- Services Showcase -->
      <div class="services-showcase">
        <h2 class="section-title">Our Specialties</h2>
        <div class="services-grid">
          <div class="service-item">
            <img src="https://images.unsplash.com/photo-1556912172-45b7abe8b7e1?w=800&q=80" alt="Modern Kitchen Cabinets">
            <div class="service-overlay">
              <h3>Kitchen Cabinets</h3>
              <p>Sleek, functional designs for modern living</p>
            </div>
          </div>
          <div class="service-item">
            <img src="https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=800&q=80" alt="Bedroom Wardrobes">
            <div class="service-overlay">
              <h3>Bedroom Wardrobes</h3>
              <p>Elegant storage solutions with timeless appeal</p>
            </div>
          </div>
          <div class="service-item">
            <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=800&q=80" alt="Office Cabinets">
            <div class="service-overlay">
              <h3>Office Solutions</h3>
              <p>Professional workspace organization</p>
            </div>
          </div>
          <div class="service-item">
            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80" alt="Living Room Storage">
            <div class="service-overlay">
              <h3>Living Spaces</h3>
              <p>Custom built-ins for every room</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Section -->
      <div class="stats-section">
        <div class="stat-item">
          <div class="stat-number">500+</div>
          <div class="stat-label">Projects Completed</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">98%</div>
          <div class="stat-label">Client Satisfaction</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">15+</div>
          <div class="stat-label">Years Experience</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">50+</div>
          <div class="stat-label">Expert Craftsmen</div>
        </div>
      </div>
    </div>

    <div class="footerWrapper">
      <?php include("footer.php"); ?>
    </div>
  </div>

  <?php include("slider.php"); ?>
  <script src="../JS/modern.js"></script>
</body>
</html>
