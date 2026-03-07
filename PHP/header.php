<script src="../JS/script.js"></script>

<header>
  <div class="headerContent">
    <!--LOGO OF THE WEBPAGE (LEFT SIDE)-->
    <div class="logo">
      <a href="./adminlogin.php">
        <div class="logo-circle">
          <i class="fas fa-couch"></i>
        </div>
      </a>
    </div>
    <!--NAVIGATION MENU (CENTER)-->
    <div class="menu">
      <a href="./index.php" class="nav-link" title="Home">
        <i class="fas fa-home"></i>
        <span>Home</span>
      </a>
      <a href="./gallery.php" class="nav-link" title="Gallery">
        <i class="fas fa-images"></i>
        <span>Gallery</span>
      </a>
      <a href="./aboutus.php" class="nav-link" title="About Us">
        <i class="fas fa-info-circle"></i>
        <span>About</span>
      </a>
      <a href="./contactus.php" class="nav-link" title="Contact Us">
        <i class="fas fa-envelope"></i>
        <span>Contact</span>
      </a>
    </div>
    <!--APPOINTMENT BUTTON (RIGHT SIDE)-->
    <div class="appointment">
      <a href="./forms.php" class="appointment-btn" title="Book Appointment">
        <i class="fas fa-calendar-check"></i>
        <span>Book Now</span>
      </a>
    </div>
    <!-- MOBILE MENU BUTTON -->
    <button class="hamburg-ico" id="hamburg-ico" onClick="dropDownFunc()" aria-label="Toggle menu">
      <i class="fas fa-bars"></i>
    </button>
  </div>
  <!-- MOBILE DROPDOWN MENU -->
  <div class="relativeDropdown" id="dropdown">
    <div class="navDropdown">
      <a class="navOptions" href="./index.php" title="Home">
        <i class="fas fa-home"></i>
        <span>Home</span>
      </a>
      <a class="navOptions" href="./gallery.php" title="Gallery">
        <i class="fas fa-images"></i>
        <span>Gallery</span>
      </a>
      <a class="navOptions" href="./aboutus.php" title="About Us">
        <i class="fas fa-info-circle"></i>
        <span>About</span>
      </a>
      <a class="navOptions" href="./contactus.php" title="Contact Us">
        <i class="fas fa-envelope"></i>
        <span>Contact</span>
      </a>
      <a class="navOptions" href="./forms.php" title="Book Appointment">
        <i class="fas fa-calendar-check"></i>
        <span>Book</span>
      </a>
    </div>
  </div>
</header>