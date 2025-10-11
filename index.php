
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ArtTrack</title>

  <!-- Link to CSS -->
  <link rel="stylesheet" href="/style.css/landing.css">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

  <!-- Navigation bar -->
  <nav class="navbar">
    <div class="nav-left">
      <img src="../images/logo.png" alt="Logo" class="logo">
      <a href="#" class="logo-text">ArtTrack</a>
    </div>

    <ul class="nav-right nav-links">
      <li><a href="login.php">Log In</a></li>
      <li><a href="signup.php">Sign Up</a></li>
    </ul>
  </nav>

  <!-- Search bar -->
  <form class="search-bar" action="explorer.php" method="get">
    <input type="text" placeholder="Search..." name="q">
    <button type="submit"><i class="fa fa-search"></i></button>
  </form>

  <!-- Image slider -->
  <div class="container">
    <div class="slider">
      <div class="slide"><img src="images/art1.jpg" alt="Art 1"></div>
      <div class="slide"><img src="images/art2.jpg" alt="Art 2"></div>
      <div class="slide"><img src="images/art3.jpg" alt="Art 3"></div>
    </div>
  </div>

  <!-- Artist of the Month -->
  <h1 class="title">Artist of the Month</h1>
  <div class="artist-of-month" id="artistOfMonthContainer">
    <div class="artist-img-container">
      <img src="images/artist.jpg" alt="Artist of the Month" class="artist-img">
    </div>
    <div class="artist-info">
      <p class="artist-name">Loading...</p>
      <p class="artist-country"></p>
      <p class="artist-bio"></p>
    </div>
  </div>

  <script src = "javascript/fetcher_script.js"></script>

</body>
</html>
