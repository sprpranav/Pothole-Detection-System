<?php
session_start();
require 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$uploadResult = '';
$showLocationForm = false;
$imagePath = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $python_path = "C:\\Users\\sprpr\\AppData\\Local\\Programs\\Python\\Python312\\python.exe";
        $command = escapeshellcmd("$python_path detect_pothole.py " . escapeshellarg($target_file));
        $output = shell_exec($command . " 2>&1");

        $output_lines = explode("\n", trim($output));
        $result = trim(end($output_lines));

        $uploadResult = "Detection Result: <strong>$result</strong>";

        if ($result == "Pothole Detected") {
            $showLocationForm = true;
            $imagePath = $target_file;
        }
    } else {
        $uploadResult = "❌ File upload failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pothole Detection Upload</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .upload-container {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        .upload-container h2 {
            margin-bottom: 20px;
            font-weight: bold;
        }
        .result-message {
            margin-top: 20px;
            font-size: 18px;
        }
        .location-form {
            margin-top: 30px;
        }
        .btn-custom {
            width: 100%;
            padding: 12px;
            font-size: 18px;
        }
        .back-link {
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="upload-container">
    <h2>Upload Road Image for Pothole Detection</h2>

    <?php if (empty($uploadResult)) : ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input class="form-control" type="file" name="image" required>
            </div>
            <button class="btn btn-primary btn-custom" type="submit">Upload & Detect</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($uploadResult)) : ?>
        <div class="result-message">
            <?php echo $uploadResult; ?>
        </div>
    <?php endif; ?>

    <?php if ($showLocationForm) : ?>
        <div class="location-form">
            <form action="send_email.php" method="POST">
                <input type="hidden" name="image" value="<?php echo htmlspecialchars($imagePath); ?>">
                <div class="mb-3">
                    <input class="form-control" type="text" name="location" placeholder="Enter Location" required>
                </div>
                <button class="btn btn-success btn-custom" type="submit">Send Complaint</button>
            </form>
        </div>
    <?php endif; ?>

    <a class="back-link" href="dashboard.php">⬅️ Back to Dashboard</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
