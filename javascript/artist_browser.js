// ❤️ Heart Like Button
document.querySelectorAll(".heart-btn").forEach(btn => {
  btn.addEventListener("click", () => {
    btn.classList.toggle("liked");
    const icon = btn.querySelector("i");
    if (icon) {
      icon.classList.toggle("fa-regular");
      icon.classList.toggle("fa-solid");
    }
  });
});

// 🔍 Search + Filter System
const searchBar = document.getElementById("searchBar");
const searchBtn = document.getElementById("searchBtn");
const artCards = document.querySelectorAll(".art-card");

function applyFilters() {
  const query = searchBar.value.toLowerCase();
  const min = parseFloat(document.getElementById("minPrice").value) || 0;
  const max = parseFloat(document.getElementById("maxPrice").value) || Infinity;
  const selectedFilters = Array.from(document.querySelectorAll(".filter:checked")).map(cb => cb.value);

  artCards.forEach(card => {
    const title = card.querySelector("h3").textContent.toLowerCase();
    const price = parseFloat(card.dataset.price);
    const attributes = Object.values(card.dataset);
    const matchQuery = title.includes(query);
    const matchPrice = price >= min && price <= max;
    const matchFilter = selectedFilters.length === 0 || selectedFilters.some(f => attributes.includes(f));
    card.style.display = (matchQuery && matchPrice && matchFilter) ? "block" : "none";
  });
}

searchBtn.addEventListener("click", applyFilters);
document.getElementById("applyPrice").addEventListener("click", applyFilters);
document.querySelectorAll(".filter").forEach(cb => cb.addEventListener("change", applyFilters));

// 🧹 Clear All
document.getElementById("clearAll").addEventListener("click", () => {
  document.querySelectorAll(".filter").forEach(cb => (cb.checked = false));
  document.getElementById("minPrice").value = "";
  document.getElementById("maxPrice").value = "";
  document.getElementById("searchBar").value = "";
  artCards.forEach(card => (card.style.display = "block"));
});

// 🧭 Navigation Buttons
document.getElementById("aboutBtn").addEventListener("click", () => {
  alert("🎨 Welcome to Art Gallery — showcasing creative works from artists worldwide!");
});

document.getElementById("contactBtn").addEventListener("click", () => {
  alert("📩 Contact us: artgalleryofficial@gmail.com");
});

// 👤 Profile Button → Go to Dashboard
document.getElementById("profileBtn").addEventListener("click", () => {
  window.location.href = "USER DASHBOARD/USERDASHBOARD.html"; // update path if needed
});