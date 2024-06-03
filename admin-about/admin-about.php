<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['user_type'] === "client") {
    header('Location: ../login/login.php');
    exit();
}
?>

<head>
    <Title>About us</Title>
    <link rel="stylesheet" href="admin-about.css">
    <link rel="stylesheet" href="../index.css">
</head>

<body class="main">
    <header>
        <div class="main-header">
            <h1>Sharing Is Caring</h1>
            <?php echo '<h3>' . $_SESSION['first_name'] . '</h3>'; ?>
            <div class="header-links-container">
                <form method="POST" action="../backend/signout.php">
                    <a href="../admin-about/admin-about.php" style="color:#4CAF50">About</a>
                    <a href="../admin-home/admin-home.php">Home</a>
                    <a href=" ../admin-rentees/admin-rentees.php">Rentees</a>
                    <a href="../admin-transportations/add-transportations.php">Add</a>

                    <button class="sign-out-button" name="sign_out">Sign Out</button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <div class="about-us-container">
            <div class="about-us">
                <h2>Welcome to Sharing is Caring,</h2>
                <p>
                    your premier transportation service provider. We specialize in providing
                    reliable, safe, and comfortable transportation solutions to individuals in Lebanon.
                </p>

                <p>
                    Our team consists of experienced professionals who are committed to providing you with the highest
                    quality service. We have a fleet of well-maintained vehicles that are equipped with the latest
                    technology to ensure your safety and comfort on every trip.
                </p>

                <p>
                    At Sharing is Caring, we understand the importance of timely and efficient transportation. Whether
                    you
                    need airport transportation, corporate travel, or special event transportation, we can provide you
                    with
                    a customized solution that meets your specific needs.
                </p>

                <p>
                    We are dedicated to providing our clients with exceptional customer service, and we strive to exceed
                    your expectations with every interaction. Our goal is to make your transportation experience as
                    seamless
                    and stress-free as possible.
                </p>

                <p>
                    Thank you for choosing Sharing is Caring for your transportation needs. We look forward to serving
                    you
                    and providing you with a superior transportation experience.
                </p>

            </div>
        </div>
    </main>
</body>