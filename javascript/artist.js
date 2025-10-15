document.addEventListener('DOMContentLoaded', () => {
    // ===================== Function: Update Countdown =====================
    function updateCountdown() {
        const now = new Date();
        document.querySelectorAll('.commission-card').forEach(card => {
            const dueDateStr = card.getAttribute('data-due');
            const countdownElement = card.querySelector('.countdown');

            if (!dueDateStr || !countdownElement) return; // Prevent errors

            const dueDate = new Date(dueDateStr);
            const timeLeft = dueDate - now;

            if (timeLeft > 0) {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                countdownElement.textContent =  (Time left: ${days}d ${hours}h ${minutes}m ${seconds}s);
            } else {
                countdownElement.textContent = ' (Overdue!)';
            }
        });
    }

    // Run every second
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // ===================== Logout Button =====================
    const logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', () => {
            alert('Logging out...');
            window.location.href = 'login.html';
        });
    }

    // ===================== New Commission Button =====================
    const newCommissionButton = document.getElementById('new-commission-button');
    if (newCommissionButton) {
        newCommissionButton.addEventListener('click', () => {
            const commissionsContainer = document.querySelector('.commissions');
            const activeCount = document.getElementById('active-commissions');

            if (!commissionsContainer || !activeCount) {
                alert('Error: Missing commission section.');
                return;
            }

            const newId = document.querySelectorAll('.commission-card').length + 1;
            const newDueDate = '2025-12-01T23:59:59'; // Example future date

            const newCommission = document.createElement('div');
            newCommission.className = 'commission-card';
            newCommission.dataset.id = newId;
            newCommission.dataset.due = newDueDate;
            newCommission.innerHTML = `
                <div class="card-header">
                    <h3>New Commission - ₱100</h3>
                    <span class="status">Not Started</span>
                </div>
                <p>Client: New Client</p>
                <p class="progress-label">Progress</p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 0%;"></div>
                </div>
                <p class="due">Due: 12/1/2025 <span class="countdown"></span></p>
                <div class="actions">
                    <button class="update-button" data-commission-id="${newId}">Update</button>
                    <button class="message-button" data-commission-id="${newId}">Message</button>
                </div>
            `;

            commissionsContainer.appendChild(newCommission);
            activeCount.textContent = parseInt(activeCount.textContent) + 1;

            alert('✅ New commission added!');
            addDynamicButtonListeners();
            updateCountdown();
        });
    }

    // ===================== View Analytics Button =====================
    const viewAnalyticsButton = document.getElementById('view-analytics-button');
    if (viewAnalyticsButton) {
        viewAnalyticsButton.addEventListener('click', () => {
            alert('📊 Analytics View:\nActive: 3\nCompleted: 12\nEarnings: ₱2,500\nRating: 4.9⭐');
        });
    }

    // ===================== Message Clients Button =====================
    const messageClientsButton = document.getElementById('message-clients-button');
    if (messageClientsButton) {
        messageClientsButton.addEventListener('click', () => {
            const message = prompt('Enter message for clients:');
            if (message) {
                alert('📩 Message sent: ' + message);
            }
        });
    }

    // ===================== Add Button Listeners =====================
    function addDynamicButtonListeners() {
        document.querySelectorAll('.update-button').forEach(button => {
            if (!button.dataset.listenerAdded) {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-commission-id');
                    const newProgress = prompt('Enter new progress (Not Started / In Progress / Completed):');

                    if (newProgress) {
                        const card = document.querySelector(.commission-card[data-id="${id}"]);
                        if (!card) return;

                        const status = card.querySelector('.status');
                        const progress = card.querySelector('.progress-fill');
                        status.textContent = newProgress;

                        if (newProgress === 'In Progress') progress.style.width = '50%';
                        else if (newProgress === 'Completed') progress.style.width = '100%';
                        else progress.style.width = '0%';

                        alert('✅ Progress updated!');
                    }
                });
                button.dataset.listenerAdded = 'true';
            }
        });

        document.querySelectorAll('.message-button').forEach(button => {
            if (!button.dataset.listenerAdded) {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-commission-id');
                    const message = prompt(Enter message for commission ${id}:);
                    if (message) {
                        alert(💬 Message sent for commission ${id}: ${message});
                    }
                });
                button.dataset.listenerAdded = 'true';
            }
        });
    }

    // Initial listener setup
    addDynamicButtonListeners();
});