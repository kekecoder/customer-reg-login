<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

require_once 'dbconfig.php';

$query = $conn->query("SELECT * FROM customers");
$result = $query->fetchAll();

// echo '<pre>';
// var_dump($result);
// echo '</pre>';
// exit;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

</head>
<h1>Welcome <?= $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] ?> </h1>
<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
        <th>Date of Birth</th>
        <th>Telephone</th>
    </tr>
    <?php foreach ($result as $row) : ?>
    <tr>
        <td><?= $row['firstname'] ?></td>
        <td><?= $row['lastname'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $_SESSION['password'] ?></td>
        <td><?= $row['address'] ?></td>
        <td><?= $row['dob'] ?></td>
        <td><?= $row['telephone'] ?></td>
    </tr>


    <?php endforeach ?>
</table>

<body>

</body>

</html>