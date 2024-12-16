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
    $name = $_POST['name'];     // User's name
    $email = $_POST['email'];   // User's email
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Secure password hashing

    // Prepare and bind the SQL query
    $sql = "INSERT INTO accounts_log (name, email, password) VALUES ('name', 'email', 'password')";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters (s = string, s = string, s = string)
    $stmt->bind_param("sss", $name, $email, $password);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to a success page (like a thank you page)
        header("Location: actionpage.php?status=success");
        exit(); // Make sure to call exit() to stop script execution
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>




