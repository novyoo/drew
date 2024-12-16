<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";  // Your database name for login system

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];    // User's email
    $password = $_POST['password'];  // User's password

    // Prep"are the SQL query
    $sql = "INSERT INTO accounts_log (email, password) VALUES ('$email', '$password')";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind the email parameter
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and password is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Login successful
            echo "Login successful! Welcome, " . htmlspecialchars($row['name']) . ".";
            // Optionally, redirect to a dashboard page
            header("Location: dashboard.php");  // Redirect to a member's page
            exit();
        } else {
            // Invalid password
            echo "Invalid email or password.";
        }
    } else {
        // Invalid email
        echo "Invalid email or password.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>




