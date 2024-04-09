<?php

    require_once "db_connect.php";
    global $dbConnection;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Romanina Drug Explorer</title>
    <link rel="stylesheet" href="style.css">
    <?php include "NavBar.php"; ?>
</head>
<body>

<div class="container">
    <div class="content">
        <?php
        $sql = "SELECT name, image FROM     drugstable";
        $result = $dbConnection->query($sql);

        if ($result->rowCount() > 0) {

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<a href="element-pagin.php" class="box__link">';
                echo '<div class="box">';
                echo '<text class="box__text">' . $row["name"] . '</text>'; // Changed from "nume" to "name"
                echo '<img src="' . $row["image"] . '" class="box__img">'; // Changed from "cale_imagine" to "image"
                echo '</div>';
                echo '</a>';
            }
        } else {
            echo "Nu sunt rezultate în baza de date.";
        }
        ?>
</div>
<div id="contact-us">

</div>

</body>
</html>
