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
    $petName = trim($_POST['petName']);
    $age = trim($_POST['age']);
    $kind = trim($_POST['kind']);
    $breed = trim($_POST['breed']);
    $gender = trim($_POST['gender']);
    $color = trim($_POST['color']);

    // Prevent SQL injection
    $petName = $conn->real_escape_string($petName);
    $age = $conn->real_escape_string($age);
    $kind = $conn->real_escape_string($kind);
    $breed = $conn->real_escape_string($breed);
    $gender = $conn->real_escape_string($gender);
    $color = $conn->real_escape_string($color);

    // Insert the pet data into the database
    $sql = "INSERT INTO pets (petName, age, kind, breed, gender, color) VALUES ('$petName', '$age', '$kind', '$breed', '$gender', '$color')";

    if ($conn->query($sql) === TRUE) {
        // Display success message and redirect
        echo "<script>
            alert('Pet registered successfully.');
            window.location.href = 'home.html';
            </script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "'); window.location.href='register.html';</script>";
    }
}

$conn->close();
?>
