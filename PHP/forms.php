<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/main-components.css">
    <link rel="stylesheet" href="../CSS/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="https://i.imgur.com/nMdo4LG.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Book Appointment - Ravi Modular Cabinet</title>
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

        <!-- Hero Section -->
        <div class="form-hero">
            <div class="form-hero-content">
                <i class="fas fa-calendar-check"></i>
                <h1>Book Your Appointment</h1>
                <p>Transform your space with expert craftsmanship</p>
            </div>
        </div>

        <div class="form-wrapper">
            <form class="modern-form">
                <div class="form-grid">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" id="name" required placeholder=" ">
                        <label for="name">Your Name</label>
                    </div>
                    
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="tel" id="number" required placeholder=" ">
                        <label for="number">Phone Number</label>
                    </div>
                </div>

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" required placeholder=" ">
                    <label for="email">Contact Email</label>
                </div>

                <div class="input-group">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" id="address" placeholder=" ">
                    <label for="address">Project Location (Optional)</label>
                </div>

                <div class="input-group">
                    <i class="fas fa-th-large"></i>
                    <select id="service" required>
                        <option value="" disabled selected>Select Service Type</option>
                        <option value="kitchen">Kitchen Cabinets</option>
                        <option value="bedroom">Bedroom Wardrobes</option>
                        <option value="office">Office Solutions</option>
                        <option value="living">Living Room Storage</option>
                        <option value="custom">Custom Design</option>
                        <option value="consultation">Free Consultation</option>
                    </select>
                    <label for="service" class="select-label">Service Type</label>
                </div>

                <div class="input-group">
                    <i class="fas fa-comment-dots"></i>
                    <textarea id="message" rows="6" required placeholder=" "></textarea>
                    <label for="message">Tell us about your project</label>
                </div>

                <button type="submit" class="submit-btn">
                    <span>Send Request</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>

            <div class="form-benefits">
                <div class="benefit-card">
                    <i class="fas fa-clock"></i>
                    <h3>Quick Response</h3>
                    <p>We'll get back within 24 hours</p>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-handshake"></i>
                    <h3>Free Consultation</h3>
                    <p>No obligation initial meeting</p>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-award"></i>
                    <h3>Quality Assured</h3>
                    <p>Premium materials & craftsmanship</p>
                </div>
            </div>
        </div>

        <!-- Trust Section -->
        <div class="trust-section fade-in">
            <div class="trust-badges">
                <div class="trust-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>Secure & Private</span>
                </div>
                <div class="trust-badge">
                    <i class="fas fa-star"></i>
                    <span>5-Star Rated</span>
                </div>
                <div class="trust-badge">
                    <i class="fas fa-users"></i>
                    <span>500+ Happy Clients</span>
                </div>
                <div class="trust-badge">
                    <i class="fas fa-certificate"></i>
                    <span>Licensed & Insured</span>
                </div>
            </div>
        </div>

        <div class="footerWrapper">
            <?php include('footer.php'); ?>
        </div>
    </div>

    <?php include('slider.php'); ?>

    <script src="../JS/script.js"></script>
    <script>
        // Handle form submission
        document.querySelector('.modern-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('phone', document.getElementById('number').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('service', document.getElementById('service').value);
            formData.append('message', document.getElementById('message').value);
            
            // Disable submit button
            const submitBtn = document.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Sending...</span><i class="fas fa-spinner fa-spin"></i>';
            
            // Send data to server
            fetch('submit_form.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    document.querySelector('.modern-form').reset();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error submitting form. Please try again.');
                console.error('Error:', error);
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    </script>
</body>
</html>