<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sharing_is_caring";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
