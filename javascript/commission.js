// Toggle dropdown visibility for all buttons
document.querySelectorAll('.progress-btn').forEach(button => {
  button.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent the document click handler from closing the dropdown immediately

    const menu = button.nextElementSibling;

    // Close all other dropdowns except this one
    document.querySelectorAll('.progress-menu').forEach(m => {
      if (m !== menu) m.classList.remove('show');
    });

    // Toggle current dropdown
    menu.classList.toggle('show');
  });
});

// Close dropdowns when clicking outside anywhere
document.addEventListener('click', () => {
  document.querySelectorAll('.progress-menu').forEach(menu => {
    menu.classList.remove('show');
  });
});

// Handle option selection for all progress options
document.querySelectorAll('.progress-option').forEach(option => {
  option.addEventListener('click', () => {
    const wrapper = option.closest('.progress-wrapper');
    const btn = wrapper.querySelector('.progress-btn');
    const selectedStatus = option.dataset.status;

    // Update button label with icon
    btn.innerHTML = `${selectedStatus} <i class="fa-solid fa-chevron-down"></i>`;

    // Map status to colors
    const colorMap = {
      "Not Started": "red",
      "In Progress": "#FFD54F", // amber/yellow
      "Done": "green",
    };

    // Update background color
    btn.style.backgroundColor = colorMap[selectedStatus] || "gray";

    // Close dropdown menu
    wrapper.querySelector('.progress-menu').classList.remove('show');
  });
});
