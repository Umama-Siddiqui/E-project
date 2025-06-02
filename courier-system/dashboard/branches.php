<?php
$page = 'manage_branches'; 
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
  <link href="../css/branch.css" rel="stylesheet">
  <link href="../css/navbar.css" rel="stylesheet">

</head>
<body>

  <!-- Include Navbar -->
  <?php include '../phpwork/nav.php'; ?>
  <?php include '../phpwork/sidebar.php'; ?>
  <?php include '../phpwork/fetch.php'; ?>
  <?php include '../phpwork/manage_branches.php'; ?>
  <div class="main-content p-4">

  <section class="add-branch-section py-5">
  <div class="container">
    <div class="branch-card p-4 rounded mx-auto">
      <h2 class="mb-4 text-center">🏢 Add New Branch</h2>
      <form action="manage_branches.php" method="POST" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
          <label for="branch_name" class="form-label">Branch Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="branch_name" name="branch_name" required>
        </div>
        <div class="mb-3">
          <label for="location" class="form-label">Location / Address</label>
          <input type="text" class="form-control" id="location" name="location">
        </div>
        <button type="submit" class="btn btn-danger w-100">➕ Add Branch</button>
      </form>
    </div>
  </div>
</section>
<section class="branch-list-section py-5">
  <div class="container">
    <h2 class="mb-4 text-center" style="color: var(--accent-color);">🏢 Branch List</h2>
    <div class="table-responsive shadow rounded branch-table-card">
      <table class="table table-dark table-striped align-middle mb-0">
        <thead>
          <tr>
            <th>🆔 Branch ID</th>
            <th>🏢 Name</th>
            <th>📍 City</th>
            <th>📍 Address</th>
            <th>🔧 Actions</th>
          </tr>
        </thead>
        <tbody>
            

            <?php if (!empty($branches)): ?>
            <?php foreach ($branches as $branch): ?>
                <tr>
                    <td><?= htmlspecialchars($branch['branch_id']) ?></td>
                    <td><?= htmlspecialchars($branch['branch_name']) ?></td>
                    <td><?= htmlspecialchars($branch['city']) ?></td>
                    <td><?= htmlspecialchars($branch['address'] ?: 'N/A') ?></td>
                   <td class="branch-actions">
                       <a href="#" class="btn-action btn-edit" 
                            data-id="<?= $branch['branch_id'] ?>" 
                            data-name="<?= htmlspecialchars($branch['branch_name']) ?>"
                            data-city="<?= htmlspecialchars($branch['city']) ?>"
                            data-address="<?= htmlspecialchars($branch['address']) ?>"
                            title="Edit">
                            ✏ Edit
                        </a>
                        <a href="#" 
                            class="btn-action btn-delete" 
                            data-id="<?= $branch['branch_id'] ?>" 
                            data-name="<?= htmlspecialchars($branch['branch_name']) ?>"
                            title="Delete">
                            🗑 Delete
                        </a>
                        <a href="?view_agents=<?= $branch['branch_id'] ?>" class="btn btn-info btn-sm">👥 View Agents</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="5" class="text-center">No branches found.</td></tr>
            <?php endif; ?>
        </tbody>

      </table>
    </div>
  </div>
</section>
<!-- Edit Branch Modal -->
<div class="modal fade" id="editBranchModal" tabindex="-1" aria-labelledby="editBranchLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="editBranchLabel">Edit Branch</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editBranchForm" method="POST" action="../phpwork/manage_branches.php">
        <div class="modal-body">
          <input type="hidden" name="branch_id" id="edit_branch_id">
          <div class="mb-3">
            <label for="edit_branch_name" class="form-label">Branch Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="edit_branch_name" name="branch_name" required>
          </div>
          <div class="mb-3">
            <label for="edit_city" class="form-label">City</label>
            <input type="text" class="form-control" id="edit_city" name="city">
          </div>
          <div class="mb-3">
            <label for="edit_address" class="form-label">Address</label>
            <input type="text" class="form-control" id="edit_address" name="address">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Update Branch</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBranchModal" tabindex="-1" aria-labelledby="deleteBranchLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteBranchLabel">Delete Branch</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deleteBranchForm" method="POST" action="delete_branch.php">
        <div class="modal-body">
          <input type="hidden" name="branch_id" id="delete_branch_id">
          <p>Are you sure you want to delete the branch <strong id="delete_branch_name"></strong>?</p>
          <p class="text-danger"><small>Note: If this branch has assigned agents, deletion might be restricted.</small></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
 <div class="modal fade <?= $branchIdToViewAgents ? 'show' : '' ?>" id="agentsModal" tabindex="-1" aria-labelledby="agentsModalLabel" aria-hidden="<?= $branchIdToViewAgents ? 'false' : 'true' ?>" style="
 <?php $branchIdToViewAgents ? 'display:block;' : '' ?>">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title" id="agentsModalLabel">Agents in Branch: <?= isset($branchName) ? htmlspecialchars($branchName) : '' ?></h5>
        <a href="branches.php" class="btn-close btn-close-white" aria-label="Close"></a>
      </div>
      <div class="modal-body">
        <?php if ($branchIdToViewAgents): ?>
            <?php if (count($agents) > 0): ?>
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Agent ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Joined On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agents as $agent): ?>
                            <tr>
                                <td><?= htmlspecialchars($agent['user_id']) ?></td>
                                <td><?= htmlspecialchars($agent['full_name']) ?></td>
                                <td><?= htmlspecialchars($agent['email']) ?></td>
                                <td><?= htmlspecialchars($agent['phone']) ?></td>
                                <td><?= date('d M Y', strtotime($agent['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No agents found for this branch.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Select a branch and click "View Agents" to see assigned agents.</p>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <a href="branches.php" class="btn btn-outline-light">Close</a>
      </div>
    </div>
  </div>
</div>






</div>
  <?php include '../phpwork/footer.php'; ?>



</body>
</html>
  <!-- JS Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
      document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit');
    
    editButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        // Get branch data from data- attributes
        const branchId = this.dataset.id;
        const branchName = this.dataset.name;
        const city = this.dataset.city;
        const address = this.dataset.address;

        // Fill modal inputs
        document.getElementById('edit_branch_id').value = branchId;
        document.getElementById('edit_branch_name').value = branchName;
        document.getElementById('edit_city').value = city;
        document.getElementById('edit_address').value = address;

        // Show modal
        const editModal = new bootstrap.Modal(document.getElementById('editBranchModal'));
        editModal.show();
      });
    });
  });
   
        document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
            e.preventDefault();

            const branchId = this.dataset.id;
            const branchName = this.dataset.name;

            document.getElementById('delete_branch_id').value = branchId;
            document.getElementById('delete_branch_name').textContent = branchName;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteBranchModal'));
            deleteModal.show();
            });
        });
        });


      

</script>
        <?php if ($branchIdToViewAgents): ?>
<script>
    // Show modal on page load if view_agents param set
    var myModal = new bootstrap.Modal(document.getElementById('agentsModal'));
    myModal.show();
</script>
<?php endif; ?>