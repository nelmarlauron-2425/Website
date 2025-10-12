<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ArtTrack</title>
  <link rel="stylesheet" href="style.css/buyer.css">
  <script defer src="gallery.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="logo"><img src="images/Logo.png" alt="ArtTrack Logo"> ArtTrack</div>
    <div class="search-container">
      <input type="text" id="searchBar" placeholder="Search artworks...">
      <button id="searchBtn"><i class="fa-solid fa-search"></i></button>
    </div>
    <div class="nav-buttons">
      <button class="nav-btn" id="aboutBtn">About</button>
      <button class="nav-btn" id="contactBtn">Contact</button>
    </div>
  </header>

  <main class="main">
    <!-- Filters Sidebar -->
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
          <li><input type="checkbox" class="filter" value="Painting"> Painting</li>
          <li><input type="checkbox" class="filter" value="Digital Art"> Digital Art</li>
          <li><input type="checkbox" class="filter" value="Sculpture"> Sculpture</li>
          <li><input type="checkbox" class="filter" value="Photography"> Photography</li>
          <li><input type="checkbox" class="filter" value="Drawing"> Drawing</li>
        </ul>
      </div>

      <div class="filter-group">
        <label>Medium:</label>
        <ul>
          <li><input type="checkbox" class="filter" value="Oil"> Oil</li>
          <li><input type="checkbox" class="filter" value="Acrylic"> Acrylic</li>
          <li><input type="checkbox" class="filter" value="Watercolor"> Watercolor</li>
          <li><input type="checkbox" class="filter" value="Pencil"> Pencil</li>
        </ul>
      </div>

      <div class="filter-group">
        <label>Subject:</label>
        <ul>
          <li><input type="checkbox" class="filter" value="Portrait"> Portrait</li>
          <li><input type="checkbox" class="filter" value="Landscape"> Landscape</li>
          <li><input type="checkbox" class="filter" value="Abstract"> Abstract</li>
          <li><input type="checkbox" class="filter" value="Still Life"> Still Life</li>
        </ul>
      </div>

      <div class="filter-group">
        <label>Size:</label>
        <ul>
          <li><input type="checkbox" class="filter" value="Small"> Small (≤ 50 cm)</li>
          <li><input type="checkbox" class="filter" value="Medium"> Medium (50–100 cm)</li>
          <li><input type="checkbox" class="filter" value="Large"> Large (≥ 100 cm)</li>
        </ul>
      </div>

      <div class="filter-group">
        <label>Material:</label>
        <ul>
          <li><input type="checkbox" class="filter" value="Canvas"> Canvas</li>
          <li><input type="checkbox" class="filter" value="Paper"> Paper</li>
          <li><input type="checkbox" class="filter" value="Wood"> Wood</li>
          <li><input type="checkbox" class="filter" value="Metal"> Metal</li>
        </ul>
      </div>
    </aside>

    <!-- Artworks Section -->
    <section class="gallery" id="gallery">
      <div class="art-card medium" data-category="Painting" data-medium="Watercolor" data-subject="Landscape" data-size="Medium" data-material="Paper" data-price="5000">
        <div class="art-image" style="background-image:url('art1.jpg')"></div>
        <div class="art-info">
          <h3>Sunset Dreams</h3>
          <p>Watercolor · 2023</p>
          <p class="price">₱5,000</p>
          <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
        </div>
      </div>

      <div class="art-card small" data-category="Digital Art" data-medium="Acrylic" data-subject="Portrait" data-size="Small" data-material="Canvas" data-price="2000">
        <div class="art-image" style="background-image:url('art2.jpg')"></div>
        <div class="art-info">
          <h3>Pixel Portrait</h3>
          <p>Digital · 2024</p>
          <p class="price">₱2,000</p>
          <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
        </div>
      </div>

      <div class="art-card large" data-category="Photography" data-medium="Oil" data-subject="Abstract" data-size="Large" data-material="Metal" data-price="8000">
        <div class="art-image" style="background-image:url('art3.jpg')"></div>
        <div class="art-info">
          <h3>Urban Chaos</h3>
          <p>Oil · 2022</p>
          <p class="price">₱8,000</p>
          <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
        </div>
      </div>

      <div class="art-card small" data-category="Drawing" data-medium="Pencil" data-subject="Still Life" data-size="Small" data-material="Paper" data-price="1500">
        <div class="art-image" style="background-image:url('art4.jpg')"></div>
        <div class="art-info">
          <h3>Fruit Study</h3>
          <p>Pencil · 2021</p>
          <p class="price">₱1,500</p>
          <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
        </div>
      </div>

      <div class="art-card large" data-category="Sculpture" data-medium="Acrylic" data-subject="Abstract" data-size="Large" data-material="Wood" data-price="12000">
        <div class="art-image" style="background-image:url('art5.jpg')"></div>
        <div class="art-info">
          <h3>Harmony in Motion</h3>
          <p>Acrylic · 2024</p>
          <p class="price">₱12,000</p>
          <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
        </div>
      </div>

      <!-- Added more artworks -->
      <div class="art-card medium" data-category="Painting" data-medium="Oil" data-subject="Portrait" data-size="Medium" data-material="Canvas" data-price="7000">
        <div class="art-image" style="background-image:url('art6.jpg')"></div>
        <div class="art-info">
          <h3>Golden Lady</h3>
          <p>Oil · 2023</p>
          <p class="price">₱7,000</p>
          <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
        </div>
      </div>

      <div class="art-card small" data-category="Drawing" data-medium="Pencil" data-subject="Abstract" data-size="Small" data-material="Paper" data-price="1000">
        <div class="art-image" style="background-image:url('art7.jpg')"></div>
        <div class="art-info">
          <h3>Sketch Flow</h3>
          <p>Pencil · 2022</p>
          <p class="price">₱1,000</p>
          <button class="heart-btn"><i class="fa-regular fa-heart"></i></button>
        </div>
      </div>
    </section>
  </main>
</body>
</html>