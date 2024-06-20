<?php
//
//require_once "db_connect.php";
//global $dbConnection;
//
//
//?>
<!---->
<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <title>Romanina Drug Explorer</title>-->
<!--    <link rel="stylesheet" href="style.css">-->
<!--    --><?php //include "NavBar.php"; ?>
<!--</head>-->
<!--<body>-->
<!---->
<!--<div class="container">-->
<!--    <div class="content">-->
<!--        --><?php
//        $sql = "SELECT id,name, image FROM  drugstable";
//        $result = $dbConnection->query($sql);
//
//        if ($result->rowCount() > 0) {
//
//            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
//                echo '<a href="element-pagin.php?id=' . $row["id"] . '" class="box__link">';
//                echo '<div class="box">';
//                echo '<text class="box__text">' . $row["name"] . '</text>';
//                echo '<img src="'.'imaginiDroguri/' . $row["image"] . '" class="box__img">';
//                echo '</div>';
//                echo '</a>';
//            }
//        } else {
//            echo "Nu sunt rezultate în baza de date.";
//        }
//        ?>
<!--    </div>-->
<!--    <div id="contact-us">-->
<!---->
<!---->
<!--    </div>-->
<!---->
<!--    --><?php //include "footer.php";?>
<!--</body>-->
<!--</html>-->

<?php

    require_once "RefactoringDataBase/DataBase.php";

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Romanian Drug Explorer</title>
        <link rel="stylesheet" href="style.css">
        <?php include "NavBar.php"; ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>
    <body>

    <div class="container">
        <div class="content" id="drug-list">
            <img alt src="imaginiDroguri/canabis.jpg"  class="box__img">
            <!-- Conținutul va fi încărcat dinamic aici -->
        </div>
        <div id="contact-us"></div>
    </div>
    <?php include "footer.php"; ?>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'RefactoringDataBase/index.php/get/allDrugs',
                method: 'GET',
                success: function(data) {
                    const drugs = JSON.parse(data);
                    let content = '';

                    drugs.forEach(drug => {
                        content += `
                    <a href="element-pagin.php?id=${drug.id}" class="box__link">
                        <div class="box">
                            <text class="box__text">${drug.name}</text>
                            <img alt="drog" src="imaginiDroguri/${drug.image}" class="box__img">
                        </div>
                    </a>`;
                    });

                    $('#drug-list').html(content);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    $('#drug-list').html('<p>Unable to load drugs data.</p>');
                }
            });
        });
    </script>


    </body>

    </html>
