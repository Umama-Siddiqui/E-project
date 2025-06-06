<?php
$page = 'reports'; 
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

  <!-- Table CSS -->

  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">

  <!-- Custom CSS -->
  <link href="../css/view_couriers.css" rel="stylesheet">
  <link href="../css/navbar.css" rel="stylesheet">

</head>
<body>

  <!-- Include Navbar -->
  <?php include '../phpwork/nav.php'; ?>
  <?php include '../phpwork/sidebar2.php'; ?>
  <?php include '../phpwork/fetch.php'; ?>
  <div class="main-content p-4">
    <!-- Page Title Section -->
    <div class="container my-4">
      <div class="manage-couriers-title-box text-center py-4">
        <h2 class="manage-couriers-title">View & Manage Couriers</h2>
        <p class="">Track, update, and manage all courier records from this panel.</p>
      </div>
    </div>
    <!-- Search & Filter Section -->
    <div class="container my-4">
      <div class="search-filter-box shadow-sm p-4 rounded">
        <h5 class="mb-3 text-light text-center">🔍 Search & Filter Couriers</h5>
        <form action="view_couriers.php" method="GET">
          <div class="row g-3">
            <!-- Tracking Number -->
            <div class="col-md-4" style="margin-left: 10%;">
              <input type="text" name="tracking_number" class="form-control filter-input" placeholder="Tracking Number">
            </div>

            <!-- Sender/Receiver Name -->
            <div class="col-md-4" style="margin-left: 10%;">
              <input type="text" name="name" class="form-control filter-input" placeholder="Sender / Receiver Name">
            </div>

            

            <!-- Date Range -->
            <div class="col-md-3" style="margin-left: 10%;">
              <label class="form-label text-light">From Date</label>
              <input type="date" name="from_date" class="form-control filter-input">
            </div>

            <div class="col-md-3">
              <label class="form-label text-light">To Date</label>
              <input type="date" name="to_date" class="form-control filter-input">
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
    include '../phpwork/agent_view_couriers.php';  // Include the new PHP file for fetching data
    ?>

    <div class="container my-5">
      <h3 class="text-light mb-4">📦 Parcel List</h3>
      <div class="d-flex justify-content-end mb-3 gap-2">
        <a href="../phpwork/export_pdf.php" class="btn btn-sm btn-danger">
          <i class="fas fa-file-pdf me-1"></i> Download PDF
        </a>
        <a href="../phpwork/export_excel.php" class="btn btn-sm btn-success">
          <i class="fas fa-file-excel me-1"></i> Export to Excel
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-dark table-hover shadow" id="myTable">
          <thead class="table-light text-dark">
            <tr>
              <th>Tracking #</th>
              <th>Sender</th>
              <th>Receiver</th>
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
  <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    AOS.init();
    function openEditModal(id, name, phone, address) {
      document.getElementById('edit_parcel_id').value = id;
      document.getElementById('edit_receiver_name').value = name;
      document.getElementById('edit_receiver_phone').value = phone;
      document.getElementById('edit_receiver_address').value = address;
      new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    function openDeleteModal(id) {
      document.getElementById('delete_parcel_id').value = id;
      new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    function openStatusModal(id) {
      document.getElementById('status_parcel_id').value = id;
      new bootstrap.Modal(document.getElementById('statusModal')).show();
    }
    let table = new DataTable('#myTable');
  </script>
  

