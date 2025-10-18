<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ArtTrack</title>

  <!-- Link to CSS -->
  <link rel="stylesheet" href="style.css/landing.css">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

  <nav class="navbar">
    <div class="nav-left">
      <img src="images/Logo.png" alt="Logo" class="logo">
      <a href="#" class="logo-text">ArtTrack</a>
    </div>

    <ul class="nav-right nav-links">
      <li><a href="login.php">Log In</a></li>
      <li><a href="signup.php">Sign Up</a></li>
    </ul>
  </nav>

  <!-- ✅ Search bar -->
  <form class="search-bar" action="explorer.php" method="get">
    <input type="text" placeholder="Search..." name="q">
    <button type="submit"><i class="fa fa-search"></i></button>
  </form>

  <!-- ✅ Carousel Section -->
  <section class="carousel-section">
    <div class="carousel">
      <div class="carousel-slide active">
        <img src="/images/art1.png" alt="Slide 1">
      </div>
      <div class="carousel-slide">
        <img src="/images/art4.png" alt="Slide 2">
      </div>
      <div class="carousel-slide">
        <img src="/images/art3.png" alt="Slide 3">
      </div>
      <div class="carousel-slide">
        <img src="/images/bg.jpg" alt="Slide 4">
      </div>
      <div class="carousel-slide">
        <img src="/images/art5.png" alt="Slide 5">
      </div>
      <div class="carousel-slide">
        <img src="/images/art6.png" alt="Slide 6">
      </div>
       <div class="carousel-slide">
        <img src="/images/art7.png" alt="Slide 7">
      </div>
      <div class="carousel-slide">
        <img src="/images/art2.png" alt="Slide 8 ">
      </div>

      <button class="carousel-btn prev"><i class="fa-solid fa-chevron-left"></i></button>
      <button class="carousel-btn next"><i class="fa-solid fa-chevron-right"></i></button>


      <div class="carousel-dots"></div>
    </div>
  </section>

  <section class="artist-section">
    <h1 class="title">Artist of the Month</h1>

    <div class="artist-container" id="artistOfMonthContainer">
      <img src="images/artist.jpg" alt="Artist of the Month" class="artist-img">

      <div class="artist-details">
        <p class="artist-name">Loading...</p>
        <p class="artist-country"></p>
        <p class="artist-bio"></p>
      </div>
    </div>
  </section>

  
  <script src="javascript/fetcher_script.js"></script>
  <script src="javascript/carousel.js"></script>
</body>
</html>
