

   
  <!-- Topbar -->
   <nav class="navbar navbar-expand text-white px-4 justify-content-end" style="margin-top: -20;">
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fas fa-user-circle fs-4"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end bg-dark text-white" aria-labelledby="profileDropdown">
      <li><a class="dropdown-item text-white" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</a></li>
      <li><a class="dropdown-item text-white" href="#">Settings</a></li>
    </ul>
  </div>
</nav>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title" id="profileModalLabel">Admin Profile</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body custom-modal-body">
        <p><strong>Name:</strong> Admin User</p>
        <p><strong>Email:</strong> admin@example.com</p>
      </div>
      <div class="modal-footer custom-modal-footer">
        <button type="button" class="btn btn-outline-light custom-close-btn" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
