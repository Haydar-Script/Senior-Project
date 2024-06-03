<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['user_type'] === "client") {
    header('Location: ../login/login.php');
    exit();
}
?>

<head>
    <title>Add Transporations</title>
    <link rel="stylesheet" href="add-transportations.css">
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
                    <a href="../admin-transportations/add-transportations.php" style="color:#4CAF50">Add</a>

                    <button class="sign-out-button" name="sign_out">Sign Out</button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <form method="POST" class="add-form">
            <label>Name:</label>
            <input type="text" name="name">
            <label>Price:</label>
            <input type="number" name="price">
            <label>From:</label>
            <input type="text" name="from">
            <label>To:</label>
            <input type="text" name="to">
            <label>Available Seats:</label>
            <input type="number" name="seats">
            <label>Departure time:</label>
            <input type="datetime-local" name="departure">
            <button name="add-form">Add Transportation</button>
        </form>
        <?php
        if (isset($_POST['add-form'])) {
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
                
                $admin_id = $_SESSION['id'];
                $sql = "INSERT INTO transportations (name, from_location, to_location, price, available_seats, departure_time, admin_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $result = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($result, "ssssisi", $_POST['name'], $_POST['from'], $_POST['to'], $_POST['price'], $_POST['seats'], $_POST['departure'], $admin_id);
                mysqli_stmt_execute($result);
                echo '<script>Data added successfully</script>';
            }
        }
        ?>
    </main>
</body>