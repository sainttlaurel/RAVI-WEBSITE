<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../CSS/gallery.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="icon" href="https://i.imgur.com/nMdo4LG.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title>Ravi Modular Gallery - Our Work</title>
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
      <!-- Search Bar -->
      <div class="gallery-controls fade-in scroll-reveal">
        <div class="search-bar">
          <i class="fas fa-search"></i>
          <input type="text" id="gallerySearch" placeholder="Search gallery..." />
        </div>
        <div class="filter-buttons">
          <button class="filter-btn active" data-filter="all">All</button>
          <button class="filter-btn" data-filter="kitchen">Kitchen</button>
          <button class="filter-btn" data-filter="bedroom">Bedroom</button>
          <button class="filter-btn" data-filter="office">Office</button>
        </div>
      </div>

      <!-- IMAGE GALLERY -->
      <div class="container fade-in scroll-reveal">
        <div class="heading scroll-reveal">
          <h3>RAVI <span>Gallery</span></h3>
          <p class="gallery-subtitle">Explore our finest cabinet designs and installations</p>
        </div>
        <div class="box">
          <div class="rows scroll-reveal">
            <img src="https://images.unsplash.com/photo-1556912172-45b7abe8b7e1?w=600&q=80" alt="Modern White Kitchen Cabinet" loading="lazy">
            <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80" alt="Minimalist Kitchen Design" loading="lazy">
            <img src="https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=600&q=80" alt="Contemporary Bedroom Wardrobe" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=600&q=80" alt="Modern Office Cabinet" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600&q=80" alt="Living Room Built-in Storage" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=600&q=80" alt="Scandinavian Kitchen" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80" alt="Modern Kitchen Island" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=600&q=80" alt="Contemporary Kitchen Design" loading="lazy">
            <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=600&q=80" alt="Minimal White Kitchen" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=600&q=80" alt="Modern Kitchen Cabinets" loading="lazy">
          </div>
          <div class="rows scroll-reveal">
            <img src="https://images.unsplash.com/photo-1600607687644-c7171b42498b?w=600&q=80" alt="Luxury Kitchen Design" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=600&q=80" alt="Modern Kitchen Interior" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600489000022-c2086d79f9d4?w=600&q=80" alt="Contemporary Wardrobe" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=600&q=80" alt="Minimalist Cabinet Design" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566752229-250ed79470e6?w=600&q=80" alt="Modern Kitchen Setup" loading="lazy">
            <img src="https://images.unsplash.com/photo-1556912167-f556f1f39faa?w=600&q=80" alt="White Kitchen Cabinets" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600585152915-d208bec867a1?w=600&q=80" alt="Contemporary Kitchen" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566753151-384129cf4e3e?w=600&q=80" alt="Modern Kitchen Space" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600&q=80" alt="Living Room Storage" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600210491892-03d54c0aaf87?w=600&q=80" alt="Office Cabinet Design" loading="lazy">
          </div>
          <div class="rows scroll-reveal">
            <img src="https://images.unsplash.com/photo-1600210492493-0946911123ea?w=600&q=80" alt="Modern Workspace" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600573472592-401b489a3cdc?w=600&q=80" alt="Bedroom Wardrobe Design" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=600&q=80" alt="Kitchen Cabinet Details" loading="lazy">
            <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80" alt="Minimal Kitchen" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600585154363-67eb9e2e2099?w=600&q=80" alt="Contemporary Cabinet" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600607687644-c7171b42498b?w=600&q=80" alt="Luxury Cabinet Design" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=600&q=80" alt="Modern Kitchen View" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=600&q=80" alt="Kitchen Storage Solutions" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=600&q=80" alt="Minimalist Design" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566752229-250ed79470e6?w=600&q=80" alt="Modern Kitchen Layout" loading="lazy">
          </div>
          <div class="rows scroll-reveal">
            <img src="https://images.unsplash.com/photo-1556912173-46c336c7fd55?w=600&q=80" alt="White Cabinet Design" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80" alt="Kitchen Island Cabinet" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=600&q=80" alt="Scandinavian Style" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600489000022-c2086d79f9d4?w=600&q=80" alt="Wardrobe Interior" loading="lazy">
            <img src="https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=600&q=80" alt="Bedroom Storage" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=600&q=80" alt="Office Organization" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600566753151-384129cf4e3e?w=600&q=80" alt="Modern Kitchen Aesthetic" loading="lazy">
            <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=600&q=80" alt="Clean Kitchen Design" loading="lazy">
            <img src="https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=600&q=80" alt="Cabinet Craftsmanship" loading="lazy">
            <img src="https://images.unsplash.com/photo-1556912172-45b7abe8b7e1?w=600&q=80" alt="Premium Kitchen Cabinets" loading="lazy">
          </div>
        </div>
      </div>
    </div>

    <div class="footerWrapper">
      <?php include("footer.php"); ?>
    </div>
  </div>

  <?php include("slider.php"); ?>

  <!-- Image Modal -->
  <div id="imageModal" class="modal">
    <span class="modal-close">&times;</span>
    <img class="modal-content" id="modalImage">
    <div class="modal-caption"></div>
  </div>

  <script src="../JS/modern-features.js"></script>
</body>

</html>