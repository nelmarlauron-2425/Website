// ========== 🔹 BASIC MODAL HANDLERS ==========
function openModal(id) {
  document.getElementById(id).style.display = 'flex';
}
function closeModal(id) {
  document.getElementById(id).style.display = 'none';
}
function goToProfile() {
  window.location.href = "user_profile.php ";
}

// ========== 🔹 DYNAMIC ORDER MANAGEMENT ==========
function updateActiveOrders(change) {
  const activeCount = document.getElementById("activeCount");
  let current = parseInt(activeCount.innerText);
  current += change;
  if (current < 0) current = 0;
  activeCount.innerText = current;
}

// 🟩 Add new order (local only for now)
function addOrder() {
  const orderList = document.getElementById("orderList");
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
      <div class="progress-bar"><div class="progress-fill" style="width: 0%;"></div></div>
      <div class="progress-details">
        <p class="progress-text">Progress: 0%</p>
        <p class="due-date"><strong>Due:</strong> TBD</p>
      </div>
    </div>
    <div class="actions-right">
      <button class="blue" data-action="message"><i class="fa-solid fa-message"></i> Message</button>
      <button class="green" data-action="view"
        data-project="New Art Commission"
        data-artist="Pending Assignment"
        data-price="₱1,500"
        data-status="In Progress"
        data-progress="0%"
        data-image="">
        <i class="fa-solid fa-eye"></i> View
      </button>
      <button class="purple" data-action="payment"><i class="fa-solid fa-credit-card"></i> Payment</button>
      <button class="red" data-action="cancel"><i class="fa-solid fa-xmark"></i> Cancel</button>
    </div>
  `;
  orderList.appendChild(newOrder);
  updateActiveOrders(1);
  alert("✅ New order added successfully!");
}

// ========== 🔹 PAYMENT + MESSAGE + VIEW ==========
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
    alert("📨 Message sent successfully!");
    messageText.value = "";
    closeModal("messageModal");
  });
});

function openViewModal(button) {
  document.getElementById("viewProject").innerText = button.getAttribute("data-project");
  document.getElementById("viewArtist").innerText = button.getAttribute("data-artist");
  document.getElementById("viewPrice").innerText = button.getAttribute("data-price");
  document.getElementById("viewStatus").innerText = button.getAttribute("data-status");
  document.getElementById("viewProgress").innerText = button.getAttribute("data-progress");
  document.getElementById("viewImage").src = button.getAttribute("data-image");
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

// ========== 🔹 EVENT DELEGATION (FIX FOR BUTTONS) ==========
document.addEventListener("click", (event) => {
  const btn = event.target.closest("button");
  if (!btn) return;
  const action = btn.dataset.action;
  if (!action) return;

  switch (action) {
    case "message":
      openModal('messageModal');
      break;
    case "view":
      openViewModal(btn);
      break;
    case "payment":
      openModal('paymentModal');
      break;
    case "cancel":
      if (confirm("Are you sure you want to cancel this order?")) {
        const orderCard = btn.closest(".order-card");
        orderCard.remove();
        updateActiveOrders(-1);
        alert("❌ Order has been canceled.");
      }
      break;
  }
});

// ========== 🔹 CLICK OUTSIDE MODAL ==========
window.onclick = function (event) {
  document.querySelectorAll(".modal").forEach(modal => {
    if (event.target == modal) modal.style.display = "none";
  });
};

// ========== 🔹 LOAD BACKEND ORDERS ==========
async function loadOrders(buyerId = 1) {
  try {
    const response = await fetch(`/backend/user_purchase_backend.php?buyer_id=${buyerId}`);
    const data = await response.json();
    if (!data.success) return console.error("Failed to fetch:", data.error);

    const orderList = document.getElementById("orderList");

    data.orders.forEach(order => {
      const orderCard = document.createElement("div");
      orderCard.classList.add("order-card");
      orderCard.innerHTML = `
        <div class="order-header">
          <div class="title-status">
            <h3>${order.artwork_title}</h3>
            <span class="status">${order.status}</span>
          </div>
          <div class="order-info">
            <p><strong>Price:</strong> ₱${order.total_price}</p>
          </div>
        </div>
        <p class="artist">Artist: ${order.artist_name}</p>
        <div class="progress-section">
          <div class="progress-bar">
            <div class="progress-fill" style="width: ${order.status === "Completed" ? "100%" : "40%"};"></div>
          </div>
          <div class="progress-details">
            <p class="progress-text">Progress: ${order.status === "Completed" ? "100%" : "40%"}%</p>
            <p class="due-date"><strong>Due:</strong> ${order.due_date}</p>
          </div>
        </div>
        <div class="actions-right">
          <button class="blue" data-action="message"><i class="fa-solid fa-message"></i> Message</button>
          <button class="green" data-action="view"
            data-project="${order.artwork_title}"
            data-artist="${order.artist_name}"
            data-price="₱${order.total_price}"
            data-status="${order.status}"
            data-progress="${order.status === "Completed" ? "100%" : "40%"}"
            data-image="${order.artwork_image ? '/uploads/' + order.artwork_image : '/images/default_art.png'}">
            <i class="fa-solid fa-eye"></i> View
          </button>
          <button class="purple" data-action="payment"><i class="fa-solid fa-credit-card"></i> Payment</button>
          <button class="red" data-action="cancel"><i class="fa-solid fa-xmark"></i> Cancel</button>
        </div>
      `;
      orderList.appendChild(orderCard);
    });

    document.getElementById("activeCount").innerText =
      document.querySelectorAll(".order-card").length;
  } catch (err) {
    console.error("Error loading backend orders:", err);
  }
}

document.addEventListener("DOMContentLoaded", () => loadOrders(1));
