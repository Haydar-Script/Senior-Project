<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../login/login.php');
    exit();
}
?>

<head>
    <title>Sharing Is Caring - Home Page</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="../index.css">

    <script>
        let slideIndex = 0;

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 5000);
        }
    </script>
</head>

<body onload="showSlides()">
    <header>
        <div class="main-head">
            <h1>Sharing Is Caring</h1>
            <?php
            echo '<h3>' . $_SESSION['first_name'] . '</h3>'; ?>
            <div class="header-links-container">
                <form method="POST" action="../backend/signout.php">
                    <a href="../home-about/user-about.php">About</a>
                    <a href="../home-user/home.php" style="color:#4CAF50">Home</a>
                    <a href="../transportations-user/my-transportations.php">My Transportations</a>
                    <button class="sign-out-button" name="sign_out">Sign Out</button>
                </form>
            </div>
        </div>
    </header>

    <div class="slideshow-container">

        <div class="mySlides fade active">
            <img src="../images/carousel_1.jpg" style="width:100%">
            <h2 class="header-carousel">Explore the Great Outdoors</h2>
            <p class="text">Escape the city and immerse yourself in the natural beauty of our world-class destinations. From hiking in the mountains to camping by the beach, we've got you covered. Our comfortable and reliable buses will get you there safely and in style.</p>
        </div>

        <div class="mySlides fade">
            <img src="../images/carousel_2.jpg" style="width:100%">
            <h2 class="header-carousel">Hitting the Slopes</h2>
            <p class="text">Experience the thrill of skiing down some of the best slopes in the world. Whether you're a beginner or an expert, we have trips tailored to your level of skill. Our buses will take you straight to the mountains, so you can enjoy your trip without any worries.</p>
        </div>

        <div class="mySlides fade">
            <img src="../images/carousel_3.jpg" style="width:100%">
            <h2 class="header-carousel">Join the Celebration</h2>
            <p class="text">Discover unique cultural experiences and festivals in Lebanon. From the vibrant Beirut International Film Festival to the annual Al Bustan Festival, we've got it all. Our comfortable buses will take you to the heart of the action, so you can fully immerse yourself in the festivities.</p>
        </div>
    </div>


    <br>

    <main>
        <h2 style="padding-left: 60px; padding-bottom:40px; padding-top:40px;">How many trips you've taken so far:
            <?php
            include('../backend/connection.php');
            $user_id = (int)$_SESSION['id'];
            $transportations = "
                SELECT count(*) AS count 
                FROM transportations t
                JOIN rent_transportation rt ON rt.transport_id = t.id
                JOIN user u ON rt.user_id = u.id
                WHERE rt.status = 1 AND rt.user_id = '$user_id'
            ";
                        $results = mysqli_query($conn, $transportations);
            $row = mysqli_fetch_assoc($results);
            echo $row['count'] . " Trips";
            ?>
        </h2>
        <div class="transportation-container">

            <?php
            include('../backend/connection.php');
            $transportations = "SELECT * FROM transportations WHERE available_seats >0";
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
                        <form method="POST">
                            <input type="hidden" name="transport_id" value="' . $row['id'] . '">
                            <button name="rent-form" type="submit">Rent</button>
                        </form>
                    </div>
                </div>';
            }
            
            
            


            ?>
        </div>
    </main>
    <?php
if (isset($_POST['rent-form'])) {
    $user_id = $_SESSION['id'];
    $transport_id = $_POST['transport_id'];
    $value = 0;
    $transport_id = (int)$transport_id; // Cast to integer for safety
    $query = "SELECT * FROM transportations WHERE transport_id = $transport_id AND available_seats > 0";
                $results = mysqli_query($conn, $transportations);
$row = mysqli_fetch_assoc($results);
    $sql = "INSERT INTO rent_transportation (transport_id, user_id, admin_id, status) VALUES (?, ?, ?, ?)";
    $result = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($result, "iiii", $transport_id, $user_id, $row['admin_id'], $value);
   
    if (mysqli_stmt_execute($result)) {
        echo '<script>alert("A Rent request was sent");</script>';
    } else {
        echo "Error executing statement: " . mysqli_error($conn);
    }
}
    ?>
</body>