<?php
session_start();

include_once('connection.php');


if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];  // No MD5 hashing

    if (empty($username) && empty($password)) {
        echo "<script>alert('Please Fill Username and Password');</script>";
        exit;
    } elseif (empty($password)) {
        echo "<script>alert('Please Fill Password');</script>";
        exit;
    } elseif (empty($username)) {
        echo "<script>alert('Please Fill Username');</script>";
        exit;
    } else {
        // Query to check if the user exists with the plain text password
        $sql = "SELECT * FROM `tbl_user` WHERE `username`='$username' AND `password`='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $_SESSION['name'] = $row['name'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            header('location:adv.html');
            exit;
        } else {
            echo "<script>alert('Invalid Username or Password');</script>";
            exit;
        }
    }
}
