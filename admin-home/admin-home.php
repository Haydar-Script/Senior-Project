<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['user_type'] === "client") {
    header('Location: ../login/login.php');
    exit();
}
?>

<head>
    <Title>Admin Home</Title>
    <link rel="stylesheet" href="admin-home.css">
    <link rel="stylesheet" href="../index.css">
</head>

<body>
    <header>
        <div class="main-header">
            <h1>Sharing Is Caring</h1>
            <?php
            echo '<h3>' . $_SESSION['first_name'] . '</h3>'; ?>
            <div class="header-links-container">
                <form method="POST" action="../backend/signout.php">
                    <a href="../admin-about/admin-about.php">About</a>
                    <a href="../admin-home/admin-home.php" style="color:#4CAF50">Home</a>
                    <a href=" ../admin-rentees/admin-rentees.php">Rentees</a>
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
            $transportations = "SELECT * FROM transportations WHERE admin_id = '" . $_SESSION['id'] . "' ";
            $results = mysqli_query($conn, $transportations);
            while ($row = mysqli_fetch_assoc($results)) {
                echo '<div class="transportation-card">
                    <div class="transportation-card-left">
                        <h1>#' . $row['id'] . '</h1>
                        <h2>name:' . $row['name'] . '</h2>
                        <h4>price: $' . $row['price'] . '</h4>
                        <h4>departure time: ' . $row['departure_time'] . '</h4>
                    </div>
                    <div class="transportation-card-right">
                        <h2>from: ' . $row['from_location'] . '</h2>
                        <h2>to: ' . $row['to_location'] . '</h2>
                        <h4>available seats: ' . $row['available_seats'] . '</h4>
                        <div style="display:flex;width:300px;justify-content:space-between">
                        <form method="POST" action="../edit-transportations/edit-transportations.php?id=' . $row['id'] . '" style="flex:1;padding:0 5px;">
                            <button type="submit">Edit</button>
                        </form>
                        <form method="POST" style="flex:1;padding:0 5px;">
                            <button id="delete-button" name="delete-form" type="submit">Delete</button>
                        </form>
                        </div>
                    </div>
                </div>
                ';

                if (isset($_POST['delete-form'])) {
                    $admin_id = $_SESSION['id'];
                    $sql = "DELETE FROM transportations WHERE id =?";
                    $result = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($result, "i", $row['id']);
                    mysqli_stmt_execute($result);
                    exit();
                }
            }
            ?>
        </div>
    </main>
</body>