<?php
$page = 'manage_customers'; 
include '../phpwork/check.php';

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
  <link href="../css/manage_customers.css" rel="stylesheet">
  <link href="../css/navbar.css" rel="stylesheet">
  

</head>
<body>

  <!-- Include Navbar -->
  <?php include '../phpwork/nav.php'; ?>
  <?php include '../phpwork/sidebar.php'; ?>
  <div class="main-content p-4">
    <!-- Manage Customers Section -->
    <section class="manage-customers-section text-center">
      <div class="container">
        <h2 class="customers-title" data-aos="fade-up">👥 Manage Customers</h2>
        <p class="customers-subtext" data-aos="fade-up" data-aos-delay="100">
          View, edit, or delete customer records from the system.
        </p>
      </div>
    </section>
    <!-- Manage Customers: Search Bar Section -->
  <?php include '../phpwork/manage_customers.php'; ?>
    <section class="customer-search-section">
      <div class="container">
       <form method="GET" action="" class="search-form me-5" data-aos="fade-up" data-aos-delay="200">
          <div class="search-wrapper">
            <input 
              type="text" 
              name="search" 
              value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
              placeholder="🔍 Search by name, email or phone" 
              autocomplete="off"
            >
            <button type="submit" aria-label="Search">
              🔍
            </button>
          </div>
        </form>
      </div>
    </section>
    <section class="customer-list-section mb-5">
        <div class="container">
          <h3 class="text-light mb-4" data-aos="fade-up">📋 Customer List</h3>
          <div class="table-responsive" data-aos="fade-up" data-aos-delay="100">
            <table class="table table-dark table-striped table-hover rounded-table">
              <thead class="table-dark">
                <tr>
                  <th>📛 Name</th>
                  <th>📧 Email</th>
                  
                  <th>🗓️ Registered</th>
                  <th>🔧 Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($customers)): ?>
                  <?php foreach ($customers as $customer): ?>
                    <tr>
                      <td><?= htmlspecialchars($customer['full_name']) ?></td>
                      <td><?= htmlspecialchars($customer['email']) ?></td>
                      
                      <td><?= date('d M Y', strtotime($customer['created_at'])) ?></td>
                      <td>
                        <!-- Add this inside the Actions column -->
                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editCustomerModal<?= $customer['user_id'] ?>">
                          <i class="fas fa-edit"></i> Edit
                        </button>
                        <!-- Delete Button (in each row) -->
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal<?= $customer['user_id'] ?>">
                          <i class="fas fa-trash-alt"></i> Delete
                        </button>
                        
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="5" class="text-center">No customers found.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
    </section>
    <!-- Modal -->
<div class="modal fade" id="editCustomerModal<?= $customer['user_id'] ?>" tabindex="-1" aria-labelledby="editCustomerModalLabel<?= $customer['user_id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-start bg-dark text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="editCustomerModalLabel<?= $customer['user_id'] ?>">✏️ Edit Customer</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="../phpwork/update_customers.php">
        <div class="modal-body">
          <input type="hidden" name="user_id" value="<?= $customer['user_id'] ?>">

          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($customer['full_name']) ?>" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="update_customer" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCustomerModal<?= $customer['user_id'] ?>" tabindex="-1" aria-labelledby="deleteCustomerLabel<?= $customer['user_id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title">⚠️ Confirm Deletion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete customer <strong><?= htmlspecialchars($customer['full_name']) ?></strong>?
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form method="POST" action="../phpwork/delete_customers.php" class="d-inline">
          <input type="hidden" name="user_id" value="<?= $customer['user_id'] ?>">
          <button type="submit" name="delete_customer" class="btn btn-danger">Yes, Delete</button>
        </form>
      </div>
    </div>
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
 