<?php
require 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check_sql = "SELECT id FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $message = "⚠️ Email already registered. <a href='index.php'>Login here</a>";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $message = "✅ Registration successful! <a href='index.php'>Login here</a>";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pothole Detection</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #ff758c, #ff7eb3);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        .register-container h2 {
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
        }
        .register-container input {
            margin-bottom: 20px;
        }
        .register-container button {
            width: 100%;
            padding: 10px;
            font-size: 18px;
        }
        .login-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link:hover {
            text-decoration: underline;
        }
        .message {
            margin-bottom: 15px;
            font-weight: bold;
            color: green;
        }
        .error-message {
            margin-bottom: 15px;
            font-weight: bold;
            color: red;
        }
        .error-message a {
            color: red;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Register</h2>

    <?php if (!empty($message)) : ?>
        <div class="<?php echo (strpos($message, 'successful') !== false) ? 'message' : 'error-message'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <input class="form-control" type="text" name="name" placeholder="Full Name" required>
        </div>
        <div class="mb-3">
            <input class="form-control" type="email" name="email" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input class="form-control" type="password" name="password" placeholder="Password" required>
        </div>
        <button class="btn btn-success" type="submit">Register</button>
    </form>

    <a class="login-link" href="index.php">Already have an account? Login</a>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
