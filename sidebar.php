

<style>
* { box-sizing: border-box; font-family: Arial, sans-serif; }

body {
    margin: 0;
    background: #f2f5ff;
}

/* ================= TOP BAR ================= */
.topbar {
    height: 55px;
    background: #f68b1f;
    color: #fff;
    display: flex;
    align-items: center;
    padding: 0 20px;
    justify-content: space-between;
}

.topbar-left {
    font-weight: bold;
}

.topbar-right {
    font-size: 14px;
}

.topbar-right a {
    color: #fff;
    margin-left: 15px;
    text-decoration: none;
}

/* ================= LAYOUT ================= */
.container {
    display: flex;
}

/* ================= SIDEBAR ================= */
.sidebar {
    width: 240px;
    background: #1f2a30;
    color: #fff;
    min-height: calc(100vh - 55px);
}

.sidebar-header {
    padding: 15px;
    border-bottom: 1px solid #333;
}

.sidebar-header h4 {
    margin: 5px 0;
}

.menu {
    padding: 10px;
}

.menu h5 {
    font-size: 12px;
    color: #aaa;
    margin-bottom: 10px;
}

.menu a {
    display: block;
    padding: 10px;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 5px;
}

.menu a:hover {
    background: #2f3f46;
}

.quick-links a {
    background: #fff;
    color: red;
    font-weight: bold;
    margin-top: 10px;
    text-align: center;
}

/* ================= MAIN CONTENT ================= */
.main {
    flex: 1;
    padding: 20px;
}

.title {
    text-align: center;
    color: #ff6b6b;
    font-weight: bold;
    margin-bottom: 20px;
}

/* ================= DASHBOARD TILES ================= */
.tiles {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.tile {
    background: #fff;
    border-radius: 5px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.icon {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #fff;
}

.blue { background: #4aa3df; }
.green { background: #2ecc71; }
.gray { background: #bdc3c7; }
.orange { background: #f39c12; }
.yellow { background: #f1c40f; }
.purple { background: #8e7cff; }

.tile-text {
    padding: 15px;
    font-size: 14px;
    font-weight: bold;
}

/* ================= REMINDERS ================= */
.reminders {
    background: #fff;
    margin-top: 25px;
    padding: 20px;
    border-radius: 5px;
}

.reminder-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.reminders h4 {
    color: blue;
    margin-bottom: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #f1c232;
    padding: 8px;
    font-size: 13px;
}

td {
    padding: 6px;
    font-size: 13px;
    border-bottom: 1px solid #ddd;
}
/* ================= MENU TOGGLE ================= */
.submenu-list {
  display: none;
  padding-left: 15px;
}

.submenu.active > .submenu-list {
  display: block;
}

.menu-toggle {
  cursor: pointer;
  display: block;
  padding: 10px;
  font-weight: bold;
}

.menu-toggle::after {
  content: " ▶";
  float: right;
  font-size: 11px;
}

.submenu.active > .menu-toggle::after {
  content: " ▼";
}
/* 1. Ensure the container can wrap on mobile */
.container {
    display: flex;
    flex-wrap: nowrap; /* Keep desktop as is */
}

/* 2. Responsive adjustments */
/* 1. Ensure the container doesn't force items to stay side-by-side on mobile */
@media (max-width: 768px) {
    .container {
        display: block; /* Changes from flex to block */
        position: relative;
    }

    .sidebar {
        /* This hides the menu completely */
        position: fixed; 
        top: 55px; /* Adjust based on your topbar height */
        left: -240px; 
        width: 240px;
        height: calc(100vh - 55px);
        z-index: 9999; /* Put it on top of everything */
        transition: 0.3s ease-in-out;
        box-shadow: 5px 0 15px rgba(0,0,0,0.2);
    }

    /* This is the class the JavaScript will add/remove */
    .sidebar.open {
        left: 0 !important;
    }

    .main {
        margin-left: 0 !important;
        width: 100%;
        padding: 15px;
    }
}
</style>

  
<!-- ================= TOP BAR ================= -->
<div class="topbar">
   <div class="topbar-left" id="menuIcon" style="cursor: pointer; padding: 10px;">
        ☰ HOME
    </div>
    <div class="topbar-right">
        </div>
</div>

<div class="container">

<!-- ================= SIDEBAR ================= -->
<div class="sidebar" id="sidebar">
    


<div class="menu">
    <h5>MAIN NAVIGATION</h5>

    <div class="submenu">
        <span class="menu-toggle">Firm Creation</span>
        <ul class="submenu-list">
            <li><a href="firm_creation.php">Add New Firm</a></li>
            </ul>
    </div>
</div>
<div class="menu">

  <!-- ================= ADMINISTRATION ================= -->
  <div class="submenu">
    <span class="menu-toggle">Administration</span>
   
    <ul class="submenu-list">
<li><a  onclick="window.open('all_report.php', '_blank')">Dashboard</a></li>

    </ul>
  </div>

  <!-- ================= TRANSACTION ================= -->
  <div class="submenu">
    <span class="menu-toggle">Transaction</span>
    <ul class="submenu-list">

     <li><a href="booking_entry.php">Booking Entry</a></li>

   </ul>

  </div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const menuIcon = document.getElementById('menuIcon');
    const sidebar = document.getElementById('sidebar');

    if (menuIcon && sidebar) {
        menuIcon.addEventListener('click', function(e) {
            // Prevent the click from bubbling up
            e.stopPropagation();
            // Toggle the 'open' class on the sidebar
            sidebar.classList.toggle('open');
        });

        // Close the menu if you click anywhere on the 'main' content
        document.querySelector('.main').addEventListener('click', function() {
            if (sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });
    }
});
</script>