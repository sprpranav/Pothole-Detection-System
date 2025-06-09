<?php
require 'vendor/autoload.php';
use Twilio\Rest\Client;

// Twilio Credentials
$sid = "YOUR_TWILIO_API_KEY";
$token = "YOUR_TWILIO_API_KEY";
$twilio = new Client($sid, $token);

$messageStatus = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = htmlspecialchars($_POST['location']);

    try {
        $message = $twilio->messages->create(
            "whatsapp:+918870910549", // Your WhatsApp number
            [
                "from" => "whatsapp:+14155238886", // Twilio Sandbox number
                "body" => "🚧 Pothole Detected! Location: $location"
            ]
        );

        $messageStatus = "✅ Complaint sent via WhatsApp successfully!";
    } catch (Exception $e) {
        $messageStatus = "❌ Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send WhatsApp Complaint - Pothole Detection</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .complaint-container {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        .complaint-container h2 {
            margin-bottom: 30px;
            font-weight: bold;
            color: #333;
        }
        .complaint-container input {
            margin-bottom: 20px;
        }
        .complaint-container button {
            width: 100%;
            padding: 10px;
            font-size: 18px;
        }
        .status-message {
            margin-top: 20px;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="complaint-container">
    <h2>Send Pothole Complaint</h2>

    <?php if (!empty($messageStatus)) : ?>
        <div class="status-message">
            <?php echo $messageStatus; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input class="form-control" type="text" name="location" placeholder="Enter Location" required>
        <button class="btn btn-primary mt-3" type="submit">Send WhatsApp Complaint</button>
    </form>

    <a class="btn btn-link mt-3" href="dashboard.php">⬅️ Back to Dashboard</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
