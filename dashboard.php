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
<h1>Welcome <?= ucfirst($_SESSION['firstname']) . ' ' . ucfirst($_SESSION['lastname']) ?> </h1>
<table border="2">
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Address</th>
        <th>Date of Birth</th>
        <th>Telephone</th>
    </tr>
    <?php foreach ($result as $row) : ?>
    <tr>
        <td><?= ucfirst($row['firstname']) ?></td>
        <td><?= ucfirst($row['lastname']) ?></td>
        <td><?= ucfirst($row['username']) ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= ucfirst($row['address']) ?></td>
        <td><?= ucfirst($row['dob']) ?></td>
        <td><?= ucfirst($row['telephone']) ?></td>
    </tr>


    <?php endforeach ?>
</table>

<body>

</body>

</html>