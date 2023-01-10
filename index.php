<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
}
$errors = []; // setting this variable for user's error
define('ERROR_MSG', 'This field is required');
require_once "valid.php";
$firstname = "";
$lastname = "";
$username = "";
$email = "";
$password = "";
$cpass = "";
$address = "";
$dob = "";
$telephone = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // accepting user's data through the $_POST global variable
    $firstname = Valid_input($_POST['firstname']);
    $lastname = Valid_input($_POST['lastname']);
    $username = Valid_input($_POST['username']);
    $email = Valid_input($_POST['email']);
    $password = Valid_input($_POST['password']);
    $cpass = Valid_input($_POST['cpass']);
    $dob = Valid_input($_POST['dob']);
    $address = Valid_input($_POST['address']);
    $telephone = Valid_input($_POST['phone_number']);

    // validating user credentials
    if (!$firstname) {
        $errors['firstname'] = ERROR_MSG;
    }

    if (!$lastname) {
        $errors['lastname'] = ERROR_MSG;
    }

    if (!$username) {
        $errors['username'] = ERROR_MSG;
    }

    if (!$email) {
        $errors['email'] = ERROR_MSG;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email";
    }

    if (!$password) {
        $errors['password'] = ERROR_MSG;
    } elseif (strlen($password) <= 4) {
        $errors['password'] = "Your password length is too low";
    }

    if (!$cpass) {
        $errors['cpass'] = ERROR_MSG;
    } elseif ($cpass !== $password) {
        $errors['cpass'] = "Password does not match";
    }

    if (!$dob) {
        $errors['dob'] = ERROR_MSG;
    }

    if (!$address) {
        $errors['address'] = ERROR_MSG;
    }

    if (!$telephone) {
        $errors['phone_number'] = ERROR_MSG;
    }

    // if the error is empty, insert the credential into the database
    if (empty($errors)) {
        require_once "dbconfig.php";

        $query = "INSERT INTO customers(firstname, lastname, username, email, `password`, address, dob, telephone) VALUES(:firstname, :lastname, :username, :email, :password, :address, :dob, :telephone);";

        $hash_pass = password_hash($password, PASSWORD_DEFAULT);

        $sql = $conn->prepare($query);
        $sql->bindValue(":firstname", $firstname);
        $sql->bindValue(":lastname", $lastname);
        $sql->bindValue(":username", $username);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":password", $hash_pass);
        $sql->bindValue(":address", $address);
        $sql->bindValue(":dob", $dob);
        $sql->bindValue(":telephone", $telephone);

        $sql->execute();

        echo "You are successfully registerd, you can now login!!!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Register</title>

    <style>
    .error {
        color: red;
    }

    .border-red {
        border: 1px solid red;
    }
    </style>
</head>

<body>
    <h2>Register Here</h2>
    <form action="" method="post">
        <label for="">Firstname</label><br>
        <input type="text" name="firstname" class="<?php echo isset($errors['firstname']) ? 'border-red' : "" ?>"
            value="<?php echo $firstname ?? "" ?>">
        <small class="error">
            <?= $errors['firstname'] ?? '' ?>
        </small>
        <br>
        <label for="">Lastname</label><br>
        <input type="text" name="lastname" class="<?php echo isset($errors['lastname']) ? 'border-red' : "" ?>"
            value="<?= $lastname ?? '' ?>">
        <small class="error">
            <?= $errors['lastname'] ?? '' ?>
        </small>
        <br>
        <label for="">Username</label><br>
        <input type="text" name="username" class="<?php echo isset($errors['username']) ? 'border-red' : "" ?>"
            value="<?= $username ?? '' ?>">
        <small class="error">
            <?= $errors['username'] ?? '' ?>
        </small>
        <br>
        <label for="">Email</label><br>
        <input type="text" name="email" class="<?php echo isset($errors['email']) ? 'border-red' : "" ?>"
            value="<?= $email ?? '' ?>">
        <small class="error">
            <?= $errors['email'] ?? '' ?>
        </small>
        <br>
        <label for="">Password</label><br>
        <input type="password" name="password" class="<?php echo isset($errors['password']) ? 'border-red' : "" ?>"
            value="">
        <small class="error">
            <?= $errors['password'] ?? '' ?>
        </small>
        <br>
        <label for="">Repeat Password</label><br>
        <input type="password" name="cpass" class="<?php echo isset($errors['cpass']) ? 'border-red' : "" ?>" id="">
        <small class="error">
            <?= $errors['cpass'] ?? '' ?>
        </small>
        <br>
        <label for="">Address</label><br>
        <input type="text" name="address" class="<?php echo isset($errors['address']) ? 'border-red' : "" ?>"
            value="<?= $address ?? '' ?>">
        <small class="error">
            <?= $errors['address'] ?? '' ?>
        </small>
        <br>
        <label for="">Date of Birth</label><br>
        <input type="date" name="dob" class="<?php echo isset($errors['dob']) ? 'border-red' : "" ?>"
            value="<?= $dob ?? '' ?>">
        <small class="error">
            <?= $errors['dob'] ?? '' ?>
        </small>
        <br>
        <label for="">Telephone</label><br>
        <input type="number" name="phone_number"
            class="<?php echo isset($errors['phone_number']) ? 'border-red' : "" ?>" value="<?= $telephone ?? '' ?>">
        <small class="error">
            <?= $errors['phone_number'] ?? '' ?>
        </small>
        <br><br>

        <button>submit</button>
    </form>
</body>

</html>

<?php

$firstname = "";
$lastname = "";
$username = "";
$email = "";
$password = "";
$cpass = "";
$address = "";
$dob = "";
$telephone = "";
?>