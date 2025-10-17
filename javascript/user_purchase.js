function openModal(id) { 
  document.getElementById(id).style.display = 'flex'; 
}

function closeModal(id) { 
  document.getElementById(id).style.display = 'none'; 
}

function logout() {
  alert("You have been logged out!");
  window.location.href = "login.html";
}

// 🟥 Cancel Order Function
function cancelOrder(button) {
  if (confirm("Are you sure you want to cancel this order?")) {
    const orderCard = button.closest(".order-card");
    orderCard.remove();
    updateActiveOrders(-1);
    alert("Order has been canceled.");
  }
}

// 🟩 Add Order Function
function addOrder() {
  const orderList = document.getElementById("orderList");

  // New order card structure (same as existing)
  const newOrder = document.createElement("div");
  newOrder.classList.add("order-card");

  newOrder.innerHTML = `
    <div class="order-header">
      <div class="title-status">
        <h3>New Art Commission</h3>
        <span class="status">In Progress</span>
      </div>
      <div class="order-info">
        <p><strong>Price:</strong> ₱1,500</p>
      </div>
    </div>
    <p class="artist">Artist: Pending Assignment</p>

    <div class="progress-section">
      <div class="progress-bar">
        <div class="progress-fill" style="width: 0%;"></div>
      </div>
      <div class="progress-details">
        <p class="progress-text">Progress: 0%</p>
        <p class="due-date"><strong>Due:</strong> TBD</p>
      </div>
    </div>

    <div class="actions-right">
      <button class="blue" onclick="openModal('messageModal')">
        <i class="fa-solid fa-message"></i> Message
      </button>
      <button class="green"
        onclick="openViewModal(this)"
        data-project="New Art Commission"
        data-artist="Pending Assignment"
        data-price="₱1,500"
        data-status="In Progress"
        data-progress="0%"
        data-image="">
        <i class="fa-solid fa-eye"></i> View
      </button>
      <button class="purple" onclick="openModal('paymentModal')">
        <i class="fa-solid fa-credit-card"></i> Payment
      </button>
      <button class="red" onclick="cancelOrder(this)">
        <i class="fa-solid fa-xmark"></i> Cancel
      </button>
    </div>
  `;

  // Append to order list
  orderList.appendChild(newOrder);

  // Update Active Orders count
  const activeCount = document.querySelectorAll(".order-card").length;
  document.getElementById("activeCount").innerText = activeCount;

  alert("✅ New order added successfully!");
}


  // Create new order element
  const newOrder = document.createElement("div");
  newOrder.classList.add("order-card");
  newOrder.innerHTML = `
    <div class="order-header">
      <div class="title-status">
        <h3>New Custom Order</h3>
        <span class="status">In Progress</span>
      </div>
      <div class="order-info">
        <p><strong>Price:</strong> ₱1,000</p>
      </div>
    </div>
    <p class="artist">Artist: Unknown</p>
    <div class="progress-section">
      <div class="progress-bar"><div class="progress-fill" style="width: 0%;"></div></div>
      <div class="progress-details">
        <p class="progress-text">Progress: 0%</p>
        <p class="due-date"><strong>Due:</strong> TBD</p>
      </div>
    </div>
    <div class="actions-right">
      <button class="blue" onclick="openModal('messageModal')">
        <i class="fa-solid fa-message"></i> Message
      </button>
      <button class="green" onclick="openViewModal(this)"
        data-project="New Custom Order"
        data-artist="Unknown"
        data-price="₱1,000"
        data-status="In Progress"
        data-progress="0%"
        data-image="">
        <i class="fa-solid fa-eye"></i> View
      </button>
      <button class="purple" onclick="openModal('paymentModal')">
        <i class="fa-solid fa-credit-card"></i> Payment
      </button>
      <button class="red" onclick="cancelOrder(this)">
        <i class="fa-solid fa-xmark"></i> Cancel
      </button>
    </div>
  `;

  // Add to page
  orderList.appendChild(newOrder);

  // Update active order count
  const activeCount = document.querySelectorAll(".order-card").length;
  document.getElementById("activeCount").innerText = activeCount;


// 🟦 Update Active Orders Counter
function updateActiveOrders(change) {
  const activeCount = document.getElementById("activeCount");
  let current = parseInt(activeCount.innerText);
  current += change;
  if (current < 0) current = 0;
  activeCount.innerText = current;
}

// 🟨 Payment + View Modal Scripts
function showPaymentOptions(type) {
  const onlineSection = document.getElementById("onlineOptions");
  onlineSection.style.display = type === 'online' ? "block" : "none";
}

let selectedOnlinePayment = null;
let selectedPaymentLink = null;

document.addEventListener("DOMContentLoaded", () => {
  const payOptions = document.querySelectorAll(".pay-option");
  payOptions.forEach(option => {
    option.addEventListener("click", () => {
      payOptions.forEach(o => o.classList.remove("selected"));
      option.classList.add("selected");
      selectedOnlinePayment = option.querySelector("span").innerText;
      selectedPaymentLink = option.getAttribute("data-link");
    });
  });

  const sendBtn = document.querySelector(".send-btn");
  const messageText = document.getElementById("messageText");
  sendBtn.addEventListener("click", () => {
    const msg = messageText.value.trim();
    if (msg === "") {
      alert("Please type a message before sending.");
      return;
    }
    alert("Message sent successfully!");
    messageText.value = "";
    closeModal("messageModal");
  });
});

function openViewModal(button) {
  const project = button.getAttribute("data-project");
  const artist = button.getAttribute("data-artist");
  const price = button.getAttribute("data-price");
  const status = button.getAttribute("data-status");
  const progress = button.getAttribute("data-progress");
  const image = button.getAttribute("data-image");

  document.getElementById("viewProject").innerText = project;
  document.getElementById("viewArtist").innerText = artist;
  document.getElementById("viewPrice").innerText = price;
  document.getElementById("viewStatus").innerText = status;
  document.getElementById("viewProgress").innerText = progress;
  document.getElementById("viewImage").src = image;

  openModal('viewModal');
}

function confirmPayment() {
  const selected = document.querySelector('input[name="paymentType"]:checked');
  if (!selected) {
    alert("Please select a payment method first.");
    return;
  }

  if (selected.value === "cod") {
    alert("✅ Cash on Delivery selected. Please prepare payment upon delivery.");
    closeModal('paymentModal');
    return;
  }

  if (!selectedOnlinePayment || !selectedPaymentLink) {
    alert("Please select GCash, PayMaya, or BPI before proceeding.");
    return;
  }

  alert(`✅ Redirecting you to ${selectedOnlinePayment}...`);
  window.open(selectedPaymentLink, "_blank");
  closeModal('paymentModal');
}

window.onclick = function(event) {
  document.querySelectorAll('.modal').forEach(modal => {
    if (event.target == modal) modal.style.display = "none";
  });
};
function goToProfile() {
  window.location.href = "profile.html";
}