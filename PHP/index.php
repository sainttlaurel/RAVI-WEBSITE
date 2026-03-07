<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="icon" href="https://i.imgur.com/nMdo4LG.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title>Ravi Modular Cabinet - Premium Cabinetry Solutions</title>
  <meta name="description" content="Transform your space with Ravi Modular Cabinet - Leaders in quality cabinetry design and construction">
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
    <!-- DESKTOP PAGE HEADER -->
    <div class="headerWrapper">
      <?php include("header.php"); ?>
    </div>

    <!--TITLE OF THE WEBPAGE-->
    <div class="contentWrapper">
      <div class="homeTitle fade-in">
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
      <div class="features-section fade-in">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-drafting-compass"></i>
          </div>
          <h3>Custom Design</h3>
          <p>Tailored solutions for your unique space</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-award"></i>
          </div>
          <h3>Premium Quality</h3>
          <p>Excellence in every detail</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-tools"></i>
          </div>
          <h3>Expert Installation</h3>
          <p>Professional service guaranteed</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-clock"></i>
          </div>
          <h3>Timely Delivery</h3>
          <p>On schedule, every time</p>
        </div>
      </div>
    </div>

    <!-- PAGE FOOTER -->
    <div class="footerWrapper">
      <?php include("footer.php"); ?>
    </div>
  </div>

  <!--BACKGROUND OF THE WEBPAGE-->
  <?php include("slider.php"); ?>

</body>

</html>