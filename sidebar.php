

<style>
/* ================= GLOBAL ADJUSTMENTS ================= */
:root {
    --sidebar-width: 240px;
    --sidebar-bg: #1f2a30;
    --topbar-bg: #f68b1f;
}

/* Ensure the main content shifts when sidebar is present on Desktop */
body.sidebar-open .page-container {
    margin-left: var(--sidebar-width);
}

.page-container {
    transition: margin-left 0.3s ease;
    padding: 20px;
}

/* ================= TOP BAR ================= */
.topbar {
    height: 55px;
    background: var(--topbar-bg);
    color: #fff;
    display: flex;
    align-items: center;
    padding: 0 20px;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 1001;
}

.topbar-left {
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ================= SIDEBAR ================= */
.sidebar {
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    color: #fff;
    height: 100vh;
    position: fixed;
    left: calc(-1 * var(--sidebar-width)); /* Hidden by default */
    top: 0;
    transition: left 0.3s ease;
    z-index: 1002;
    overflow-y: auto;
    padding-top: 60px; /* Space for topbar */
}

/* Show Sidebar when active */
body.sidebar-open .sidebar {
    left: 0;
}

.sidebar-header {
    padding: 15px;
    border-bottom: 1px solid #333;
}

.menu {
    padding: 10px;
    list-style: none;
}

.menu h5 {
    font-size: 11px;
    color: #888;
    margin: 15px 0 5px 10px;
    text-transform: uppercase;
}

.menu a, .menu-toggle {
    display: block;
    padding: 12px 15px;
    color: #d1d1d1;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
}

.menu a:hover, .menu-toggle:hover {
    background: #2f3f46;
    color: #fff;
}

/* ================= SUBMENU LOGIC ================= */
.submenu-list {
    display: none;
    list-style: none;
    padding-left: 15px;
    background: #182226;
}

.submenu.active .submenu-list {
    display: block;
}

.menu-toggle::after {
    content: "▶";
    float: right;
    font-size: 10px;
    margin-top: 3px;
    transition: transform 0.3s;
}

.submenu.active .menu-toggle::after {
    transform: rotate(90deg);
}

/* ================= MOBILE OVERLAY ================= */
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

@media (min-width: 769px) {
    .sidebar-overlay { display: none !important; }
}

@media (max-width: 768px) {
    body.sidebar-open .page-container {
        margin-left: 0; /* Don't shift content on mobile, just overlay */
    }
}
</style>

<div class="topbar">
    <div class="topbar-left">
        <span id="menuIcon" style="cursor: pointer; font-size: 20px;">☰</span>
        <span>HOME</span>
    </div>
    <div class="topbar-right">
        <span>User: <?= htmlspecialchars($firmName ?? 'Guest') ?></span>
        <a href="logout.php" style="color:white; text-decoration:none; margin-left:15px;">Logout</a>
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

  