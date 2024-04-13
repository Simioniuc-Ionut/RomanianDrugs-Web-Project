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
<!--    <link rel="stylesheet" href="style_navbar.css">-->
    <?php include "NavBar.php"; ?>
</head>
<body>

<div class="container">
    <div class="content">
        <?php
        $sql = "SELECT id,name, image FROM  drugstable";
        $result = $dbConnection->query($sql);

        if ($result->rowCount() > 0) {

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<a href="element-pagin.php?id=' . $row["id"] . '" class="box__link">';
                echo '<div class="box">';
                echo '<text class="box__text">' . $row["name"] . '</text>';
                echo '<img src="' . $row["image"] . '" class="box__img">';
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

    <?php include "footer.php";?>
</body>
</html>
