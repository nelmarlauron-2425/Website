<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Artist Dashboard - ArtTrack</title>
  <link rel="stylesheet" href="/style.css/commission.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
  />
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="left-header">
      <a href="artist_browser.php" class="back-btn"
        ><i class="fa-solid fa-arrow-left"></i
      ></a>
      <img src="images/logo.png" alt="Logo" class="logo" />
      <h1>ArtTrack</h1>
    </div>
    <div class="right-header">
      <img src="/images/user.webp" alt="Profile" class="profile-pic" />
    </div>
  </header>

  <!-- STATS SECTION -->
  <section class="stats">
    <div class="stat">
      <span>Active Commissions</span>
      <h3>3</h3>
    </div>
    <div class="stat">
      <span>Completed</span>
      <h3>12</h3>
    </div>
    <div class="stat">
      <span>Total Earnings</span>
      <h3>₱2,500</h3>
    </div>
    <div class="stat">
      <span>Avg. Rating</span>
      <h3>4.9</h3>
    </div>
  </section>

  <!-- QUICK ACTIONS -->
  <section class="quick-actions">
    <h3>Quick Actions</h3>
    <div class="action-buttons">
      <button>
        <i class="fa-solid fa-plus"></i> New Commission
      </button>
      <button>
        <i class="fa-solid fa-chart-line"></i> View Analytics
      </button>
      <button>
        <i class="fa-solid fa-message"></i> Message Clients
      </button>
    </div>
  </section>

  <!-- COMMISSIONS LIST -->
  <section class="commissions">
    <!-- Title + Filters -->
    <div class="commission-header">
      <h2>Active Commissions</h2>
      <div class="commission-filters">
        <button class="filter-btn">All</button>
        <button class="filter-btn">Not Started</button>
        <button class="filter-btn">In Progress</button>
        <button class="filter-btn">Done</button>
      </div>
    </div>

    <!-- Commission Card 1 -->
    <div class="commission-card">
      <div class="card-header">
        <div class="card-left">
          <h4>Fantasy Character Portrait</h4>
          <p>Client: Sarah Johnson</p>

          <div class="progress-container">
            <label class="progress-label">Progress</label>
            <div class="progress-bar">
              <div class="progress-fill" style="width: 70%;"></div>
            </div>
            <p class="due-date">Due: 1/15/2024</p>
          </div>
        </div>

        <div class="card-right">
          <div class="price">₱1100</div>
          <div class="progress-wrapper">
            <button class="progress-btn">
              In Progress <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="progress-menu">
              <div class="progress-option" data-status="Not Started">
                Not Started
              </div>
              <div class="progress-option" data-status="In Progress">
                In Progress
              </div>
              <div class="progress-option" data-status="Done">Done</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Commission Card 2 -->
    <div class="commission-card">
      <div class="card-header">
        <div class="card-left">
          <h4>Landscape Painting</h4>
          <p>Client: Mark Davis</p>

          <div class="progress-container">
            <label class="progress-label">Progress</label>
            <div class="progress-bar">
              <div class="progress-fill" style="width: 40%;"></div>
            </div>
            <p class="due-date">Due: 2/10/2024</p>
          </div>
        </div>

        <div class="card-right">
          <div class="price">₱1400</div>
          <div class="progress-wrapper">
            <button class="progress-btn">
              In Progress <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="progress-menu">
              <div class="progress-option" data-status="Not Started">
                Not Started
              </div>
              <div class="progress-option" data-status="In Progress">
                In Progress
              </div>
              <div class="progress-option" data-status="Done">Done</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- JS Script -->
  <script src="/javascript/commission.js"></script>
</body>
</html>
