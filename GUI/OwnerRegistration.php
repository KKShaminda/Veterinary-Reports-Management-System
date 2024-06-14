<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vet";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $address = trim($_POST['address']);
    $nicNumber = trim($_POST['nicNumber']);
    $mobilePhone = trim($_POST['mobilePhone']);
    $homePhone = trim($_POST['homePhone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validate inputs
    if (empty($firstName) || empty($lastName) || empty($mobilePhone) || empty($homePhone) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "Please fill out all required fields.";
        exit();
    }

    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prevent SQL injection
    $firstName = $conn->real_escape_string($firstName);
    $lastName = $conn->real_escape_string($lastName);
    $address = $conn->real_escape_string($address);
    $nicNumber = $conn->real_escape_string($nicNumber);
    $mobilePhone = $conn->real_escape_string($mobilePhone);
    $homePhone = $conn->real_escape_string($homePhone);
    $email = $conn->real_escape_string($email);

// SQL insert statement
$sql = "INSERT INTO users (first_name, last_name, address, nic_number, mobile_phone, home_phone, email, password)
        VALUES ('$firstName', '$lastName', '$address', '$nicNumber', '$mobilePhone', '$homePhone', '$email', '$hashedPassword')";
    if ($conn->query($sql) === TRUE) {
         // Display success message and redirect
            echo "<script>
                alert('New user registered successfully.');
                window.location.href = 'login.html';
                </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
