<head>
    <Title>Reset Password</Title>
    <link rel="stylesheet" href="../index.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }


        .main {
            background-image: url('../images/background-image.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }

        .main-head {
            /* background-color: #101058; */
            padding: 10px;
        }

        .main-head h1 {
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: white;
            text-transform: uppercase;
        }

        h2 {
            /* text-align: center;
            color: rgb(45, 45, 70) !important;
            margin-top: 50px;
            font-weight: 500; */

            color: rgb(45, 45, 70);
            width: 200px;
            padding: 10px;
            font-weight: 500;
            font-size: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        label {
            font-family: 'Courier New', Courier, monospace;
        }

        input {
            width: 300px;
            padding: 7px;
            outline: none;
            border: none;
            border-bottom: 1px solid silver;
        }

        #password-submit {
            width: 200px;
            border: none;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            color: white;
            border: 1px solid rgb(45, 45, 70);
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 0.95em;
            padding: 10px;
            background-color: rgb(45, 45, 70);
            /* background-color:rgb(5, 5, 20); */
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.5s ease;
        }



        #password-submit:hover {
            background-color: #fff !important;
            color: rgb(45, 45, 70) !important;
        }

        .container {
            margin-top: 20px;
        }

        .container form {
            background-color: #fff;
            padding: 60px 60px;
            border-radius: 30px;
        }
    </style>
</head>

<body class="main">
    <header>
        <div class="main-head">
            <h1>Sharing Is Caring</h1>
        </div>
    </header>
    <div class="container">
        <form method="POST">
            <h2>Reset Password</h2>
            <label>Email</label>
            <input type="email" name="email">
            <label>What's The Name Of Your First Pet?</label>
            <input type="text" name="answer">
            <label>New password</label>
            <input type="password" name="password">
            <button id="password-submit" name="password-submit">Submit</button>
        </form>
        <?php
        include('../backend/connection.php');

        if (isset($_POST['password-submit'])) {
            if (
                empty($_POST['email']) ||
                empty($_POST['answer']) ||
                empty($_POST['password'])
            ) {
                echo '<script>alert("Please fill all the fields");</script>';
                // header('Location: ../reset-password/resetPass.php');
                exit();
            } else {
                $user_sql = "SELECT * FROM user WHERE email = '" . $_POST['email'] . "' AND answer = '" . $_POST['answer'] . "'";
                $admin_sql = "SELECT * FROM admin WHERE email = '" . $_POST['email'] . "' AND answer = '" . $_POST['answer'] . "'";

                $user_result = mysqli_query($conn, $user_sql);
                $admin_result = mysqli_query($conn, $admin_sql);
                if (mysqli_num_rows($user_result) > 0) {

                    $password_hashed = md5($_POST['password']);
                    $sql = "UPDATE user SET password_hash = '$password_hashed' WHERE email = '" . $_POST['email'] . "'";
                    mysqli_query($conn, $sql);
                    echo "<script>alert('Password was reset');</script>";
                    // header('Location: ../login/login.php');
                    exit();
                } else if (mysqli_num_rows($admin_result) > 0) {

                    $password_hashed = md5($_POST['password']);
                    $sql = "UPDATE admin SET password_hash = '$password_hashed' WHERE email = '" . $_POST['email'] . "'";
                    mysqli_query($conn, $sql);
                    echo "<script>alert('Password was reset');</script>";
                    // header('Location: ../login/login.php');
                    exit();
                } else {

                    echo "<script>alert('User was not found or answer is wrong');</script>";
                    // header('Location: ../reset-password/resetPass.html');
                    exit();
                }
            }
        }

        ?>
    </div>
</body>