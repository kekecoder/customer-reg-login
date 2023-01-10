<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
}
require_once "valid.php";
ini_set("error_report", 1);
$errors = [];
define("ERROR_MSG", "This field is required");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = Valid_input($_POST['username']);
    $password = Valid_input($_POST['password']);

    // Validate user's input
    if (!$username) {
        $errors['username'] = ERROR_MSG;
    }

    if (!$password) {
        $errors['password'] = ERROR_MSG;
    } elseif (strlen($password) <= 4) {
        $errors['password'] = "Your password length is too low";
    }

    if (empty($errors)) {
        require_once "dbconfig.php";

        $query = ("SELECT * FROM customers WHERE username = :username");

        if ($stmt = $conn->prepare($query)) {
            $stmt->bindValue(":username", $username);
            if ($stmt->execute()) {
                if ($stmt->rowCount() === 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row['id'];
                        $firstname = $row['firstname'];
                        $lastname = $row['lastname'];
                        $username = $row['username'];
                        $hashed_pass = $row['password'];

                        if (password_verify($password, $hashed_pass)) {
                            $_SESSION['username'] = $username;
                            $_SESSION['firstname'] = $firstname;
                            $_SESSION['lastname'] = $lastname;
                            $_SESSION['password'] = $password;

                            header("Location: dashboard.php");
                        } else {
                            echo "Inavalid credentials";
                        }
                    }
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login HERE</title>
    <style>
    .error {
        color: red;
    }
    </style>
</head>

<body>
    <h2>Login Here</h2>
    <form action="" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="">
        <small class="error">
            <?= $errors['username'] ?? "" ?>
        </small>
        <br> <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="">
        <small class="error">
            <?= $errors['username'] ?? "" ?>
        </small>
        <br>

        <button>Login</button>

    </form>
</body>

</html>