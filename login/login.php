<head>
    <title>Sharing Is Caring - Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="../index.css">
</head>

<body class="main">
    <header>
        <div class="main-head">
            <h1>Sharing Is Caring</h1>
        </div>
    </header>
    <main>
        <!-- <h2>Login</h2> -->
        <form class="login-form" method="POST">
            <h2>Login</h2>
            <label>Email</label>
            <input type="email" name="email">
            <label>Password</label>
            <input type="password" name="password">
            <div class="reset-container">
                <p>Forgot Password? &nbsp; &nbsp; </p>
                <a href="../reset-password/resetPass.php">Reset Password</a>
            </div>
            <div class="reset-container">
                <p>Don't have an account? &nbsp; &nbsp; </p>
                <a href="../register/register.html">Register now</a>
            </div>
            <button id="login-submit" name="login-submit">Login</button>
        </form>

        <?php
        include('../backend/connection.php');

        // Initialize session
        session_start();

        // Check if user is already logged in, if so redirect to home page
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            $user_type = $_SESSION["user_type"] === 'admin' ? 'admin' : 'client';
            if ($user_type === 'admin') {
                header("location: ../admin-home/admin-home.php");
                exit();
            } else if ($user_type === 'client') {
                header("location: ../home-user/home.php");
                exit();
            }
        }

        if (isset($_POST['login-submit'])) {
            if (empty($_POST['email']) || empty($_POST['password'])) {
                echo '<script>alert("Please fill all fields");</script>';
            } else {
                $check_user_sql = "SELECT * FROM user WHERE email = '" . $_POST['email'] . "' AND password_hash = '" . md5($_POST['password']) . "' ";
                $result_user = mysqli_query($conn, $check_user_sql);

                $check_admin_sql = "SELECT * FROM admin WHERE email = '" . $_POST['email'] . "' AND password_hash = '" . md5($_POST['password']) . "' ";
                $result_admin = mysqli_query($conn, $check_admin_sql);


                if (mysqli_num_rows($result_user) > 0) {

                    $row = mysqli_fetch_assoc($result_user);
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row['id'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["first_name"] = $row['first_name'];
                    $_SESSION["last_name"] = $row['last_name'];
                    $_SESSION["user_type"] = 'client';

                    // echo $row['email'];
                    header('Location: ../home-user/home.php');
                    exit();
                } else if (mysqli_num_rows($result_admin) > 0) {

                    $row = mysqli_fetch_assoc($result_admin);
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row['id'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["first_name"] = $row['first_name'];
                    $_SESSION["last_name"] = $row['last_name'];
                    $_SESSION["user_type"] = 'admin';

                    // echo $row['email'];
                    header('Location: ../admin-home/admin-home.php');
                    exit();
                } else {
                    echo '<script>alert("Wrong email or password");</script>';
                }
            }
        } ?>
    </main>
</body>