<?php
// Database connection
// Start session to access session variables
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Enter your database password if set
$dbname = "login_register_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get JSON data from request
$data = json_decode(file_get_contents("php://input"), true);

// Check if session and required data exist
if (isset($_SESSION['username']) && isset($data['num_of_questions']) && isset($data['num_of_correct_answers'])) {
    $username = $_SESSION['username']; // Retrieve username from session
    $num_of_questions = (int)$data['num_of_questions'];
    $num_of_correct_answers = (int)$data['num_of_correct_answers'];

    // Query to get the student's name based on the username
    $nameQuery = "SELECT name FROM tbl_user WHERE username = '$username'";
    $result = $conn->query($nameQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_name = $row['name'];

        // Insert data into marks_card table with the student's name
        $sql = "INSERT INTO marks_card (student_id, num_of_questions, num_of_correct_answers) 
                VALUES ('$student_name', '$num_of_questions', '$num_of_correct_answers')";

        if ($conn->query($sql) === TRUE) {
            echo "Marks saved successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Student not found.";
    }
} else {
    echo "Invalid data received or user not logged in.";
}

$conn->close();

?>
