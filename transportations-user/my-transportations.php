<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../login/login.php');
    exit();
}
?>

<head>
    <title>Sharing Is Caring - Home Page</title>
    <link rel="stylesheet" href="my-transportations.css">
    <link rel="stylesheet" href="../index.css">
</head>

<body>
    <header>
        <div class="main-head">
            <h1>Sharing Is Caring</h1>
            <?php echo '<h3>' . $_SESSION['first_name'] . '</h3>'; ?>
            <div class="header-links-container">
                <form method="POST" action="../backend/signout.php">

                    <a href="../home-about/user-about.php">About</a>
                    <a href="../home-user/home.php">Home</a>
                    <a href="../transportations-user/my-transportations.php" style="color:#4CAF50">My
                        Transportations</a>
                    <button class="sign-out-button" name="sign_out">Sign Out</button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <div class="transportation-container">
            <?php
            include('../backend/connection.php');
            $user_id = (int)$_SESSION['id'];
$transportations = "
    SELECT t.*, u.*, rt.* 
    FROM transportations t
    JOIN rent_transportation rt ON rt.transport_id = t.id
    JOIN user u ON rt.user_id = u.id
    WHERE rt.user_id = '$user_id'
";
            $results = mysqli_query($conn, $transportations);
            while ($row = mysqli_fetch_assoc($results)) {
                $status = "pending";
                if ($row['status'] == 0) {
                    $status = "pending";
                } else if ($row['status'] == 1) {
                    $status = "accepted";
                } else {
                    $status = "rejected";
                }
                echo '<div class="transportation-card">
                    <div class="transportation-card-left">
                    
                    <h1>#' . $row['id'] . '</h1>
                    <h2>name:' . $row['name'] . '</h2>
                    <h4>price: $' . $row['price'] . '</h4>
                    <h4>departure time: ' . $row['departure_time'] . '</h4>
                    <h4>status: ' . $status . '</h4>
                    </div>
                    <div class="transportation-card-right">
                        <h2>from: ' . $row['from_location'] . '</h2>
                        <h2>to: ' . $row['to_location'] . '</h2>
                        <h4>available seats: ' . $row['available_seats'] . '</h4>
                        <form method="POST">
                            <button name="cancel-transportation-' . $row['id'] . '" type="submit">Cancel transportation</button>
                        </form>
                    </div>
                </div>
                ';

                if (isset($_POST['cancel-transportation-' . $row['id']])) {
                    include('../backend/connection.php');
                    $sql = "DELETE FROM rent_transportation WHERE id=? AND user_id=?";
                    $result = mysqli_prepare($conn, $sql);
                    $value = 2;
                    mysqli_stmt_bind_param($result, "ii", $row['id'], $_SESSION['id']);
                    mysqli_stmt_execute($result);
                    mysqli_stmt_close($result);
                    $transportation = "SELECT * FROM transportations WHERE id='" . $row['transport_id'] . "'";
                    $results = mysqli_query($conn, $transportation);
                    if (mysqli_num_rows($results) < 1) {
                        echo "<script>alert('not found');</script>";
                    } else {
                        while ($row_transport = mysqli_fetch_assoc($results)) {
                            $seats = $row_transport['available_seats'];
                            $seatsminus1 = $seats + 1;
                            $sql = "UPDATE transportations SET available_seats=? WHERE id=?";
                            $result = mysqli_prepare($conn, $sql);
                            $value = 2;
                            mysqli_stmt_bind_param($result, "ii", $seatsminus1, $row['transport_id']);
                            mysqli_stmt_execute($result);
                        }
                        mysqli_close($conn);
                        header('location: ../transportations-user/my-transportations.php');
                    }
                }
            }
            ?>
        </div>
    </main>
</body>