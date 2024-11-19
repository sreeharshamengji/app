<?php
include_once('connection.php');

if(isset($_POST['register']))
{
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statement
    $sql = "INSERT INTO `tbl_user`(`name`, `username`, `password`) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sss", $name, $username, $password);

    if(mysqli_stmt_execute($stmt)) {
        header('location:index.php');
        echo "<script>alert('New User Registered Successfully');</script>";
    } else {
        echo "<script>alert('This Website Is Under Maintenance. Please Try Latter: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

