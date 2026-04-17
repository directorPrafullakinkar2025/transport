

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
@media (max-width: 768px) {
    .container {
        flex-direction: column; /* Stack sidebar and main content */
    }

    .sidebar {
        position: fixed;
        left: -240px; /* Hide sidebar off-screen */
        transition: 0.3s;
        z-index: 1000;
        width: 240px;
    }

    /* This class is toggled by your JS */
    .sidebar.open {
        left: 0;
    }

    .main {
        padding: 10px;
        width: 100%;
    }

    /* Make Dashboard Tiles stack: 4 columns -> 1 column */
    .tiles {
        grid-template-columns: 1fr; 
    }

    /* Make tables scrollable horizontally */
    .reminder-grid {
        grid-template-columns: 1fr;
    }
    
    table {
        display: block;
        overflow-x: auto;
    }
}

</style>

  
<!-- ================= TOP BAR ================= -->
<div class="topbar">
    <div class="topbar-left" id="menuIcon" style="cursor: pointer;">
        HOME ☰
    </div>
    <div class="topbar-right">
        </div>
</div>

<div class="container">

<!-- ================= SIDEBAR ================= -->
<div class="sidebar" id="sidebar">
    


 <div class="menu">
        <h5>MAIN NAVIGATION</h5>
  
        <li><a href="firm_creation.php">Firm Creation</a></li>

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
    
    // 1. MOBILE SIDEBAR TOGGLE
    const menuIcon = document.getElementById('menuIcon');
    const sidebar = document.getElementById('sidebar');

    if (menuIcon && sidebar) {
        menuIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('open');
        });

        // Close sidebar if user clicks anywhere else on the main screen (Mobile)
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !menuIcon.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }

    // 2. SUBMENU ACCORDION LOGIC
    document.querySelectorAll(".menu-toggle").forEach(toggle => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const currentSubmenu = this.parentElement;
            const parentContainer = currentSubmenu.parentElement;

            // Close other open submenus within the same section
            parentContainer.querySelectorAll(".submenu").forEach(item => {
                if (item !== currentSubmenu) {
                    item.classList.remove("active");
                }
            });

            // Toggle the clicked submenu
            currentSubmenu.classList.toggle("active");
        });
    });

    // 3. AUTO-CLOSE SIDEBAR ON LINK CLICK (Mobile Only)
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('open');
            }
        });
    });

});
</script>