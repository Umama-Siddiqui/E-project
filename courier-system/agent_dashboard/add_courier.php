<?php
$page = 'add_courier'; 
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
  <link href="../css/add_courier.css" rel="stylesheet">
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
        <div class="page-title-box text-center py-4">
            <h2 class="add-courier-title">Add New Courier</h2>
            <p class="">Fill the form below to register a new courier in the system.</p>
        </div>
        </div>
        <form method="POST" action="../phpwork/agent_add_cour.php">
        <!-- Tracking Number Section -->
        <div class="container my-5">
            <div class="card shadow-sm tracking-card border-0">
                <div class="card-body">
                <h4 class="card-title mb-3">📌 Auto-generated Tracking Number</h4>
                <p class=" mb-4">Har parcel ka ek unique consignment ID automatically generate hota hai. Neeche aapka auto-filled tracking number diya gaya hai:</p>

                <?php
                    // Tracking number generator
                    $datePart = date("Ymd");
                    $randomDigits = rand(1000, 9999);
                    $trackingNumber = "TRK" . $datePart . $randomDigits;
                ?>

                <div class="form-group">
                    <label for="trackingNumber" class="form-label">Tracking ID:</label>
                    <input type="text" id="trackingNumber" name="trackingNumber"
                    class="form-control tracking-input" value="<?php echo $trackingNumber; ?>" readonly>
                </div>
               </div>
           </div>
        </div>
        <!-- Sender Information Section -->
        <div class="container my-5">
            <div class="card sender-info-card shadow-sm border-0">
                <div class="card-body">
                <h4 class="card-title mb-3">👤 Sender Information</h4>
                <p class=" mb-4">Please enter sender's details carefully. All fields are required.</p>

                <div class="row g-3">
                    <!-- Sender Name -->
                    <div class="col-md-6">
                    <label for="senderName" class="form-label">Sender Name</label>
                    <input type="text" class="form-control sender-input" id="senderName" name="senderName" required>
                    </div>

                    <!-- Sender Contact -->
                    <div class="col-md-6">
                    <label for="senderContact" class="form-label">Sender Contact Number</label>
                    <input type="text" class="form-control sender-input" id="senderContact" name="senderContact" required pattern="\d+" title="Digits only">
                    </div>

                    <!-- Sender Address -->
                    <div class="col-12">
                    <label for="senderAddress" class="form-label">Sender Address</label>
                    <textarea class="form-control sender-input" id="senderAddress" name="senderAddress" rows="3" required></textarea>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Receiver Information Section -->
        <div class="container my-5">
        <div class="card receiver-info-card shadow-sm border-0">
            <div class="card-body">
            <h4 class="card-title mb-3">📦 Receiver Information</h4>
            <p class=" mb-4">Receiver ke details niche fill karein. Sab fields required hain.</p>

            <div class="row g-3">
                <!-- Receiver Name -->
                <div class="col-md-6">
                <label for="receiverName" class="form-label">Receiver Name</label>
                <input type="text" class="form-control receiver-input" id="receiverName" name="receiverName" required>
                </div>

                <!-- Receiver Contact -->
                <div class="col-md-6">
                <label for="receiverContact" class="form-label">Receiver Contact Number</label>
                <input type="tel" class="form-control receiver-input" id="receiverContact" name="receiverContact" 
                        required pattern="^03[0-9]{9}$" 
                        title="Enter valid Pakistani number. Example: 03XXXXXXXXX">
                </div>
                <div class="col-md-6">
                <label for="receiveremail" class="form-label">Receiver Email-Address</label>
                <input type="email" class="form-control receiver-input" id="receiveremail" name="receiveremail" 
                        required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
                        title="Enter valid Email-address. Example: example@gmail.com">
                </div>

                <!-- Receiver Address -->
                <div class="col-12">
                <label for="receiverAddress" class="form-label">Receiver Address</label>
                <textarea class="form-control receiver-input" id="receiverAddress" name="receiverAddress" rows="3" required></textarea>
                </div>
            </div>
            </div>
        </div>
        </div>
        <!-- Parcel Details Section -->
        <div class="container my-5">
        <div class="card parcel-details-card shadow-sm border-0">
            <div class="card-body">
            <h4 class="card-title mb-3">📦 Parcel Details</h4>
            <p class=" mb-4">Please enter parcel details below.</p>

            <div class="row g-3">
                <!-- Parcel Type -->
                <div class="col-md-4">
                <label for="parcelType" class="form-label">Parcel Type</label>
                <select class="form-select parcel-input" id="parcelType" name="parcelType" required>
                    <option value="">Select type</option>
                    <option value="Normal">Normal</option>
                    <option value="Express">Express</option>
                    <option value="Same-Day">Same-Day</option>
                </select>
                </div>

                <!-- Weight -->
                <div class="col-md-4">
                <label for="parcelWeight" class="form-label">Weight (kg)</label>
                <input type="number" class="form-control parcel-input" id="parcelWeight" name="parcelWeight" required min="0.1" step="0.1">
                </div>

                <!-- Price -->
                <div class="col-md-4">
                <label for="parcelPrice" class="form-label">Price (PKR)</label>
                <input type="text" class="form-control parcel-input" id="parcelPrice" name="parcelPrice" readonly>
                </div>

                <!-- Branch From -->
                <?php $branchFrom = $_SESSION['branch_id'] ?? ''; ?>
                <input type="hidden" name="branchFrom" value="<?= $branchFrom ?>">


                <!-- Branch To -->
                <div class="col-md-6">
                <label for="branchTo" class="form-label">Branch To</label>
                <select class="form-select parcel-input" id="branchTo" name="branchTo" required>
                    <option value="">Select branch</option>
                    <!-- PHP se branches dynamically aayengi -->
                    <option value="2">Islamabad</option>
                    <option value="1">Multan</option>
                </select>
                </div>

                <!-- Expected Delivery Date -->
                <div class="col-md-6">
                <label for="expectedDate" class="form-label">Expected Delivery Date</label>
                <input type="date" class="form-control parcel-input" id="expectedDate" name="expectedDate" required>
                </div>

                <!-- Notes (Optional) -->
                <div class="col-md-6">
                <label for="parcelNotes" class="form-label">Notes / Special Instructions (Optional)</label>
                <textarea class="form-control parcel-input" id="parcelNotes" name="parcelNotes" rows="2"></textarea>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="text-center mt-4">
        <button type="submit" name="submitParcel" class="btn btn-primary px-5 py-2 unique-submit-btn">➕ Add Parcel</button>
        </div>

        </form>




    
    </div>
  <?php include '../phpwork/footer.php'; ?>



</body>
</html>
  <!-- JS Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
    document.getElementById('parcelWeight').addEventListener('input', function() {
    const weight = parseFloat(this.value);
    if (!isNaN(weight)) {
        // Example rate: 100 PKR per kg
        const price = weight * 100;
        document.getElementById('parcelPrice').value = price.toFixed(2);
    } else {
        document.getElementById('parcelPrice').value = '';
    }
    });
  </script>

