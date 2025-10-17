<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Artwork Details - ArtTrack</title>
  <link rel="stylesheet" href="style.css" />
  <script defer src="script.js"></script>
</head>
<body>
  <!-- HEADER -->
  <header class="header">
  <div class="logo">
    <img src="CC_20250930_211854.png" alt="Logo" class="logo-img">
  </div>

  <div class="search-bar">
    <input type="text" placeholder="Search artworks...">
    <button>🔍</button>
  </div>

  <nav class="nav-right">
    <div class="nav-links">
      <a href="#">About</a>
      <a href="#">Contact Us</a>
      <a href="#">Purchase</a>
    </div>
    <img src="cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIzLTAxL3JtNjA5LXNvbGlkaWNvbi13LTAwMi1wLnBuZw.webp" alt="Profile" class="profile-img" onclick="goToProfile()">
  </nav>
</header>

  <!-- MAIN CONTENT -->
  <main class="art-details">
    <div class="art-left">
      <img src="532824826_122108575310965607_162360980821454380_n.jpg" alt="Artwork" class="art-image" />
      <div class="button-row">
        <button class="btn order-btn" onclick="openModal('orderModal')">REQUEST ORDER</button>
        <button class="btn message-btn" onclick="openModal('messageModal')">MESSAGE</button>
      </div>
    </div>

    <div class="art-right">
      <h1 class="art-title">SUNSET OVER HILLS</h1>
      <p class="breadcrumb">Landscape > Oil Painting > Nature</p>

      <div class="likes-price">
        <span>❤️ 6.6k+</span>
        <span class="price">PHP 25,000.00</span>
      </div>

      <div class="details">
        <p><strong>Size:</strong> 24 x 36 inches</p>
        <p><strong>Medium:</strong> Oil on Canvas</p>
        <p><strong>Material:</strong> Canvas</p>
        <p><strong>Year:</strong> 2025</p>
      </div>

      <div class="artist-info">
        <p><strong>Get to know the artist:</strong> <span class="artist-name">Juan Dela Cruz</span></p>
        <p><strong>Availability:</strong> Available</p>
      </div>

      <div class="description">
        <h3>DESCRIPTION:</h3>
        <p>
          A breathtaking oil painting capturing the warm glow of the setting sun
          over rolling hills. Perfect for nature lovers and art collectors.
        </p>
      </div>
    </div>
  </main>

  <!-- ORDER MODAL -->
  <div id="orderModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('orderModal')">&times;</span>
      <h2>Request Order</h2>
      <form>
        <label>Name:</label>
        <input type="text" placeholder="Enter your name" required />
        <label>Email:</label>
        <input type="email" placeholder="Enter your email" required />
        <label>Message:</label>
        <textarea placeholder="Request details..." required></textarea>
        <button type="submit" class="btn-submit">Send Request</button>
      </form>
    </div>
  </div>

  <!-- MESSAGE MODAL -->
  <div id="messageModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('messageModal')">&times;</span>
      <h2>Send Message to Artist</h2>
      <form>
        <label>Your Message:</label>
        <textarea placeholder="Type your message..." required></textarea>
        <button type="submit" class="btn-submit">Send Message</button>
      </form>
    </div>
  </div>
</body>
</html>