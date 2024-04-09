<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Romanina Drug Explorer</title>
    <link rel="stylesheet" href="style.css">
    <?php include 'NavBar.php'; ?>
</head>
<body>

<?php
require_once "db_connect.php";
global $dbConnection;

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM drugstable WHERE id = :id";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row) {
        echo '<div class="container_item ' . $row["type"] . '">';
        echo '<img class="item-image" src="' . $row["image"] . '" alt="' . $row["name"] . '">';
        echo '<div class="details">';
        echo '<h2 class="item-name">' . $row["name"] . '</h2>';
        echo '<p class="item-type"><strong>Type:</strong> ' . $row["type"] . '</p>';
        echo '<p class="item-description"><strong>Description:</strong> ' . $row["description"] . '</p>';
        echo '</div>';
        echo '</div>';
    }
    else {
        echo "Elementul nu a fost găsit.";
    }
} else {
    echo "Nu s-a specificat niciun id.";
}
?>

</body>
</html>
