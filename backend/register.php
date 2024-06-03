<?php
include('./connection.php');

if (isset($_POST['submit-user']) || isset($_POST['submit-admin'])) {
    if (
        empty($_POST['f_name']) ||
        empty($_POST['l_name']) ||
        empty($_POST['email']) ||
        empty($_POST['phone_number']) ||
        empty($_POST['password']) ||
        empty($_POST['questions']) ||
        empty($_POST['answer'])
    ) {
        echo '<script>alert("Please fill all the fields");</script>';
        header('Location: ../register/register.html');
        exit();
    } else {
        $password_hashed = md5($_POST['password']);
        if (isset($_POST['submit-user'])) {
            $check_exists_sql = "SELECT * FROM user WHERE email = '" . $_POST['email'] . "'";
            $result = mysqli_query($conn, $check_exists_sql);

            if (mysqli_num_rows($result) > 0) {
                echo '<script>alert("email already exists");</script>';
                header('Location: ../register/register.html');
                exit();
            } else {

                $sql = "INSERT INTO user (email, first_name, last_name, password_hash, phone_number, question, answer)
               VALUES ('" . $_POST['email'] . "', '" . $_POST['f_name'] . "', '" . $_POST['l_name'] . "', '" . $password_hashed . "', '" . $_POST['phone_number'] . "', '" . str_replace("'", "\\'", $_POST['questions']) . "', '" . $_POST['answer'] . "')";



                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('User was registered');</script>";
                    header('Location: ../login/login.php');
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        } else {

            $check_exists_sql = "SELECT * FROM admin WHERE email = '" . $_POST['email'] . "'";
            $result = mysqli_query($conn, $check_exists_sql);


            if (mysqli_num_rows($result) > 0) {
                echo '<script>alert("email already exists");</script>';
                header('Location: ../register/register.html');
                exit();
            } else {
                $sql = "INSERT INTO admin (email, first_name, last_name, password_hash, phone_number, question, answer)
               VALUES ('" . $_POST['email'] . "', '" . $_POST['f_name'] . "', '" . $_POST['l_name'] . "', '" . $password_hashed . "', '" . $_POST['phone_number'] . "', '" . str_replace("'", "\\'", $_POST['questions']) . "', '" . $_POST['answer'] . "')";


                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('User was registered');</script>";
                    header('Location: ../login/login.php');
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    }
}
