

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
