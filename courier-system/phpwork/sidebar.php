<!-- Hamburger Button -->
  <button class="menu-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    
    <div class="sidebar-logo">
      <img src="../css/logo1.png" alt="Courier Logo" class="main-logo">
      <img src="../css/logo.png" alt="Courier Logo" class="hover-logo">
    </div>


    <a href="admin.php" class="<?php echo ($page == 'admin') ? 'active' : ''; ?>">
      <i class="fas fa-gauge"></i><span class="text">Dashboard</span>
    </a>

    <a href="add_courier.php" class="<?php echo ($page == 'add_courier') ? 'active' : ''; ?>">
      <i class="fas fa-plus-circle"></i><span class="text">Add New Courier</span>
    </a>

    <a href="view_couriers.php" class="<?php echo ($page == 'view_couriers') ? 'active' : ''; ?>">
      <i class="fas fa-boxes"></i><span class="text">View Couriers</span>
    </a>

    <a href="manage_agents.php" class="<?php echo ($page == 'manage_agents') ? 'active' : ''; ?>">
      <i class="fas fa-user-tie"></i><span class="text">Manage Agents</span>
    </a>

    <a href="manage_customers.php" class="<?php echo ($page == 'manage_customers') ? 'active' : ''; ?>">
      <i class="fas fa-users"></i><span class="text">Manage Customers</span>
    </a>

    <a href="branches.php" class="<?php echo ($page == 'manage_branches') ? 'active' : ''; ?>">
      <i class="fas fa-building"></i><span class="text">Manage Branches</span>
    </a>

    <a href="sms_log.php" class="<?php echo ($page == 'sms_log') ? 'active' : ''; ?>">
      <i class="fas fa-envelope-open-text"></i><span class="text">SMS Logs</span>
    </a>

    <a href="reports.php" class="<?php echo ($page == 'reports') ? 'active' : ''; ?>">
      <i class="fas fa-file-alt"></i><span class="text">Reports</span>
    </a>


  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
      document.getElementById('main').classList.toggle('shifted');
    }
  </script>
