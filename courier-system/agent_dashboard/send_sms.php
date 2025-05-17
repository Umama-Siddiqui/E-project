<?php
$page = 'sms_log'; 
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
  <?php include '../phpwork/fetch.php'; ?>
  <div class="main-content p-4">
    <!-- SMS Logs Section -->
    <section class="sms-logs-header py-5 text-center">
        <div class="container">
            <h1 class="page-title animate__animated animate__fadeInDown">📩 SMS Logs</h1>
            <p class="subtitle animate__animated animate__fadeInUp">Yahan aapko sab SMS sending records milenge</p>
        </div>
    </section>
    <!-- Filter Section -->
    <section class="sms-filter-section py-4">
        <div class="container">
            <form class="row g-3 align-items-end text-light" method="GET" action="">
            
            <!-- Mobile Number -->
            <div class="col-md-4">
                <label for="mobile" class="form-label">📞 Mobile Number</label>
                <input type="text" name="mobile" class="form-control bg-dark text-light border-secondary" id="mobile" placeholder="Enter number">
            </div>

            <!-- Date Range -->
            <div class="col-md-2">
                <label for="from_date" class="form-label">📅 From Date</label>
                <input type="date" name="from_date" class="form-control bg-dark text-light border-secondary" id="from_date">
            </div>
            <div class="col-md-2">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control bg-dark text-light border-secondary" id="to_date">
            </div>

            <!-- Status Dropdown -->
            <div class="col-md-2">
                <label for="status" class="form-label">✅ Status</label>
                <select name="status" id="status" class="form-select bg-dark text-light border-secondary">
                <option value="">All</option>
                <option value="Sent">Sent</option>
                <option value="Failed">Failed</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-outline-light w-100 animate__animated animate__fadeIn">
                🔍 Filter Logs
                </button>
            </div>
            
            </form>
        </div>
    </section>
    <?php include '../phpwork/sms_log.php'; ?>

    <section class="sms-log-table py-4 mb-5">
        <div class="container">
            <div class="table-responsive animate__animated animate__fadeInUp">
            <?php if (!empty($sms_logs) && count($sms_logs) > 0): ?>
                    <table class="table table-bordered table-hover shadow-sm">
                    <thead class="table-primary text-center">
                        <tr>
                        <th>Serial</th>
                        <th>📞 Mobile Number</th>
                        <th>💬 Message</th>
                        <th>🕒 Date & Time</th>
                        <th>✅ Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php $serial = 1; ?>
                        <?php foreach ($sms_logs as $log): ?>
                        <tr>
                            <td><?= $serial++ ?></td>
                            <td><?= htmlspecialchars($log['phone_number']) ?></td>
                            <td>
                            <?php
                                $fullMessage = htmlspecialchars($log['message_body']);
                                $shortMessage = strlen($fullMessage) > 30 ? substr($fullMessage, 0, 30) . "..." : $fullMessage;
                            ?>
                            <span title="<?= $fullMessage ?>" data-bs-toggle="tooltip"><?= $shortMessage ?></span>
                            </td>
                            <td><?= date('d M Y, h:i A', strtotime($log['timestamp'])) ?></td>
                            <td>
                            <?php if (strtolower($log['status']) === 'sent'): ?>
                                <span class="badge bg-success">Sent</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Failed</span>
                            <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                        📭 SMS Logs not found.
                        </div>
                    <?php endif; ?>

            </div>
        </div>
    </section>
     <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <div>
            <ul class="pagination justify-content-center mt-3">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                    <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </div>
    <?php endif; ?>




    
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
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
    })
  </script>

