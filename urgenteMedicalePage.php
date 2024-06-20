<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Urgente Medicale</title>
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
    <h2 class="item-name">Urgente Medicale</h2>
    <div class="box_image_element">
    <img src="imaginiDroguri/urgenteMedicale.jpg" alt="Urgente Medicale" style="width:100%;max-width:300px">
    </div>
    </div>
    <div class="details">
        <p><strong>Type:</strong> Statisticile pentru Urgente Medicale în funcție de an, sex și vârstă</p>
        <p class="item-description"><strong>Description:</strong> Datele statistice despre urgențele medicale înregistrate în diferite categorii. Aceste date sunt esențiale pentru a înțelege tendințele și modelele de urgențe medicale și pentru a informa strategiile de prevenire și intervenție.</p>
    </div>
</div>
<div class="container_item">
    <div class="campaign">
        <h1 class="campaign-title">Campanii de Prevenire a Consumului de Droguri</h1>
        <p class="campaign-description">Consumul de droguri este o problemă majoră în societatea modernă, afectând milioane de vieți în fiecare an. Pentru a combate această problemă, au fost lansate numeroase campanii de prevenire a consumului de droguri, atât la nivel local, cât și la nivel național și global.</p>

        <h2 class="campaign-section-title">Scopul Campaniilor de Prevenire</h2>
        <p class="campaign-section-description">Scopul principal al acestor campanii este de a informa și educa publicul despre pericolele și riscurile asociate consumului de droguri. Ele își propun să reducă prevalența consumului de droguri în rândul populației și să promoveze un stil de viață sănătos și lipsit de substanțe toxice.</p>

        <h2 class="campaign-section-title">Inițiative și Proiecte</h2>
        <p class="campaign-section-description">Campaniile de prevenire a consumului de droguri implică o varietate de inițiative și proiecte, inclusiv:</p>
        <ul class="campaign-list">
            <li>Educație și conștientizare în școli și comunități</li>
            <li>Distribuirea de materiale informative și resurse educaționale</li>
            <li>Evenimente și întâlniri comunitare pentru promovarea unui stil de viață sănătos</li>
            <li>Campanii media și sociale pentru sensibilizarea publicului</li>
            <li>Programare de consiliere și sprijin pentru cei afectați de consumul de droguri</li>
        </ul>

        <h2 class="campaign-section-title">Implicarea Comunității</h2>
        <p class="campaign-section-description">Un aspect important al acestor campanii este implicarea comunității. Prin colaborarea între organizațiile guvernamentale și neguvernamentale, grupurile comunitare și membrii societății în general, putem construi un mediu mai sănătos și mai sigur pentru toți.</p>
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
            <th>Total Urgente</th>
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
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    document.getElementById("Graph").style.display = "block"; // Show the first tab by default
    document.querySelector(".tablinks").className += " active";

    // Initialize Chart.js graph
    var ctx = document.getElementById('graficLinie').getContext('2d');
    var graficLinie = new Chart(ctx, {
        type: 'line',
        data: {
            labels: graphData1.map(data => data.year),
            datasets: [{
                label: drugName,
                data: graphData1.map(data => data.urgenta),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom'
                }
            }
        }
    });

    // Update selected year range
    var startYearSlider = document.getElementById("startYearSlider");
    var endYearSlider = document.getElementById("endYearSlider");
    var selectedYear = document.getElementById("selectedYear");

    startYearSlider.oninput = function() {
        selectedYear.innerHTML = startYearSlider.value + " - " + endYearSlider.value;
        updateChart();
    };

    endYearSlider.oninput = function() {
        selectedYear.innerHTML = startYearSlider.value + " - " + endYearSlider.value;
        updateChart();
    };

    function updateChart() {
        var startYear = parseInt(startYearSlider.value);
        var endYear = parseInt(endYearSlider.value);
        var filteredData = graphData1.filter(data => data.year >= startYear && data.year <= endYear);

        graficLinie.data.labels = filteredData.map(data => data.year);
        graficLinie.data.datasets[0].data = filteredData.map(data => data.urgenta);
        graficLinie.update();
    }
</script>

<?php include "footer.php";?>
</body>
</html>
