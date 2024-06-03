
<?php
if (isset($_POST['sign_out'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../login/login.php"); // Redirect to the login page
    exit();
}
?>