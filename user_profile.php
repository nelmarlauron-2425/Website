<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile - ArtTrack</title>
  <link rel="stylesheet" href="/style.css/user_profile.css" />
</head>
<body>

  <nav class="navbar">
  <button class="back-btn" onclick="window.history.back()">←</button>
  <div class="logo">
    <img src="/images/Logo.png" alt="Logo" class="logo-img">
    <span>ArtTrack</span>
  </div>
</nav>

  <div class="profile-container">
    <div class="profile-header">
      <div class="profile-pic">
        <img id="profile-img" src="/images/user.webp" alt="Profile Picture"/>
      </div>
      <div class="profile-info">
        <h2>Carl Ranges</h2>
        <p class="email">carlranges@gmail.com</p>
        <p class="details">📅 Joined March 2023 | 📍 Manila, Philippines</p>
        <p class="bio">Art enthusiast and collector. Passionate about supporting local Filipino artists.</p>
        <div class="stats">
          <span><strong id="following-count">1</strong> Following</span>
          <span><strong id="liked-count">1</strong> Liked Artworks</span>
          <span><strong id="collections-count">2</strong> Collections</span>
        </div>
      </div>
      <div class="profile-actions">
        <button class="white-btn" id="edit-profile-btn">Edit Profile</button>
        <button class="white-btn" id="logout-btn">Logout</button>
      </div>
    </div>

    <div class="tabs">
      <button class="tab active" onclick="showTab('recent', event)">Recent Activity</button>
      <button class="tab" onclick="showTab('liked', event)">Liked Artworks</button>
      <button class="tab" onclick="showTab('following', event)">Following</button>
      <button class="tab" onclick="showTab('collections', event)">Collections</button>
    </div>

    <div class="tab-content active" id="recent">
              <div class="activity-card">
        <p><strong>Started following</strong> Ana Reyes</p>
        <span>1 day ago</span>
      </div>
      <div class="activity-card">
        <p><strong>Liked</strong> 'Abstract Serenity' by Ana Reyes</p>
        <span>3 days ago</span>
      </div>
    </div>


    <div class="tab-content" id="liked">
      <p>You liked Ana Reyes Work.</p>
    </div>
        
    <div class="tab-content" id="following">
      <div class="activity-card">
        <p><strong>Ana Reyes</strong></p>
        <span>Follower</span>
      </div>
      </div>

    <div class="tab-content" id="collections">
      <p>You have 2 collections.</p>
    </div>
  </div>

  <script src="/javascript/user_profile.js"></script>
</body>
</html>