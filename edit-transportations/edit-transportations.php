<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['user_type'] === "client") {
    header('Location: ../login/login.php');
    exit();
}
?>


<head>
    <title>Edit Transportations</title>
    <link rel="stylesheet" href="edit-transportations.css">
    <link rel="stylesheet" href="../index.css">
</head>

<body>
    <header>
        <div class="main-head">
            <h1>Sharing Is Caring</h1>
            <?php echo '<h3>' . $_SESSION['first_name'] . '</h3>'; ?>
            <div class="header-links-container">
                <form method="POST" action="../backend/signout.php">

                    <a href="../admin-about/admin-about.php">About</a>
                    <a href="../admin-home/admin-home.php">Home</a>
                    <a href=" ../admin-rentees/admin-rentees.php">Rentees</a>
                    <a href="../admin-transportations/add-transportations.php">Add</a>
                    <button class="sign-out-button" name="sign_out">Sign Out</button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <form method="POST" class="edit-form">
            <?php
            include('../backend/connection.php');
            $transportations = "SELECT * FROM transportations WHERE id = '" . $_GET['id'] . "' ";
            $results = mysqli_query($conn, $transportations);
            while ($row = mysqli_fetch_assoc($results)) {
                echo '
                <label>Name:</label>
                <input type="text" value="' . $row['name'] . '" name="name">
                <label>Price:</label>
                <input type="number" value="' . $row['price'] . '" name="price">
                <label>From:</label>
                <input type="text"  value="' . $row['from_location'] . '" name="from">
                <label>To:</label>
                <input type="text"  value="' . $row['to_location'] . '"  name="to">
                <label>Available Seats:</label>
                <input type="number"  value="' . $row['available_seats'] . '" name="seats">
                <label>Departure time:</label>
                <input type="datetime-local"  value="' . $row['departure_time'] . '"  name="departure">
                <button type="submit" name="edit-form">Edit Transportation</button>
            ';
            }
            ?>
        </form>
        <?php


        if (isset($_POST['edit-form'])) {
            if (
                empty($_POST['name']) ||
                empty($_POST['price']) ||
                empty($_POST['from']) ||
                empty($_POST['to']) ||
                empty($_POST['seats']) ||
                empty($_POST['departure'])
            ) {
                echo '<script>alert("Please fill all the fields");</script>';
            } else {
                include('../backend/connection.php');
                session_start();
                $sql = "UPDATE transportations SET name=?, from_location=?, to_location=?, price=?, available_seats=?, departure_time=? WHERE id=?";
                $result = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($result, "ssssisi", $_POST['name'], $_POST['from'], $_POST['to'], $_POST['price'], $_POST['seats'], $_POST['departure'], $_GET['id']);
                mysqli_stmt_execute($result);
                mysqli_stmt_close($result);
                mysqli_close($conn);
                header('Location:  ../admin-home/admin-home.php');
                exit();
                // echo '<script>Data updated successfully</script>';
            }
        } ?>
    </main>
</body>