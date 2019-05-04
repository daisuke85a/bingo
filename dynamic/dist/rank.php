<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/Bingo.php';

$bingoApp = new \MyApp\Bingo();

$numbers = $bingoApp->getAll();
$users = $bingoApp->getAllUsers();

foreach ($users as $user) {
    $rank = $bingoApp->getRank($user["name"]);
    echo '<h3>' . $user["name"] . '</h3>';
    echo '<p>' . $rank . '</p>';
}
?>

</body>
</html>