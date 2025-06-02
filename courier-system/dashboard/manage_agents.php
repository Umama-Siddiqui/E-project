<?php
$page = 'manage_agents'; 
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
  <link href="../css/manage_agents.css" rel="stylesheet">
  <link href="../css/navbar.css" rel="stylesheet">

</head>
<body>

  <!-- Include Navbar -->
  <?php include '../phpwork/nav.php'; ?>
  <?php include '../phpwork/sidebar.php'; ?>
  <?php include '../phpwork/fetch.php'; ?>
  <?php include '../phpwork/manage_agent.php'; ?>
  <div class="main-content p-4">
    <section>
         <h2 class="section-heading animate__animated animate__fadeInDown">
            <i class="fas fa-user-plus me-2"></i>➕ Add New Agent
        </h2>
            <?php if ($add_success) echo "<p class='success'>$add_success</p>"; ?>
            <?php if ($add_error) echo "<p class='error'>$add_error</p>"; ?>
            <form method="POST" class="p-4 bg-dark rounded">
            <div class="row mb-3">
                <div class="col-md-6">
                <label class="form-label">👤 Agent Name</label>
                <input type="text" name="name" class="form-control text-white" required>
                </div>
                <div class="col-md-6">
                <label class="form-label">📧 Email</label>
                <input type="email" name="email" class="form-control text-white" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                <label class="form-label">🔐 Password</label>
                <input type="password" name="password" class="form-control text-white" required>
                </div>
                <div class="col-md-6">
                <label class="form-label text-white">🏢 Branch Assign</label>
                <select name="branch" class="form-select" required>
                    <option value="">-- Select Branch --</option>
                    <option value="1">Karachi</option>
                    <option value="2">Islamabad</option>
                </select>
                </div>
            </div>

            <div class="text-start">
                <button type="submit" name="add_agent" class="btn btn-danger px-4">Add Agent</button>
            </div>
            </form>


           <h2 class="mt-5 mb-4 section-heading">📋 Agents List</h2>

<div class="table-responsive">
  <table class="table table-dark table-hover align-middle table-bordered mb-5">
    <thead class="table-secondary text-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Branch</th>
        <th>Created</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
<?php
$result = $conn->query("
  SELECT u.user_id, u.full_name, u.email, u.branch_id, u.created_at, b.branch_name
  FROM users u
  LEFT JOIN branches b ON u.branch_id = b.branch_id
  WHERE u.role = 'agent'
  ORDER BY u.user_id DESC
");

while ($row = $result->fetch_assoc()) {
  echo "<tr>
    <td>{$row['user_id']}</td>
    <td>" . htmlspecialchars($row['full_name']) . "</td>
    <td>" . htmlspecialchars($row['email']) . "</td>
    <td>" . htmlspecialchars($row['branch_name']) . "</td>
    <td>{$row['created_at']}</td>
    <td class='action-btns'>
      <form method='POST' style='display:inline'>
        <input type='hidden' name='id' value='{$row['user_id']}'>
        <input type='hidden' name='name' value='" . htmlspecialchars($row['full_name']) . "'>
        <input type='hidden' name='email' value='" . htmlspecialchars($row['email']) . "'>
        <input type='hidden' name='branch' value='{$row['branch_id']}'>
        <button name='edit_prefill' class='btn btn-sm btn-outline-primary me-2'>
          Edit
        </button>
      </form>

      <!-- Delete Button with Modal Trigger -->
      <button class='btn btn-sm btn-outline-danger' data-bs-toggle='modal' data-bs-target='#confirmDeleteModal{$row['user_id']}'>
        Delete
      </button>

      <!-- Delete Confirmation Modal -->
      <div class='modal fade' id='confirmDeleteModal{$row['user_id']}' tabindex='-1' aria-labelledby='deleteLabel{$row['user_id']}' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered'>
          <div class='modal-content bg-dark text-white'>
            <div class='modal-header border-secondary'>
              <h5 class='modal-title' id='deleteLabel{$row['user_id']}'>Confirm Delete</h5>
              <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
              Are you sure you want to delete agent <strong>" . htmlspecialchars($row['full_name']) . "</strong>?
            </div>
            <div class='modal-footer border-secondary'>
              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
              <a href='?delete={$row['user_id']}' class='btn btn-danger'>Yes, Delete</a>
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>";
}
?>

    </tbody>
  </table>
</div>


           <!-- Edit Agent Modal -->
<div class="modal fade" id="editAgentModal" tabindex="-1" aria-labelledby="editAgentLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="editAgentLabel">✏️ Edit Agent</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <input type="hidden" name="id" id="edit_id">
        <div class="col-md-6">
          <label>Name</label>
          <input type="text" name="name" id="edit_name" class="form-control text-white" required>
        </div>
        <div class="col-md-6">
          <label>Email</label>
          <input type="email" name="email" id="edit_email" class="form-control text-white" required>
        </div>
        <div class="col-md-6">
          <label>Branch</label>
          <select name="branch" id="edit_branch" class="form-select text-white" required>
            <option value="1">Karachi</option>
            <option value="2">Islamabad</option>
            
          </select>
        </div>
        <div class="col-md-6">
          <label>New Password</label>
          <input type="password" name="password" class="form-control text-white">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="edit_agent" class="btn btn-warning">Update Agent</button>
      </div>
    </form>
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
  <!-- Paste this in <head> tag of your HTML file -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <script>
    AOS.init();
  </script>
<script>
  // Fill and show Edit Modal
  document.querySelectorAll("form button[name='edit_prefill']").forEach(btn => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      const form = this.closest("form");
      document.getElementById('edit_id').value = form.querySelector("[name='id']").value;
      document.getElementById('edit_name').value = form.querySelector("[name='name']").value;
      document.getElementById('edit_email').value = form.querySelector("[name='email']").value;
      document.getElementById('edit_branch').value = form.querySelector("[name='branch']").value;
      new bootstrap.Modal(document.getElementById('editAgentModal')).show();
    });
  });

  // Handle delete modal
  document.querySelectorAll("a[href*='?delete=']").forEach(link => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const deleteUrl = this.href;
      document.getElementById('deleteConfirmBtn').href = deleteUrl;
      new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
  });
</script>
