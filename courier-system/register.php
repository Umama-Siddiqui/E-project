<!DOCTYPE html>
<html>
<head>
    <title>Generate Password Hash</title>
</head>
<body>
    <h2>Generate Hashed Password</h2>

    <form method="POST">
        <input type="text" name="plain_password" placeholder="Enter plain password" required>
        <button type="submit" name="generate">Generate Hash</button>
    </form>

    <?php
    if (isset($_POST['generate'])) {
        $plain = $_POST['plain_password'];
        $hash = password_hash($plain, PASSWORD_DEFAULT);
        echo "<p><strong>Plain:</strong> " . htmlspecialchars($plain) . "</p>";
        echo "<p><strong>Hashed:</strong> " . htmlspecialchars($hash) . "</p>";
    }
    ?>
</body>
</html>
