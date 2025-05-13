<<!DOCTYPE html>
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
  <link href="../css/view_couriers.css" rel="stylesheet">
  <link href="../css/navbar.css" rel="stylesheet">

</head>
<body>

  <!-- Include Navbar -->
  <?php include '../phpwork/nav.php'; ?>
  <?php include '../phpwork/sidebar.php'; ?>
  <?php include '../phpwork/fetch.php'; ?>
  <div class="main-content p-4">
    <!-- Page Title Section -->
    <div class="container my-4">
      <div class="manage-couriers-title-box text-center py-4">
        <h2 class="manage-couriers-title">Generate Report</h2>
        
      </div>
    </div>
    <!-- Search & Filter Section -->
    <div class="container my-4">
      <div class="search-filter-box shadow-sm p-4 rounded">
        <h5 class="mb-3 text-light">🔍 Search & Filter Report</h5>
        <form action="view_couriers.php" method="GET">
          <div class="row g-3">
            <!-- Tracking Number -->
            <div class="col-md-4">
              <input type="text" name="tracking_number" class="form-control filter-input" placeholder="Tracking Number">
            </div>

            <!-- Sender/Receiver Name -->
            <div class="col-md-4">
              <input type="text" name="name" class="form-control filter-input" placeholder="Sender / Receiver Name">
            </div>

            <!-- City -->
            <div class="col-md-4">
              <input type="text" name="city" class="form-control filter-input" placeholder="City">
            </div>

            <!-- Date Range -->
            <div class="col-md-3">
              <label class="form-label text-light">From Date</label>
              <input type="date" name="from_date" class="form-control filter-input">
            </div>

            <div class="col-md-3">
              <label class="form-label text-light">To Date</label>
              <input type="date" name="to_date" class="form-control filter-input">
            </div>

            <!-- City-wise Filter -->
            <div class="col-md-3">
              <label class="form-label text-light">Filter by City</label>
              <select name="filter_city" class="form-select filter-input">
                <option value="">All Cities</option>
                <option value="Lahore">Lahore</option>
                <option value="Karachi">Karachi</option>
                <option value="Islamabad">Islamabad</option>
              </select>
            </div>

            <!-- Status Filter -->
            <div class="col-md-3">
              <label class="form-label text-light">Status</label>
              <select name="status" class="form-select filter-input">
                <option value="">All</option>
                <option value="Booked">Booked</option>
                <option value="In Transit">In Transit</option>
                <option value="Delivered">Delivered</option>
              </select>
            </div>

            <!-- Search Button -->
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-accent filter-btn">Search / Filter</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php
    include '../phpwork/view_couriers.php';  // Include the new PHP file for fetching data
    ?>

    <div class="container my-5">
      <h3><i class="fa fa-box"></i> Report Display</h3>
      <div class="d-flex justify-content-end mb-3 gap-2">
        <a href="../phpwork/export_pdf.php" class="btn btn-sm btn-danger">
          <i class="fas fa-file-pdf me-1"></i> Download PDF
        </a>
        <a href="../phpwork/export_excel.php" class="btn btn-sm btn-success">
          <i class="fas fa-file-excel me-1"></i> Export to Excel
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-dark table-hover shadow">
          <thead class="table-light text-dark">
            <tr>
              <th>Tracking #</th>
              <th>Sender</th>
              <th>Receiver</th>
              <th>Origin</th>
              <th>Destination</th>
              <th>Booking Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($parcels) > 0): ?>
              <?php foreach($parcels as $row): ?>
                <tr>
                  <td><?= htmlspecialchars($row['consignment_no']) ?></td>
                  <td><?= htmlspecialchars($row['sender_name']) ?></td>
                  <td><?= htmlspecialchars($row['receiver_name']) ?></td>
                  <td><?= htmlspecialchars($row['branch_from_name']) ?></td>
                  <td><?= htmlspecialchars($row['branch_to_name']) ?></td>
                  <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                  <td>
                    <span class="badge 
                      <?= $row['status'] == 'Booked' ? 'bg-warning text-dark' : 
                          ($row['status'] == 'In Transit' ? 'bg-info text-dark' : 
                          'bg-success') ?>">
                      <?= $row['status'] ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center text-muted">No parcels found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
        <nav aria-label="Parcel pagination">
          <ul class="pagination justify-content-center mt-4">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
   





    
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
  

