<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Artist Profile - ArtTrack</title>
  <link rel="stylesheet" href="/style.css/artist_profile.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
  <div class="container">
    <!-- Header Section -->
    <div class="profile-header">
      <div class="profile-info">
        <div class="profile-pic"></div>
        <div>
          <h1 class="artist-name">Ana Reyes</h1>
          <p class="artist-email"><i class="fa-solid fa-envelope"></i> anareyes@gmail.com</p>
          <p class="artist-meta">Active Since 2022 • Quezon City, Philippines</p>
          <p class="artist-bio">
            Contemporary Filipino artist specializing in abstract paintings and digital arts.
            My work explores the intersection of traditional Filipino culture.
          </p>
        </div>
      </div>
      <div class="profile-buttons">
        <button class="btn primary">Add Artwork</button>
        <button class="btn">Edit Profile</button>
        <button class="btn danger">Logout</button>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats">
      <div><span class="number">12k</span><p>Followers</p></div>
      <div><span class="number">6</span><p>Artworks</p></div>
      <div><span class="number">80%</span><p>Sold</p></div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
      <button class="tab active">Portfolio</button>
      <button class="tab">About</button>
      <button class="tab">Exhibitions</button>
      <button class="tab">Achievements</button>
    </div>

    <!-- Sort -->
    <div class="sort">
      <select>
        <option>Recommended</option>
        <option>Price: Low to High</option>
        <option>Price: High to Low</option>
        <option>Newest First</option>
        <option>Oldest First</option>
      </select>
    </div>

    <!-- Artwork Grid -->
    <div class="artwork-grid">
      <div class="artwork-card">
        <div class="artwork-img"></div>
        <div class="artwork-details">
          <div>
            <h3>Watercolor Dreamscapes</h3>
            <p>Watercolor • 2022</p>
            <span class="price">₱18,000</span>
          </div>
          <i class="fa-regular fa-heart like"></i>
        </div>
      </div>

      <div class="artwork-card">
        <div class="artwork-img"></div>
        <div class="artwork-details">
          <div>
            <h3>Abstract Serenity</h3>
            <p>Acrylic on Canvas • 2023</p>
            <span class="price">₱12,000</span>
          </div>
          <i class="fa-regular fa-heart like"></i>
        </div>
      </div>

      <div class="artwork-card">
        <div class="artwork-img"></div>
        <div class="artwork-details">
          <div>
            <h3>Mixed Media Collage</h3>
            <p>Mixed Media • 2023</p>
            <span class="price">₱10,000</span>
          </div>
          <i class="fa-regular fa-heart like"></i>
        </div>
      </div>

      <div class="artwork-card">
        <div class="artwork-img"></div>
        <div class="artwork-details">
          <div>
            <h3>Digital Harmony</h3>
            <p>Digital Art • 2024</p>
            <span class="price">₱20,000</span>
          </div>
          <i class="fa-regular fa-heart like"></i>
        </div>
      </div>

      <div class="artwork-card">
        <div class="artwork-img"></div>
        <div class="artwork-details">
          <div>
            <h3>Classical Portrait</h3>
            <p>Oil on Canvas • 2025</p>
            <span class="price">₱15,000</span>
          </div>
          <i class="fa-regular fa-heart like"></i>
        </div>
      </div>

      <div class="artwork-card">
        <div class="artwork-img"></div>
        <div class="artwork-details">
          <div>
            <h3>Modern Sculpture</h3>
            <p>Bronze • 2025</p>
            <span class="price">₱40,000</span>
          </div>
          <i class="fa-regular fa-heart like"></i>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
