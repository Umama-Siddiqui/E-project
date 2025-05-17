<?php
$page = 'agent'; 
include '../phpwork/check2.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Courier Management System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- AOS CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="../css/admin.css" rel="stylesheet">
  <link href="../css/navbar.css" rel="stylesheet">
  

</head>
<body>

  <!-- Include Navbar -->
  <?php include '../phpwork/nav.php'; ?>
  <?php include '../phpwork/sidebar2.php'; ?>
  <?php include '../phpwork/agent_fetch.php'; ?>
  <div class="main-content p-4">
    <section>
      <div class="container my-5">
        <div class="row"style="align-items: center; justify-content: center;">
          <!-- Total Parcels Card -->
          <div class="col-md-4 mb-4">
            <div class="card shadow-lg rounded p-3" style="background-color: var(--secondary-color);">
              <div class="card-body">
                <h5 class="card-title" style="color: var(--text-color);">Total Parcels</h5>
                <p class="card-text display-4" style="color: var(--accent-color);"><?php echo $total_parcels; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
    <section>
      <!-- Continue this below the previous section (dashboard.php) -->
      <div class="container py-5">
        <h2 class="mb-4 text-center">📦 Parcel Status</h2>
        <div class="row g-4">

          <!-- Booked Parcels -->
          <div class="col-md-4">
            <div class="card dashboard-card p-4 border-start border-5 border-warning">
              <div class="dashboard-title">Booked Parcels</div>
              <div class="dashboard-number" style="color: var(--warning-color);">
                <?php echo $booked_parcels ?? '0'; ?>
              </div>
            </div>
          </div>

          <!-- In Transit Parcels -->
          <div class="col-md-4">
            <div class="card dashboard-card p-4 border-start border-5 border-info">
              <div class="dashboard-title">In Transit</div>
              <div class="dashboard-number" style="color: var(--text-color);">
                <?php echo $in_transit_parcels ?? '0'; ?>
              </div>
            </div>
          </div>

          <!-- Delivered Parcels -->
          <div class="col-md-4">
            <div class="card dashboard-card p-4 border-start border-5 border-success">
              <div class="dashboard-title">Delivered</div>
              <div class="dashboard-number" style="color: var(--success-color);">
                <?php echo $delivered_parcels ?? '0'; ?>
              </div>
            </div>
          </div>

        </div>
      </div>

    </section>
    <section>
      <!-- Continue inside dashboard.php -->
      <div class="container py-5">
        <h2 class="mb-4 text-center">🚀 Quick Actions</h2>
        <div class="d-flex flex-wrap justify-content-center gap-4">

          <!-- Add Courier -->
          <a href="add_courier.php" class="btn quick-action-btn">
            ➕ Add Courier
          </a>

          <!-- View Couriers -->
          <a href="view_couriers.php" class="btn quick-action-btn">
            📦 View Couriers
          </a>

          <!-- Reports -->
          <a href="reports.php" class="btn quick-action-btn">
            📊 Reports
          </a>

        </div>
      </div>

    </section>
  </div>
  <?php include '../phpwork/footer.php'; ?>
  
 



</body>
</html>
  <!-- JS Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
