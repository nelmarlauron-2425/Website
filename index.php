<?php
// You can place any future PHP logic here (e.g., session handling, dynamic data, etc.)
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ArtTrack</title>

  <!-- Link to CSS -->
  <link rel="stylesheet" href="../style.css/landing.css">

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
      <li><a href="login.html">Log In</a></li>
      <li><a href="signup.html">Sign Up</a></li>
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

  <script>
    // Artist of the Month: both genders, change monthly, info container
    async function setArtistOfMonth() {
      const monthKey = 'artistOfMonth_' + new Date().getFullYear() + '_' + (new Date().getMonth()+1);
      let artistData = localStorage.getItem(monthKey);
      if (artistData) {
        artistData = JSON.parse(artistData);
      } else {
        // Fetch random user (male or female)
        const userRes = await fetch('https://randomuser.me/api/?inc=name,picture,location,gender&noinfo');
        const userData = await userRes.json();
        const user = userData.results[0];
        artistData = {
          name: user.name.first + ' ' + user.name.last,
          img: user.picture.large,
          country: user.location.country,
          gender: user.gender,
          bio: `A talented ${user.gender === 'male' ? 'artist' : 'artist'} from ${user.location.country}. Passionate about creativity and expression.`
        };
        localStorage.setItem(monthKey, JSON.stringify(artistData));
      }

      // Set artist info
      document.querySelector('.artist-img').src = artistData.img;
      document.querySelector('.artist-img').alt = artistData.name;
      document.querySelector('.artist-name').textContent = artistData.name;
      document.querySelector('.artist-country').textContent = artistData.country;
      document.querySelector('.artist-bio').textContent = artistData.bio;
    }

    setArtistOfMonth();
  </script>

</body>
</html>
