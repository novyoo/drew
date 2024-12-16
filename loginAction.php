<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "login");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // You don't need this for the "Thank You" page

// Insert form data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['firstname'] ?? "Valued Guest");
    $email = htmlspecialchars($_POST['email'] ?? "No Email Provided");
    $password = htmlspecialchars($_POST['password'] ?? "Oops wrong");

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO accounts_log (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        // Success message
        $status = 'signup_success'; // or 'login_success' based on context
        $message = "Thank you, $name! You have successfully logged in or signed up.";
    } else {
        // Error message
        $status = 'error';
        $message = "There was an issue processing your request. Please try again later.";
    }

    $stmt->close();
} else {
    $status = 'error';
    $message = "There was an issue with the process. Please try again later.";
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
            padding: 50px;
        }
        .message {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: inline-block;
            max-width: 500px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <div class="message <?php echo $status === 'signup_success' || $status === 'login_success' ? 'success' : 'error'; ?>">
        <?php
        if ($status == 'login_success') {
            echo "<h1>Login Successful!</h1><p>Welcome back, you are successfully logged in.</p>";
        } elseif ($status == 'signup_success') {
            echo "<h1>Sign Up Successful!</h1><p>Congratulations! Your account has been created successfully. You can now log in.</p>";
        } else {
            echo "<h1>Error</h1><p>There was an issue with the process. Please try again.</p>";
        }
        ?>
        <p><a href="home.html">Go to Home Page</a></p>
    </div>


</body>
</html>
