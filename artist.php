<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtTrack Dashboard</title>
    <link rel="stylesheet" href="../styles.css/artist.css"> <!-- Make sure this path is correct -->
    <script src="script.js" defer></script>
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <div class="left-header">
            <button class="back-btn">←</button>
            <div class="logo-section">
                <img src="logo.png" alt="Logo" class="logo">
                <span>ArtTrack</span>
            </div>
        </div>
        <h1>Artist Dashboard</h1>
        <div class="nav-buttons">
            <button id="logout-button">Logout</button>
        </div>
    </header>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stat"><h3>Active Commissions: <span id="active-commissions">3</span></h3></div>
        <div class="stat"><h3>Completed: <span id="completed">12</span></h3></div>
        <div class="stat"><h3>Total Earnings: <span id="total-earnings">$2,500</span></h3></div>
        <div class="stat"><h3>Avg. Rating: <span id="avg-rating">4.9</span></h3></div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <h3>Quick Actions</h3>
        <div class="buttons">
            <button id="new-commission-button">+ New Commission</button>
            <button id="view-analytics-button">View Analytics</button>
            <button id="message-clients-button">Message Clients</button>
        </div>
    </section>

    <!-- Active Commissions -->
    <section class="commissions">
        <h2>Active Commissions</h2>

        <!-- Commission Card 1 -->
        <div class="commission-card" data-id="1" data-due="2024-01-15T23:59:59">
            <div class="card-header">
                <h3>Fantasy Character Portrait - $150</h3>
                <span class="status">In Progress</span>
            </div>
            <p>Client: Sarah Johnson</p>
            <p class="progress-label">Progress</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 50%;"></div>
            </div>
            <p class="due">Due: 1/15/2024 <span class="countdown" id="countdown-1"></span></p>
            <div class="actions">
                <button class="update-button" data-commission-id="1">Update</button>
                <button class="message-button" data-commission-id="1">Message</button>
            </div>
        </div>

        <!-- Commission Card 2 -->
        <div class="commission-card" data-id="2" data-due="2024-01-15T23:59:59">
            <div class="card-header">
                <h3>Logo Design for Startup - $300</h3>
                <span class="status">In Progress</span>
            </div>
            <p>Client: Mike Chen</p>
            <p class="progress-label">Progress</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 50%;"></div>
            </div>
            <p class="due">Due: 1/15/2024 <span class="countdown" id="countdown-2"></span></p>
            <div class="actions">
                <button class="update-button" data-commission-id="2">Update</button>
                <button class="message-button" data-commission-id="2">Message</button>
            </div>
        </div>

    </section>

</body>
</html>
