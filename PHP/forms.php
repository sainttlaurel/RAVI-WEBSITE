<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./forms.css">
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

    <?php include("header.php"); ?>

    <div class="form-wrapper fade-in">
        <div class="form-header">
            <i class="fas fa-calendar-check"></i>
            <h1>Book Your Appointment</h1>
            <p>Let's bring your cabinet dreams to life</p>
        </div>

        <form onsubmit="sendEmail(); reset(); return false;" class="modern-form">
            <div class="form-grid">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" required autocomplete="off">
                    <label for="name">Your Name</label>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="tel" id="number" required autocomplete="off">
                    <label for="number">Phone Number</label>
                </div>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" required autocomplete="off">
                <label for="email">Contact Email</label>
            </div>

            <div class="input-group">
                <i class="fas fa-home"></i>
                <input type="text" id="address" autocomplete="off">
                <label for="address">Project Address (Optional)</label>
            </div>

            <div class="input-group">
                <i class="fas fa-list"></i>
                <select id="service" required>
                    <option value="" disabled selected>Select Service Type</option>
                    <option value="kitchen">Kitchen Cabinets</option>
                    <option value="bedroom">Bedroom Cabinets</option>
                    <option value="office">Office Cabinets</option>
                    <option value="custom">Custom Design</option>
                    <option value="consultation">Free Consultation</option>
                </select>
                <label for="service" class="select-label">Service Type</label>
            </div>

            <div class="input-group">
                <i class="fas fa-comment-dots"></i>
                <textarea id="message" rows="6" required autocomplete="off"></textarea>
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
                <p>We'll get back to you within 24 hours</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-handshake"></i>
                <h3>Free Consultation</h3>
                <p>No obligation initial meeting</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Quality Guaranteed</h3>
                <p>Premium materials and craftsmanship</p>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <?php include('slider.php'); ?>

    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script>
        function sendEmail(){
            const service = document.getElementById("service").value;
            const address = document.getElementById("address").value;
            
            Email.send({
                Host : "smtp.gmail.com",
                Username : "USERNAME",
                Password : "PASSWORD",
                To : 'kolehiyo21@gmail.com',
                From : document.getElementById("email").value,
                Subject : "New Appointment Request - " + service,
                Body : "Name: " + document.getElementById("name").value
                        + "<br> Email: " + document.getElementById("email").value
                        + "<br> Phone Number: " + document.getElementById("number").value
                        + "<br> Service Type: " + service
                        + "<br> Address: " + (address || "Not provided")
                        + "<br> Message: " + document.getElementById("message").value
            }).then(
                message => {
                    if(message === "OK") {
                        alert("Thank you! Your appointment request has been sent successfully. We'll contact you soon!");
                    } else {
                        alert("Message sent: " + message);
                    }
                }
            );
        }
    </script>
</body>
</html>