<?php
session_start();  // Start session to check if the user is logged in

// Check if the user is logged in
if (isset($_SESSION['userid'])) {
    $username = $_SESSION['username'];  // Fetch the logged-in username
} else {
    $username = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Posh Paws Grooming</title>

  <!-- SEO Meta -->
  <meta name="description" content="Professional pet grooming service for dogs and cats. Book now at Posh Paws Grooming!">
  <meta name="keywords" content="Pet Grooming, Dog Grooming, Cat Grooming, Pet Spa">
  <meta name="author" content="Posh Paws Team">
  
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <link rel="stylesheet" href="style.css"/>
  <style>
    /* Your custom styles */
    .services {
      background-color: #fff9f4;
      padding: 60px 20px;
      text-align: center;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
    }

    .services h2 {
      font-size: 2.5rem;
      margin-bottom: 40px;
      color: #d6336c;
      width: 100%;
    }

    .package {
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      width: 280px;
      height: 420px;
      margin: 20px;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-align: left;
      vertical-align: top;
    }

    .package:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .package img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 15px;
    }

    .package h3 {
      font-size: 1.4rem;
      color: #e75480;
      margin-bottom: 10px;
    }

    .package p {
      font-size: 0.95rem;
      line-height: 1.5;
      color: #555;
    }

    /* Gallery Section */
    #gallery {
      padding: 60px 20px;
      background-color: #f8f8f8;
      text-align: center;
    }

    #gallery h2 {
      font-size: 2.5rem;
      margin-bottom: 40px;
      color: #d6336c;
    }

    /* Lightbox modal */
    .lightbox {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.9);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .lightbox img {
      max-width: 90%;
      max-height: 80%;
    }

    .lightbox-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      color: white;
      font-size: 3rem;
      cursor: pointer;
      padding: 0 20px;
    }

    .lightbox-nav.prev {
      left: 10px;
    }

    .lightbox-nav.next {
      right: 10px;
    }

    .lightbox-close {
      position: absolute;
      top: 10px;
      right: 20px;
      font-size: 2rem;
      color: white;
      cursor: pointer;
    }
/* Swiper container styling */
.swiper {
  width: 100%;
  padding: 40px 0;
  box-sizing: border-box;
}

/* Swiper slide styling */
.swiper-slide {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 250px; /* Adjust this height as needed */
  overflow: hidden;
  border-radius: 10px;
  background: #fff;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transition: transform 0.3s ease;
}

/* Swiper image styling */
.swiper-slide img {
  height: 100%;
  width: auto;
  object-fit: cover;
  border-radius: 10px;
  max-width: 100%;
}
.swiper-slide img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Or use contain if you don't want cropping */
}
.logo-title {
  display: flex;
  align-items: center;
  gap: 0px;
}

.site-logo {
  height: 60px; /* Adjust as needed */
  width: 80px;
}

  </style>

</head>
<body>

<header role="banner">
  <div class="logo-title">
    <img src="images/logo.png" alt="Posh Paws Logo" class="site-logo" />
    <h1>Posh Paws Grooming</h1>
  </div>
  <nav role="navigation">

    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="#packages">Packages</a></li>
      <li><a href="#gallery">Gallery</a></li>
      <?php if ($username): ?>
  <li><a href="booking.php">Book</a></li>
<?php else: ?>
  <li><a href="#booking">Book</a></li>
<?php endif; ?>

      <?php if ($username): ?>
  <li><a href="dashboard.php">Dashboard</a></li>
  <li>Welcome, <?php echo htmlspecialchars($username); ?></li>
  <li><a href="logout.php">Logout</a></li>
<?php else: ?>
  <li><a href="login.php">Login</a></li>
  <li><a href="register.php">Register</a></li>
<?php endif; ?>

    </ul>
  </nav>
</header>

<section class="hero">
  <h2>Pampering Your Pets with Love</h2>
  <p>Professional grooming for dogs and cats</p>
  <a href="booking.php" class="cta-button">Book Now</a>
</section>

<section class="services" id="packages">
  <h2>Our Grooming Packages</h2>
  <div class="package">
    <img src="images/package1.jpg" alt="Basic Bath Package" />
    <h3><a href="booking.php">Basic Bath - $30</a></h3>
    <p>A gentle wash with premium pet-safe shampoo, blow-dry, light brushing, and ear cleaning.<br><strong>Duration:</strong> ~30 minutes</p>
  </div>
  <div class="package">
    <img src="images/package2.jpg" alt="Full Groom Package" />
    <h3><a href="booking.php">Full Groom - $55</a></h3>
    <p>Complete grooming including bath, breed-specific haircut, nail trimming, ear care, and styling.<br><strong>Duration:</strong> ~60 minutes</p>
  </div>
  <div class="package">
    <img src="images/package3.jpg" alt="Spa Day Package" />
    <h3><a href="booking.php">Spa Day - $80</a></h3>
    <p>A luxury treatment with everything in the Full Groom, plus deep coat conditioning, blueberry facial, and paw balm massage.<br><strong>Duration:</strong> ~90 minutes</p>
  </div>
</section>

<section id="gallery">
  <h2>Gallery</h2>
  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide"><img src="images/hero.jpg" alt="Pet 1" /></div>
      <div class="swiper-slide"><img src="images/package2.jpg" alt="Pet 2" /></div>
      <div class="swiper-slide"><img src="images/package3.jpg" alt="Pet 3" /></div>
      <div class="swiper-slide"><img src="images/gallery4.jpg" alt="Pet 4" /></div>
      <div class="swiper-slide"><img src="images/gallery5.jpg" alt="Pet 5" /></div>
      <div class="swiper-slide"><img src="images/gallery6.jpg" alt="Pet 6" /></div>
      <div class="swiper-slide"><img src="images/gallery1.jpg" alt="Pet 7" /></div>
      <div class="swiper-slide"><img src="images/gallery2.jpg" alt="Pet 8" /></div>
      <div class="swiper-slide"><img src="images/gallery3.jpg" alt="Pet 9" /></div>
      <div class="swiper-slide"><img src="images/gallery7.jpg" alt="Pet 7" /></div>
      <div class="swiper-slide"><img src="images/gallery8.jpg" alt="Pet 8" /></div>
      <div class="swiper-slide"><img src="images/gallery9.jpg" alt="Pet 9" /></div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
  <!-- Lightbox Modal -->
  <div class="lightbox" id="lightbox">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <span class="lightbox-nav prev" onclick="changeSlide(-1)">&#10094;</span>
    <img id="lightbox-img" src="" alt="Lightbox Image">
    <span class="lightbox-nav next" onclick="changeSlide(1)">&#10095;</span>
  </div>
</section>

<section id="booking">
  <h2>Book an Appointment</h2>
  <form id="bookingForm" action="booking.php" method="POST" role="form">
    <input type="text" name="pet_type" placeholder="Pet Type (Dog, Cat...)" required minlength="2" />
    <select name="package" required>
      <option disabled selected>Select a Package</option>
      <option>Basic Bath - $30</option>
      <option>Full Groom - $55</option>
      <option>Spa Day - $80</option>
    </select>
    <input type="date" name="appointment_date" required />
    <input type="time" name="appointment_time" required />
    <button type="submit">Submit Booking</button>
  </form>
</section>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  const swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    },
    breakpoints: {
      640: {
        slidesPerView: 2
      },
      768: {
        slidesPerView: 3
      },
      1024: {
        slidesPerView: 4
      }
    }
  });

  // Open lightbox when a slide is clicked
  const swiperSlides = document.querySelectorAll('.swiper-slide');
  swiperSlides.forEach((slide, index) => {
    slide.addEventListener('click', () => {
      openLightbox(index);  // Open lightbox on slide click
    });
  });

  function openLightbox(index) {
    const images = document.querySelectorAll('.swiper-slide img');
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    lightbox.style.display = 'flex';
    lightboxImg.src = images[index].src;
  }

  function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
  }

  function changeSlide(direction) {
    const images = document.querySelectorAll('.swiper-slide img');
    let currentIndex = Array.from(images).findIndex(img => img.src === document.getElementById('lightbox-img').src);
    currentIndex = (currentIndex + direction + images.length) % images.length;
    document.getElementById('lightbox-img').src = images[currentIndex].src;
  }
</script>
<footer id="contact" role="contentinfo" style="background-color:#fff9f4; text-align:center; padding:30px 20px; margin-top:50px;">
  <p style="font-size:1.1rem; margin:10px 0;">Contact us at <a href="mailto:info@poshpaws.com" style="color:#d6336c; text-decoration:none;">info@poshpaws.com</a></p>
  <p style="font-size:1.1rem; margin:10px 0;">Follow us on <a href="#" style="color:#d6336c; text-decoration:none;">Instagram</a> &amp; <a href="#" style="color:#d6336c; text-decoration:none;">Facebook</a></p>
  <p style="font-size:0.9rem; color:#777; margin-top:20px;">&copy; 2025 Posh Paws Grooming. All rights reserved.</p>
</footer>

</body>
</html>
