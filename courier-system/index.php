<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Courier Management System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- AOS CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/index.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">

</head>
<body>
    <!-- Navbar HTML (Responsive + Themed) -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <!-- ✅ Logo Image with link -->
       <a class="navbar-brand d-flex align-items-center position-relative" href="index.php" style="height: 30vh;">
          <img src="css/logo1.png" alt="Logo" class="navbar-logo main-logo">
          <img src="css/logo.png" alt="Logo" class="navbar-logo hover-logo">
       </a>


        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>

            <div class="d-flex gap-2 align-items-center ms-3">
                <a href="#" class="btn btn-outline-light shake-button" data-bs-toggle="modal" data-bs-target="#trackModal">📦 Track Parcel</a>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <!-- ✅ Guest Buttons -->
                    <a href="#" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    <a href="#" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                <?php else: ?>
                    <!-- ✅ Logged-in user with name & dropdown -->
                    
                    <div class="dropdown">
                      <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                          <span class="w2 fw-bold">
                              <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?>
                          </span>
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">👤 Profile</a></li>
                            <li><a class="dropdown-item" href="logout.php">🚪 Logout</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>



   <section class="hero-section">
  <div class="hero-overlay">
    <div class="hero-content" data-aos="fade-up">
      <div class="hero-logo">
      <h1>Courier Management System</h1>
      </div>
      <p class="hero-tagline">Delivering Trust at Speed</p>
      <a href="login.php" class="hero-cta">🚚 Track Your Parcel</a>
    </div>
  </div>
</section>



    <!-- About Us Section -->

    <section id="about" class="about-section text-center">
        <div class="container">
            <h2 class="about-title">Who We Are</h2>
            <div class="row mt-4">
            <div class="col-md-4">
                <div class="about-card">
                <h4>🎯 Our Mission</h4>
                <p>To revolutionize parcel delivery with speed, transparency, and trust — empowering businesses and customers alike.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-card">
                <h4>🚀 Our Vision</h4>
                <p>To become Pakistan's most reliable and preferred logistics company by 2030, with innovation at every step.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-card">
                <h4>📦 Our Story</h4>
                <p>Since 2020, we've delivered 1M+ parcels, earned trust of 30K+ clients, and continue to expand with excellence.</p>
                </div>
            </div>
            </div>
        </div>
    </section>
    <!-- Services Section -->
   <section id="services" class="services-section text-center">
        <div class="container">
            <h2 class="services-title" data-aos="fade-up">Our Services</h2>
            <div class="row mt-5">
            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="service-card">
                <h4>📦 Normal Delivery</h4>
                <p>Affordable and reliable delivery within 3-5 business days nationwide.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="service-card">
                <h4>🚀 Express Delivery</h4>
                <p>Fast 1-2 day delivery service with guaranteed delivery slots.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="service-card">
                <h4>⚡ Same-Day Delivery</h4>
                <p>Pickup and delivery in the same day — for urgent shipments across major cities.</p>
                </div>
            </div>
            </div>
            <div class="row mt-4 g-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="service-feature">
                <i class="fas fa-map-marked-alt"></i>
                <p>Nationwide Coverage</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-feature">
                <i class="fas fa-signal"></i>
                <p>Real-Time Tracking</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-feature">
                <i class="fas fa-sms"></i>
                <p>SMS Notifications</p>
                </div>
            </div>
            </div>
        </div>
    </section>
    <!-- Branches Section -->
    <section id="branches" class="branches-section text-center">
        <div class="container">
            <h2 class="branches-title" data-aos="fade-up">Our Branches</h2>
            <p class="branches-subtext" data-aos="fade-up" data-aos-delay="100">
            We are proud to serve across multiple cities in Pakistan.
            </p>
            <div class="row justify-content-center mt-4 g-4">
            <div class="col-md-2 col-6" data-aos="zoom-in"><div class="branch-box">Karachi</div></div>
            <div class="col-md-2 col-6" data-aos="zoom-in" data-aos-delay="100"><div class="branch-box">Lahore</div></div>
            <div class="col-md-2 col-6" data-aos="zoom-in" data-aos-delay="200"><div class="branch-box">Islamabad</div></div>
            <div class="col-md-2 col-6" data-aos="zoom-in" data-aos-delay="300"><div class="branch-box">Multan</div></div>
            <div class="col-md-2 col-6" data-aos="zoom-in" data-aos-delay="400"><div class="branch-box">Peshawar</div></div>
            </div>

            <div class="map-container mt-5" data-aos="fade-up" data-aos-delay="500">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d108236.64499311344!2d67.00113665918637!3d24.86073425926626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33f9206b5ea69%3A0x55a5f81a7eb7ef34!2sKarachi!5e0!3m2!1sen!2s!4v1695402412602!5m2!1sen!2s"
                    width="100%" height="300" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
    <!-- Contact Info Section -->
    <section id="contact" class="contact-section text-center">
        <div class="container">
            <h2 class="contact-title" data-aos="fade-up">Contact Us</h2>
            <p class="contact-subtext" data-aos="fade-up" data-aos-delay="100">
            We're here to help. Reach out to us anytime.
            </p>

            <div class="row mt-5 text-start">
            <div class="col-md-6 mb-4" data-aos="fade-right">
                <div class="contact-info-box">
                <h5>📍 Address</h5>
                <p>123 Main Street, Karachi, Pakistan</p>
                <h5>📞 Phone</h5>
                <p>+92 300 1234567</p>
                <h5>✉️ Email</h5>
                <p>CourierManagementSystem@gmail.com</p>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-left">
                <form class="contact-form">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Your Email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" rows="4" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit" class="btn btn-custom">Send Message</button>
                </form>
            </div>
            </div>
        </div>
    </section>
    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-container">

            <!-- Logo & Description -->
            <div class="footer-top">
            <div class="footer-logo">
                <img src="css/logo.png" alt="SpeedyCourier Logo"/>
            </div>
            <p class="footer-desc">
                Reliable courier services delivering your packages swiftly and safely across the globe.
            </p>
            </div>

            <!-- Contact Info -->
            <div class="footer-contact">
            <h3>Contact Us</h3>
            <p>123 Speedy Street, Delivery City, Country</p>
            <p>Phone: +92 300 1234567</p>
            <p>Email: CourierManagementSystem@gmail.com</p>
            </div>

            <!-- Newsletter Subscription -->
            <div class="footer-newsletter">
            <h3>Subscribe to our newsletter</h3>
            <form action="#" class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                <input type="email" placeholder="Your email address" required />
                <button type="submit">Subscribe</button>
            </form>
            </div>

            <!-- Social Links -->
            <div class="footer-social">
            <a href="#" aria-label="Facebook" class="social-icon facebook" target="_blank" rel="noopener">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" aria-label="Instagram" class="social-icon instagram" target="_blank" rel="noopener">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="#" aria-label="Twitter" class="social-icon twitter" target="_blank" rel="noopener">
                <i class="fab fa-twitter"></i>
            </a>
            </div>

            <!-- Legal Links -->
            <div class="footer-legal">
            <a href="#" class="footer-link">Privacy Policy</a>
            <a href="#" class="footer-link">Terms of Service</a>
            <p class="copyright">© 2025 Courier Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>
<!-- Tracking Modal -->

<div class="modal fade" id="trackModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="trackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="background-color: var(--secondary-color); color: var(--text-color);">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="trackModalLabel">
          <i class="fas fa-shipping-fast"></i> Parcel Tracking
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="trackForm" method="GET" action="">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="consignment_no" id="consignment_no" placeholder="Enter Tracking Number" required>
            <button class="btn btn-custom" type="submit">Track</button>
          </div>
        </form>

        <!-- Yahan tracking ka result show hoga -->
        <div id="trackingResult" class="mt-4"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background-color: var(--secondary-color); color: var(--text-color);">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="profileModalLabel">👤 User Profile</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        include 'db_connection.php';
        $userId = $_SESSION['user_id'];
        $result = $conn->query("SELECT * FROM users WHERE user_id = $userId");
        if ($result && $result->num_rows > 0) {
          $user = $result->fetch_assoc();
        ?>
        <ul class="list-group list-group-flush">
          <li class="list-group-item bg-transparent text-light"><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></li>
          <li class="list-group-item bg-transparent text-light"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
          <li class="list-group-item bg-transparent text-light"><strong>Address:</strong> <?= ucfirst($user['address']) ?></li>
        </ul>
        <?php } else { ?>
          <p class="text-danger">❌ Unable to load profile info.</p>
        <?php } ?>
      </div>
    </div>
  </div>
</div>




<div class="modal fade mt-5" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content login-container">
      <div class="modal-header">
        <h2 class="modal-title" id="loginModalLabel">Login</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="login.php">
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($_GET['error'])): ?>
          <p><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content login-container">
      <div class="modal-header">
        <h2 class="modal-title" id="registerModalLabel">Register</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="register.php">
          <input type="text" name="full_name" placeholder="Full Name" required>
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <input type="password" name="confirm_password" placeholder="Confirm Password" required>
          <textarea name="address" placeholder="Address" rows="3" required style="resize: none;"></textarea>
          <input type="hidden" name="role" value="customer"> <!-- Fixed role -->
          <button type="submit" name="register">Register</button>
        </form>
        <?php if (isset($_GET['register_error'])): ?>
          <p><?php echo htmlspecialchars($_GET['register_error']); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

  



</body>
</html>
  <!-- JS Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <!-- Paste this in <head> tag of your HTML file -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <script>
    AOS.init();
  </script>
<script>
document.getElementById('trackForm').addEventListener('submit', function(e) {
  e.preventDefault(); // page reload rok do

  let consignment_no = document.getElementById('consignment_no').value.trim();
  if (consignment_no === '') return;

  let resultDiv = document.getElementById('trackingResult');
  resultDiv.innerHTML = 'Loading... ⏳';

  fetch('track/track_parcel_ajax.php?consignment_no=' + encodeURIComponent(consignment_no))
    .then(response => response.text())
    .then(data => {
      resultDiv.innerHTML = data;
    })
    .catch(error => {
      resultDiv.innerHTML = '<p class="text-danger">Error occurred while tracking. Please try again.</p>';
      console.error('Error:', error);
    });
});
document.getElementById("downloadPDF").addEventListener("click", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const element = document.querySelector('.result-box');

    html2canvas(element).then((canvas) => {
      const imgData = canvas.toDataURL("image/png");
      const imgProps = doc.getImageProperties(imgData);
      const pdfWidth = doc.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      doc.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
      doc.save("parcel_tracking.pdf");
    });
  });
</script>
