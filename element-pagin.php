<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Romanina Drug Explorer</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_element_pagina.css">
    <?php include "NavBar.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      //  echo '<div class="container_item" >' . $row["type"] . '">';
        echo  '<div class="container_item" >';
        echo '<div class="item-image" >';
        echo '<h2 class="item-name">' . $row["name"] . '</h2>';
        echo '<div class="box_image_element" >';
        echo '<img  src="'.'images/' . $row["image"] . '" alt="' . $row["name"] . '">';
        echo '</div>';
        echo '</div>';
        echo '<div class="details" >';
        echo '<p><strong>Type:</strong> ' . $row["type"] . '</p>';
        echo '<p class="item-description"><strong>Description:</strong> ' . $row["description"] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="center">';
        echo '</div>';
    }
    else {
        echo "Elementul nu a fost găsit.";
    }
} else {
    echo "Nu s-a specificat niciun id.";
}
?>
<div id="grafic-container" class="grafic-container">
    <canvas id="graficLinie" class="graficLinie"></canvas>
</div>

    <script>
        var ctx = document.getElementById('graficLinie').getContext('2d');
        var graficLinie = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai'],
                datasets: [{
                    label: 'Exemplu de date',
                    data: [10, 15, 7, 10, 15],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });
    </script>
<div class="slider-container">
    <input type="range" min="2020" max="2024" value="2024" class="slider" id="yearSlider">
    <div class="year-markers">
        <div class="year-marker" style="left: 0%;">2020</div>
        <div class="year-marker" style="left: 25%;">2021</div>
        <div class="year-marker" style="left: 50%;">2022</div>
        <div class="year-marker" style="left: 75%;">2023</div>
        <div class="year-marker" style="left: 100%;">2024</div>
    </div>
</div>
<div id="selectedYear">2024</div>

<script>
    const yearSlider = document.getElementById('yearSlider');
    const selectedYear = document.getElementById('selectedYear');

    yearSlider.addEventListener('input', function() {
        selectedYear.textContent = this.value;
    });

</script>
<div class="center">
    <button class="text-button">Generate</button>
</div>

<?php include "footer.php";?>
</body>
</html>
