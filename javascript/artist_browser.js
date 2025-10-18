const API_URL = "api/buyerbrowser_backend.php";

const searchInput = document.getElementById("searchBar");
const searchBtn = document.getElementById("searchBtn");
const applyPriceBtn = document.getElementById("applyPrice");
const clearAllBtn = document.getElementById("clearAll");
const minPriceInput = document.getElementById("minPrice");
const maxPriceInput = document.getElementById("maxPrice");
const filterInputs = document.querySelectorAll(".filter");

// ✅ Gather filters
function getFilters() {
  const filters = {};

  // Search
  const search = searchInput?.value.trim();
  if (search) filters.search = search.toLowerCase();

  // Checkbox filters
  ["category", "medium", "subject", "size", "material"].forEach((type) => {
    const selected = Array.from(
      document.querySelectorAll(`.filter[data-filter="${type}"]:checked`)
    ).map((el) => el.value);
    if (selected.length > 0) filters[type] = selected;
  });

  // Price range
  const minPrice = parseFloat(minPriceInput?.value) || null;
  const maxPrice = parseFloat(maxPriceInput?.value) || null;
  if (minPrice) filters.minPrice = minPrice;
  if (maxPrice) filters.maxPrice = maxPrice;

  return filters;
}

// ✅ Apply filters to the visible DOM cards (don’t remove)
function applyLocalFilters(filters) {
  const cards = document.querySelectorAll(".art-card");

  cards.forEach((card) => {
    const title = card.querySelector("h3").textContent.toLowerCase();
    const category = card.dataset.category;
    const medium = card.dataset.medium;
    const subject = card.dataset.subject;
    const size = card.dataset.size;
    const material = card.dataset.material;
    const price = parseFloat(card.dataset.price);

    let visible = true;

    // Search filter
    if (filters.search && !title.includes(filters.search)) visible = false;

    // Category / Medium / Subject / Size / Material
    if (filters.category && !filters.category.includes(category)) visible = false;
    if (filters.medium && !filters.medium.includes(medium)) visible = false;
    if (filters.subject && !filters.subject.includes(subject)) visible = false;
    if (filters.size && !filters.size.includes(size)) visible = false;
    if (filters.material && !filters.material.includes(material)) visible = false;

    // Price range
    if (filters.minPrice && price < filters.minPrice) visible = false;
    if (filters.maxPrice && price > filters.maxPrice) visible = false;

    // Show or hide
    card.style.display = visible ? "block" : "none";
  });
}

// ✅ Optional backend sync (for future use)
async function fetchBackend(filters) {
  const params = new URLSearchParams();

  if (filters.search) params.append("search", filters.search);
  if (filters.minPrice) params.append("minPrice", filters.minPrice);
  if (filters.maxPrice) params.append("maxPrice", filters.maxPrice);

  ["category", "medium", "subject", "size", "material"].forEach((type) => {
    if (filters[type]?.length) params.append(type, filters[type].join(","));
  });

  try {
    const res = await fetch(`${API_URL}?${params.toString()}`);
    const data = await res.json();
    console.log("Backend synced:", data);
  } catch (err) {
    console.error("Backend fetch failed:", err);
  }
}

// ✅ Apply all filters (frontend + backend)
function applyAllFilters() {
  const filters = getFilters();
  applyLocalFilters(filters);
  fetchBackend(filters);
}

// ✅ Event Listeners
searchBtn?.addEventListener("click", applyAllFilters);
searchInput?.addEventListener("keyup", (e) => {
  if (e.key === "Enter") applyAllFilters();
});

filterInputs.forEach((f) => f.addEventListener("change", applyAllFilters));
applyPriceBtn?.addEventListener("click", applyAllFilters);

clearAllBtn?.addEventListener("click", () => {
  document.querySelectorAll(".filter").forEach((f) => (f.checked = false));
  minPriceInput.value = "";
  maxPriceInput.value = "";
  searchInput.value = "";
  applyAllFilters();
});

// ✅ Initial load
window.addEventListener("DOMContentLoaded", () => {
  applyAllFilters();
});
