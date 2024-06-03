<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['user_type'] === "client") {
    header('Location: ../login/login.php');
    exit();
}
?>

<head>
    <Title>Admin Home - Rentees</Title>
    <link rel="stylesheet" href="admin-rentees.css">
    <link rel="stylesheet" href="../index.css">
</head>

<body>
    <header>
        <div class="main-header">
            <h1>Sharing Is Caring</h1>
            <?php echo '<h3>' . $_SESSION['first_name'] . '</h3>'; ?>
            <div class="header-links-container">
                <form method="POST" action="../backend/signout.php">

                    <a href="../admin-about/admin-about.php">About</a>
                    <a href="../admin-home/admin-home.php">Home</a>
                    <a href=" ../admin-rentees/admin-rentees.php" style="color:#4CAF50">Rentees</a>
                    <a href="../admin-transportations/add-transportations.php">Add</a>

                    <button class="sign-out-button" name="sign_out">Sign Out</button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <div class="transportation-container">


            <?php
            include('../backend/connection.php');
            $admin_id = (int)$_SESSION['id'];
            $transportations = "
                SELECT t.*, u.*, rt.* 
                FROM transportations t
                JOIN rent_transportation rt ON rt.transport_id = t.id
                JOIN user u ON rt.user_id = u.id
                WHERE rt.status = 0 AND rt.admin_id = '$admin_id'
            ";  
                      $results = mysqli_query($conn, $transportations);
            while ($row = mysqli_fetch_assoc($results)) {
                echo '<div class="transportation-card">
                    <div class="transportation-card-left">
                        <h1>#' . $row['id'] . '</h1>
                        <h2>first name: ' . $row['first_name'] . '</h2>
                        <h4>last name: ' . $row['last_name'] . '</h4>
                    </div>
                    <div class="transportation-card-right">
                        <h2>from: ' . $row['from_location'] . '</h2>
                        <h2>to: ' . $row['to_location'] . '</h2>
                        <form method="POST">
                            <button name="accept-form-'.$row['id'].'" type="submit">Accept</button>
                        </form>
                        <form method="POST">
                            <button class="reject-button" name="reject-form-'.$row['id'].'" type="submit">Reject</button>
                        </form>
                    </div>
                </div>
                ';

                if (isset($_POST['reject-form-'.$row['id']])) {
                    include('../backend/connection.php');
                    $sql = "UPDATE rent_transportation SET status=? WHERE id=?";
                    $result = mysqli_prepare($conn, $sql);
                    $value = 2;
                    mysqli_stmt_bind_param($result, "ii", $value, $row['id']);
                    mysqli_stmt_execute($result);
                    mysqli_stmt_close($result);
                    mysqli_close($conn);

                    header('location: ../admin-rentees/admin-rentees.php');
                } else if (isset($_POST['accept-form-'.$row['id']])) {
                    $sql = "UPDATE rent_transportation SET status=? WHERE id=?";
                    $result = mysqli_prepare($conn, $sql);
                    $value = 1;
                    mysqli_stmt_bind_param($result, "ii", $value, $row['id']);
                    mysqli_stmt_execute($result);

                    $transportation = "SELECT * FROM transportations WHERE id='" . $row['transport_id'] . "'";
                    $results = mysqli_query($conn, $transportation);
                    if(mysqli_num_rows($results) < 1) {
                        echo "<script>alert('not found');</script>";
                    }
                    while ($row_transport = mysqli_fetch_assoc($results)) {
                        $seats = $row_transport['available_seats'];
                        if ($seats > 0) {
                            $seatsminus1 = $seats - 1;
                            $sql = "UPDATE transportations SET available_seats=? WHERE id=?";
                            $result = mysqli_prepare($conn, $sql);
                            $value = 2;
                            mysqli_stmt_bind_param($result, "ii", $seatsminus1, $row['transport_id']);
                            mysqli_stmt_execute($result);
                        }
                    }
                    mysqli_close($conn);
                    header('location: ../admin-rentees/admin-rentees.php');
                }
            }
            ?>
        </div>
    </main>
</body>