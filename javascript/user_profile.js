document.addEventListener('DOMContentLoaded', () => {
  
  function showTab(tabId, event) {
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => tab.classList.remove('active'));
    contents.forEach(content => content.classList.remove('active'));

    document.getElementById(tabId).classList.add('active');
    event.currentTarget.classList.add('active');
  }

  const editBtn = document.querySelector('.white-btn:nth-child(1)');
  const logoutBtn = document.querySelector('.white-btn:nth-child(2)');

  editBtn.addEventListener('click', () => {
    alert('Edit Profile..');
  });

  logoutBtn.addEventListener('click', () => {
    alert('Logging out...');
  });

  document.querySelectorAll('.follow-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      if (btn.textContent === 'Follow') {
        btn.textContent = 'Following';
        btn.style.background = '#800000';
        btn.style.color = 'white';
      } else {
        btn.textContent = 'Follow';
        btn.style.background = 'white';
        btn.style.color = '#800000';
      }
    });
  });

  const backBtn = document.querySelector('.back-btn');
  if (backBtn) {
    backBtn.addEventListener('click', () => {
      window.location.href = 'buyer_browser.php';
    });
  }

});