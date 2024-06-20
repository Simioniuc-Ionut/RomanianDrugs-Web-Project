<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Infractionalitate</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_element_pagina.css">
    <?php include "NavBar.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<?php
require_once "db_connect.php";
global $dbConnection;


?>

<div class="container_item">
    <div class="item-image">
    <h2 class="item-name">Infractionalitate</h2>
    <div class="box_image_element">
        <img src="imaginiDroguri/infractionalitate.jpg" alt="Urgente Medicale" style="width:100%;max-width:300px">
    </div>
    </div>
    <div class="details">
        <p><strong>Type:</strong> Statisticile pentru Infractionalitate în funcție de an, sex și vârstă</p>
        <p class="item-description"><strong>Description:</strong> Datele statistice despre infracțiunile înregistrate în diferite categorii</p>
    </div>
</div>

<div class="tab-buttons">
    <button class="tablinks" onclick="openTab(event, 'Graph')">Graph</button>
    <button class="tablinks" onclick="openTab(event, 'Table')">Table</button>
</div>

<div id="Graph" class="tabcontent">
    <div id="grafic-container" class="grafic-container">
        <canvas id="graficLinie" class="graficLinie"></canvas>
    </div>
</div>

<div id="Table" class="tabcontent">
    <table id="dataTable">
        <thead>
        <tr>
            <th>Year</th>
            <th>Total Infracțiuni</th>
            <th>Masculin</th>
            <th>Feminin</th>
            <th><25</th>
            <th>25-34</th>
            <th>>35</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="slider-container">
    <input type="range" min="2020" max="2024" value="2020" class="slider" id="startYearSlider">
    <input type="range" min="2020" max="2024" value="2024" class="slider" id="endYearSlider">
    <div class="year-markers">
        <div class="year-marker" style="left: 0%;">2020</div>
        <div class="year-marker" style="left: 25%;">2021</div>
        <div class="year-marker" style="left: 50%;">2022</div>
        <div class="year-marker" style="left: 75%;">2023</div>
        <div class="year-marker" style="left: 100%;">2024</div>
    </div>
    <div id="selectedYear">2020 - 2024</div>
</div>

<script>
    // Codul JavaScript pentru procesarea datelor și actualizarea graficelor și tabelelor
</script>

<?php include "footer.php";?>
</body>
</html>
