<style>
/* ================= GLOBAL CONFIG ================= */
:root {
    --sidebar-width: 240px;
    --sidebar-bg: #1f2a30;
    --topbar-bg: #f68b1f;
}

body { margin: 0; }

/* ================= DESKTOP (Default) ================= */
/* Sidebar is always visible and fixed */
.sidebar {
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    color: #fff;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 1002;
    overflow-y: auto;
    padding-top: 20px;
}

/* Page content always has a margin to account for the sidebar */
.page-container {
    margin-left: var(--sidebar-width);
    padding: 20px;
    transition: margin-left 0.3s ease;
}

/* Hide the toggle icon on desktop */
#menuIcon {
    display: none; 
}

.topbar {
    height: 55px;
    background: var(--topbar-bg);
    color: #fff;
    display: flex;
    align-items: center;
    padding: 0 20px;
    margin-left: var(--sidebar-width); /* Align topbar with content */
}

/* ================= MOBILE RESPONSIVE (Max 768px) ================= */
@media (max-width: 768px) {
    .sidebar {
        left: -240px; /* Hide sidebar off-screen */
        padding-top: 60px;
    }

    .page-container, .topbar {
        margin-left: 0; /* Content takes full width */
    }

    #menuIcon {
        display: inline-block; /* Show toggle button only on mobile */
        cursor: pointer;
        font-size: 20px;
        margin-right: 15px;
    }

    /* When toggled open on mobile */
    body.sidebar-open .sidebar {
        left: 0;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1001;
    }

    body.sidebar-open .sidebar-overlay {
        display: block;
    }
}

/* ... (Keep your existing Menu, Submenu, and Hover CSS here) ... */
</style>

<div class="topbar">
    <div class="topbar-left">
        <span id="menuIcon">☰</span>
        <span class="brand-name">FIRM SYSTEM</span>
    </div>
    <div class="topbar-right">
        User: <?= htmlspecialchars($firmName ?? 'Admin') ?>
    </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebar">
    </div>
    <ul class="menu">
        <h5>MAIN NAVIGATION</h5>
        <li><a href="dashboard.php">🏠 Dashboard</a></li>
        <li><a href="firm_creation.php">🏢 Firm Creation</a></li>

        <h5>MASTER DATA</h5>
        <div class="submenu">
            <span class="menu-toggle">⚙️ Administration</span>
            <ul class="submenu-list">
                <li><a href="party_master.php">Party Master</a></li>
                <li><a href="vehicle_master.php">Vehicle Master</a></li>
                <li><a href="city_master.php">City Master</a></li>
            </ul>
        </div>

        <h5>WORKFLOW</h5>
        <div class="submenu">
            <span class="menu-toggle">📝 Transaction</span>
            <ul class="submenu-list">
                <li><a href="booking_entry.php">Booking Entry</a></li>
                <li><a href="manifest.php">Manifest Entry</a></li>
            </ul>
        </div>
    </ul>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const menuIcon = document.getElementById('menuIcon');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const body = document.body;

    // Toggle Sidebar
    function toggleSidebar() {
        body.classList.toggle('sidebar-open');
        // Save state
        const isOpen = body.classList.contains('sidebar-open');
        localStorage.setItem('sidebar_state', isOpen ? 'open' : 'closed');
    }

    if (menuIcon) menuIcon.addEventListener('click', toggleSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);

    // Restore state from LocalStorage
    if (localStorage.getItem('sidebar_state') === 'open' && window.innerWidth > 768) {
        body.classList.add('sidebar-open');
    }

    // Submenu Accordion
    document.querySelectorAll(".menu-toggle").forEach(toggle => {
        toggle.addEventListener("click", function (e) {
            const currentSubmenu = this.parentElement;
            
            // Close others
            document.querySelectorAll(".submenu").forEach(item => {
                if (item !== currentSubmenu) item.classList.remove("active");
            });

            currentSubmenu.classList.toggle("active");
        });
    });
});
</script>

  