<style>
/* ================= GLOBAL CONFIG ================= */
:root {
    --sidebar-width: 100px;
    --sidebar-bg: #1f2a30;
    --topbar-bg: #f68b1f;
    --transition-speed: 0.3s;
}

body { margin: 0; font-family: sans-serif; }

/* ================= DESKTOP (Fixed) ================= */
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



.page-container {
    padding: 75px 20px 20px 20px; /* Top padding to clear fixed topbar */
    margin-left: var(--sidebar-width);
}

#menuIcon { display: none; }

/* ================= MOBILE RESPONSIVE (Max 768px) ================= */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%); /* Move off-screen */
        transition: transform var(--transition-speed) ease;
        left: 0;
    }

    .topbar {
        left: 0; /* Full width on mobile */
    }

    .page-container {
        margin-left: 0;
    }

    #menuIcon {
        display: inline-block;
        cursor: pointer;
        font-size: 24px;
        margin-right: 15px;
    }

    /* Open State */
    body.sidebar-open .sidebar {
        transform: translateX(0);
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

/* Basic Submenu Styling (Ensure these exist in your CSS) */
.submenu-list { display: none; list-style: none; padding-left: 20px; }
.submenu.active .submenu-list { display: block; }
.menu-toggle { cursor: pointer; display: block; padding: 10px; }
.menu { list-style: none; padding: 0; }
.menu h5 { padding: 10px 20px; opacity: 0.6; font-size: 0.8rem; margin: 0; }
.menu a { color: white; text-decoration: none; display: block; padding: 10px 20px; }
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

<div class="page-container">
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

  