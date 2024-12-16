<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "contact_form");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // You don't need this for the "Thank You" page

// Insert form data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST['firstname'] ?? "Valued Guest");
    $email = htmlspecialchars($_POST['email'] ?? "No Email Provided");
    $country = htmlspecialchars($_POST['country'] ?? "No Country Provided");
    $subject = htmlspecialchars($_POST['subject'] ?? "No Subject Provided");

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO submissions (firstname, email, country, subject) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $email, $country, $subject);
    
    if ($stmt->execute()) {
        // Success message
        $message = "Thank you, $firstname! We've received your message and will get back to you at $email.";
    } else {
        // Error message
        $message = "There was an issue processing your request. Please try again later.";
    }

    $stmt->close();
} else {
    $message = "No data received. Please go back and submit the form again.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
            padding: 50px;
        }
        .thank-you-message {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: inline-block;
            max-width: 500px;
        }
        h1 {
            color: #04AA6D;
        }
    </style>
</head>
<body>
    <div class="thank-you-message">
        <h1>Thank You!</h1>
        <p><?php echo $message; ?></p>
        <p><a href="home.html">Return to Homepage</a></p>
    </div>
</body>
</html>
