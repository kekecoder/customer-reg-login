<?php
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
    </style>
</head>

<body>
    <h2>Register Here</h2>
    <form action="" method="post">
        <label for="">Firstname</label><br>
        <input type="text" name="firstname" class="" value="<?php echo $firstname ?? "" ?>">
        <small class="error">
            <?= $errors['firstname'] ?? '' ?>
        </small>
        <br>
        <label for="">Lastname</label><br>
        <input type="text" name="lastname" value="<?= $lastname ?? '' ?>">
        <small class="error">
            <?= $errors['lastname'] ?? '' ?>
        </small>
        <br>
        <label for="">Username</label><br>
        <input type="text" name="username" value="<?= $username ?? '' ?>">
        <small class="error">
            <?= $errors['username'] ?? '' ?>
        </small>
        <br>
        <label for="">Email</label><br>
        <input type="text" name="email" value="<?= $email ?? '' ?>">
        <small class="error">
            <?= $errors['email'] ?? '' ?>
        </small>
        <br>
        <label for="">Password</label><br>
        <input type="password" name="password" value="">
        <small class="error">
            <?= $errors['password'] ?? '' ?>
        </small>
        <br>
        <label for="">Repeat Password</label><br>
        <input type="password" name="cpass" id="">
        <small class="error">
            <?= $errors['cpass'] ?? '' ?>
        </small>
        <br>
        <label for="">Address</label><br>
        <input type="text" name="address" value="<?= $address ?? '' ?>">
        <small class="error">
            <?= $errors['address'] ?? '' ?>
        </small>
        <br>
        <label for="">Date of Birth</label><br>
        <input type="date" name="dob" value="<?= $dob ?? '' ?>">
        <small class="error">
            <?= $errors['dob'] ?? '' ?>
        </small>
        <br>
        <label for="">Telephone</label><br>
        <input type="number" name="phone_number" value="<?= $telephone ?? '' ?>">
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