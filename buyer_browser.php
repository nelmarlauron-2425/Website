<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ArtTrack</title>
  <link rel="stylesheet" href="/style.css/buyer_browser.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <script defer src="/javascript/artist_browser.js"></script>
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="left-section">
      <div class="logo">
        <img src="/images/Logo.png" alt="ArtTrack Logo">
        <span>ArtTrack</span>
      </div>
    </div>

    <div class="search-bar">
  <input type="text" id="searchBar" placeholder="Search artworks or artists...">
  <button id="searchBtn"><i class="fa-solid fa-magnifying-glass"></i></button>
</div>

    <div class="nav-buttons">
      <a href= "about.php"class="nav-btn" id="aboutBtn">About</a>
      <a href = "contact_us.php"class="nav-btn" id="contactBtn">Contact</a>
      <a href = "buyer_purchase.php" class="nav-btn" id="commissionBtn">Purchase</a>
      <a href="user_profile.php" class="profile-btn" id="profilePic">
  <img src="/images/user.webp" alt="Profile">
</a>

    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="main">
    <!-- FILTERS -->
    <aside class="filters">
      <div class="filters-header">
        <h2>Filters</h2>
        <button id="clearAll">Clear All</button>
      </div>

      <div class="filter-group">
        <label>Price Range:</label>
        <input type="number" id="minPrice" placeholder="₱ Min">
        <input type="number" id="maxPrice" placeholder="₱ Max">
        <button id="applyPrice">Apply</button>
      </div>

      <div class="filter-group">
        <label>Category:</label>
        <ul>
          <li><input type="checkbox" class="filter" data-filter="category" value="Painting"> Painting</li>
          <li><input type="checkbox" class="filter" data-filter="category" value="Digital Art"> Digital Art</li>
          <li><input type="checkbox" class="filter" data-filter="category" value="Sculpture"> Sculpture</li>
          <li><input type="checkbox" class="filter" data-filter="category" value="Photography"> Photography</li>
          <li><input type="checkbox" class="filter" data-filter="category" value="Drawing"> Drawing</li>
        </ul>
      </div>

      <div class="filter-group">
        <label>Medium:</label>
        <ul>
          <li><input type="checkbox" class="filter" data-filter="medium" value="Oil"> Oil</li>
          <li><input type="checkbox" class="filter" data-filter="medium" value="Acrylic"> Acrylic</li>
          <li><input type="checkbox" class="filter" data-filter="medium" value="Watercolor"> Watercolor</li>
          <li><input type="checkbox" class="filter" data-filter="medium" value="Pencil"> Pencil</li>
        </ul>
      </div>

      <div class="filter-group">
        <label>Subject:</label>
        <ul>
          <li><input type="checkbox" class="filter" data-filter="subject" value="Portrait"> Portrait</li>
          <li><input type="checkbox" class="filter" data-filter="subject" value="Landscape"> Landscape</li>
          <li><input type="checkbox" class="filter" data-filter="subject" value="Abstract"> Abstract</li>
          <li><input type="checkbox" class="filter" data-filter="subject" value="Still Life"> Still Life</li>
        </ul>
      </div>

      <div class="filter-group">
        <label>Size:</label>
        <ul>
          <li><input type="checkbox" class="filter" data-filter="size" value="Small"> Small (≤ 50 cm)</li>
          <li><input type="checkbox" class="filter" data-filter="size" value="Medium"> Medium (50–100 cm)</li>
          <li><input type="checkbox" class="filter" data-filter="size" value="Large"> Large (≥ 100 cm)</li>
        </ul>
      </div>

      <div class="filter-group">
        <label>Material:</label>
        <ul>
          <li><input type="checkbox" class="filter" data-filter="material" value="Canvas"> Canvas</li>
          <li><input type="checkbox" class="filter" data-filter="material" value="Paper"> Paper</li>
          <li><input type="checkbox" class="filter" data-filter="material" value="Wood"> Wood</li>
          <li><input type="checkbox" class="filter" data-filter="material" value="Metal"> Metal</li>
        </ul>
      </div>
    </aside>

    <!-- GALLERY -->
   <section class="gallery" id="gallery">

  <div class="art-card medium" data-category="Painting" data-medium="Watercolor" data-subject="Landscape" data-size="Medium" data-material="Paper" data-price="5000">
    <div class="art-image" style="background-image:url('/images/art1.png')"></div>
    <div class="art-info">
      <div class="art-navbar">
        <h3>Sunset Dreams</h3>
        <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
      </div>
      <p>Watercolor · 2023</p>
      <p class="price">₱5,000</p>
    </div>
  </div>

  <div class="art-card small" data-category="Digital Art" data-medium="Acrylic" data-subject="Portrait" data-size="Medium" data-material="Canvas" data-price="2000">
    <div class="art-image" style="background-image:url('art2.jpg')"></div>
    <div class="art-info">
      <div class="art-navbar">
        <h3>Modern Muse</h3>
        <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
      </div>
      <p>Acrylic · 2024</p>
      <p class="price">₱2,000</p>
    </div>
  </div>

  <div class="art-card large" data-category="Digital Art" data-medium="Oil" data-subject="Abstract" data-size="Large" data-material="Canvas" data-price="3800">
    <div class="art-image" style="background-image:url('art3.jpg')"></div>
    <div class="art-info">
      <div class="art-navbar">
        <h3>Dreamscape</h3>
        <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
      </div>
      <p>Digital Art · 2022</p>
      <p class="price">₱3,800</p>
    </div>
  </div>

  <div class="art-card medium" data-category="Painting" data-medium="Oil" data-subject="Portrait" data-size="Medium" data-material="Canvas" data-price="4500">
    <div class="art-image" style="background-image:url('art4.jpg')"></div>
    <div class="art-info">
      <div class="art-navbar">
        <h3>Serenity</h3>
        <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
      </div>
      <p>Oil on Canvas · 2021</p>
      <p class="price">₱4,500</p>
    </div>
  </div>

  <div class="art-card small" data-category="Photography" data-medium="Digital" data-subject="Landscape" data-size="Small" data-material="Paper" data-price="2700">
    <div class="art-image" style="background-image:url('art5.jpg')"></div>
    <div class="art-info">
      <div class="art-navbar">
        <h3>Golden Hour</h3>
        <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
      </div>
      <p>Photography · 2024</p>
      <p class="price">₱2,700</p>
    </div>
  </div>

  <div class="art-card medium" data-category="Painting" data-medium="Acrylic" data-subject="Abstract" data-size="Medium" data-material="Canvas" data-price="3200">
    <div class="art-image" style="background-image:url('art6.jpg')"></div>
    <div class="art-info">
      <div class="art-navbar">
        <h3>Midnight Bloom</h3>
        <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
      </div>
      <p>Acrylic · 2023</p>
      <p class="price">₱3,200</p>
    </div>
  </div>

  <div class="art-card large" data-category="Painting" data-medium="Oil" data-subject="Abstract" data-size="Large" data-material="Canvas" data-price="4800">
    <div class="art-image" style="background-image:url('art7.jpg')"></div>
    <div class="art-info">
      <div class="art-navbar">
        <h3>Symphony</h3>
        <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
      </div>
      <p>Abstract · 2022</p>
      <p class="price">₱4,800</p>
    </div>
  </div>

  <div class="art-card small" data-category="Painting" data-medium="Watercolor" data-subject="Landscape" data-size="Small" data-material="Paper" data-price="3000">
    <div class="art-image" style="background-image:url('art8.jpg')"></div>
    <div class="art-info">
      <div class="art-navbar">
        <h3>Tranquil Path</h3>
        <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
      </div>
      <p>Watercolor · 2023</p>
      <p class="price">₱3,000</p>
    </div>
  </div>

</section>
  </main>
</body>
</html>