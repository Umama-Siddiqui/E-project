

   
  <!-- Topbar -->
   <nav class="navbar navbar-expand text-white px-4 justify-content-end" style="margin-top: -20;">
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fas fa-user-circle fs-4"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end bg-dark text-white" aria-labelledby="profileDropdown">
      <li><a class="dropdown-item text-white" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</a></li>
      <li><a class="dropdown-item text-white" href="../logout.php">Logout</a></li>
    </ul>
  </div>
</nav>

<!-- Profile Modal -->
<?php

include_once '../db_connection.php';

// User data fetch karo agar session mein user_id set hai
$user = null;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $result = $conn->query("SELECT * FROM users WHERE user_id = $userId"); // Adjust column if needed

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}
?>

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body custom-modal-body">
        <?php if ($user): ?>
          <p><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
          <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
        <?php else: ?>
          <p class="text-danger">User not found or not logged in.</p>
        <?php endif; ?>
      </div>
      <div class="modal-footer custom-modal-footer">
        <button type="button" class="btn btn-outline-light custom-close-btn" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





