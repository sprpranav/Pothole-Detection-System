<?php
session_start();
require 'config.php';
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pothole Detection - Upload Image</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .upload-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        .upload-container h2 {
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
        }
        .upload-container input[type="file"] {
            margin-bottom: 20px;
        }
        .upload-container button {
            width: 100%;
            padding: 10px;
            font-size: 18px;
        }
        .logout-link {
            display: block;
            margin-top: 20px;
            color: #ff4b5c;
            text-decoration: none;
            font-weight: 600;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="upload-container">
    <h2>Upload Road Image for<br>Pothole Detection</h2>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input class="form-control" type="file" name="image" required>
        <br>
        <button class="btn btn-primary" type="submit">Upload & Check Pothole</button>
    </form>

    <a class="logout-link" href="logout.php">Logout</a>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
