<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard - ArtTrack</title>
  <link rel="stylesheet" href="style.css/user.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <style>
    .add-order-btn {
      margin: 20px 0;
      background: #800000;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="left-header">
      <button class="back-btn" onclick="history.back()">
        <i class="fa-solid fa-arrow-left"></i>
      </button>
      <img src="CC_20250930_211854.png" alt="Logo" class="logo" />
      <h1>ArtTrack</h1>
    </div>
    <nav class="nav-buttons">
      <button class="dashboard-btn">User Dashboard</button>
      <button class="logout-btn" onclick="logout()">Logout</button>
    </nav>
  </header>

  <!-- Stats -->
  <section class="stats">
    <div class="stat">
      <span>Active Orders</span>
      <h3 id="activeCount">2</h3>
    </div>
    <div class="stat">
      <span>Completed</span>
      <h3>8</h3>
    </div>
    <div class="stat">
      <span>Total Spent</span>
      <h3>$1,200</h3>
    </div>
    
  </section>

  
   <section class="orders" id="orderList">
  <div class="orders-header">
    <h2>My Orders</h2>
    <button class="add-order-btn" onclick="addOrder()">
      <i class="fa-solid fa-plus"></i> Add Order
    </button>
  </div>

  <!-- Existing Order Cards -->
  <div class="order-card">
    <div class="order-header">
      <div class="title-status">
        <h3>Custom Character Design</h3>
        <span class="status">In Progress</span>
      </div>
      <div class="order-info">
        <p><strong>Price:</strong> ₱25,034</p>
      </div>
    </div>
    <p class="artist">Artist: Maya Smith</p>

    <div class="progress-section">
      <div class="progress-bar">
        <div class="progress-fill" style="width: 45%;"></div>
      </div>
      <div class="progress-details">
        <p class="progress-text">Progress: 45%</p>
        <p class="due-date"><strong>Due:</strong> 9/30/2025</p>
      </div>
    </div>

    <div class="actions-right">
      <button class="blue" onclick="openModal('messageModal')">
        <i class="fa-solid fa-message"></i> Message
      </button>
      <button class="green"
        onclick="openViewModal(this)"
        data-project="Custom Character Design"
        data-artist="Maya Smith"
        data-price="₱25,034"
        data-status="In Progress"
        data-progress="45%"
        data-image="532824826_122108575310965607_162360980821454380_n.jpg">
        <i class="fa-solid fa-eye"></i> View
      </button>
      <button class="purple" onclick="openModal('paymentModal')">
        <i class="fa-solid fa-credit-card"></i> Payment
      </button>
      <button class="red" onclick="cancelOrder(this)">
        <i class="fa-solid fa-xmark"></i> Cancel
      </button>
    </div>
  </div>

  <div class="order-card">
    <div class="order-header">
      <div class="title-status">
        <h3>Wedding Portrait</h3>
        <span class="status">In Progress</span>
      </div>
      <div class="order-info">
        <p><strong>Price:</strong> ₱250</p>
      </div>
    </div>
    <p class="artist">Artist: Maya Smith</p>

    <div class="progress-section">
      <div class="progress-bar">
        <div class="progress-fill" style="width: 20%;"></div>
      </div>
      <div class="progress-details">
        <p class="progress-text">Progress: 20%</p>
        <p class="due-date"><strong>Due:</strong> 10/15/2025</p>
      </div>
    </div>

    <div class="actions-right">
      <button class="blue" onclick="openModal('messageModal')">
        <i class="fa-solid fa-message"></i> Message
      </button>
      <button class="green"
        onclick="openViewModal(this)"
        data-project="Wedding Portrait"
        data-artist="Maya Smith"
        data-price="₱250"
        data-status="In Progress"
        data-progress="20%"
        data-image="540395309_122113688798965607_5159981669031332998_n.jpg">
        <i class="fa-solid fa-eye"></i> View
      </button>
      <button class="purple" onclick="openModal('paymentModal')">
        <i class="fa-solid fa-credit-card"></i> Payment
      </button>
      <button class="red" onclick="cancelOrder(this)">
        <i class="fa-solid fa-xmark"></i> Cancel
      </button>
    </div>
  </div>
</section>


  
  <div id="messageModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('messageModal')">&times;</span>
      <h2>Message Artist</h2>
      <textarea id="messageText" placeholder="Type your message here..."></textarea>
      <button class="send-btn">Send</button>
    </div>
  </div>

  <!-- VIEW MODAL -->
  <div id="viewModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('viewModal')">&times;</span>
      <h2>Order Details</h2>
      <p><strong>Project:</strong> <span id="viewProject"></span></p>
      <p><strong>Artist:</strong> <span id="viewArtist"></span></p>
      <p><strong>Price:</strong> <span id="viewPrice"></span></p>
      <p><strong>Status:</strong> <span id="viewStatus"></span></p>
      <p><strong>Progress:</strong> <span id="viewProgress"></span></p>
      <img id="viewImage" src="" alt="Artwork Preview" class="portrait-img">
    </div>
  </div>

  <div id="paymentModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('paymentModal')">&times;</span>
      <h2>Select Payment Method</h2>
      <div class="payment-options">
        <label><input type="radio" name="paymentType" value="cod" onclick="showPaymentOptions('cod')"> Cash on Delivery</label>
        <label><input type="radio" name="paymentType" value="online" onclick="showPaymentOptions('online')"> Online Payment</label>
      </div>

      <div id="onlineOptions" class="online-options" style="display: none;">
        <p>Select your online payment:</p>
        <div class="payment-icons">
          <div class="pay-option" data-link="https://www.gcash.com/"><img src="GCash-Logo.png" alt="GCash"><span>GCash</span></div>
          <div class="pay-option" data-link="https://www.maya.ph/"><img src="PayMaya-Logo_Vertical.png" alt="PayMaya"><span>PayMaya</span></div>
          <div class="pay-option" data-link="https://www.bpi.com.ph/"><img src="Bpi-Bank-Of-The-Philippine-Islands-Logo-Vector.svg-.png" alt="BPI"><span>BPI</span></div>
        </div>
      </div>

      <button class="pay-btn" onclick="confirmPayment()"><i class="fa-solid fa-credit-card"></i> Confirm Payment</button>
    </div>
  </div>

  <script src="script.js"></script>

</body>
</html>