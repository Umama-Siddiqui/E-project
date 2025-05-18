<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id'])) {
  echo '<div class="alert alert-warning text-center">🚫 You need to <a href="login.php" class="text-decoration-underline">login</a> to track your parcel.</div>';
  exit;
}

if (isset($_GET['consignment_no'])) {
  $trackNo = $_GET['consignment_no'];
  $stmt = $conn->prepare("SELECT * FROM parcels WHERE consignment_no = ?");
  $stmt->bind_param("s", $trackNo);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    $parcel = $result->fetch_assoc();
    ?>
    <div class="result-box p-4 rounded" style="background-color: var(--primary-color); color: var(--text-color);">
      <h5 class="mb-3">📦 Parcel Information</h5>
      <ul class="list-group list-group-flush">
        <li class="list-group-item bg-transparent text-light"><strong>Sender:</strong> <?= htmlspecialchars($parcel['sender_name']) ?></li>
        <li class="list-group-item bg-transparent text-light"><strong>Receiver:</strong> <?= htmlspecialchars($parcel['receiver_name']) ?></li>
        <li class="list-group-item bg-transparent text-light"><strong>Type:</strong> <?= htmlspecialchars($parcel['parcel_type']) ?></li>
        <li class="list-group-item bg-transparent text-light"><strong>Date:</strong> <?= date('d M Y', strtotime($parcel['created_at'])) ?></li>
        <li class="list-group-item bg-transparent">
          <strong>Status:</strong> 
          <span class="badge bg-<?=
            $parcel['status'] === 'Booked' ? 'warning text-dark' :
            ($parcel['status'] === 'In Transit' ? 'info text-dark' : 'success') ?>">
            <?= $parcel['status'] ?>
          </span>
        </li>
      </ul>
      <form id="pdfDownloadForm" action="track/download_pdf.php" method="GET" target="_blank" class="d-inline">
        <input type="hidden" name="track_no" value="<?= htmlspecialchars($parcel['consignment_no']) ?>">
        <button type="submit" class="btn btn-outline-light mt-3">📄 Print to PDF</button>
    </form>
    </div>
    <?php
  } else {
    echo "<p class='text-danger'>❌ No record found for this tracking number.</p>";
  }
  $stmt->close();
} else {
  echo "<p class='text-danger'>❌ Tracking number is required.</p>";
}
?>
