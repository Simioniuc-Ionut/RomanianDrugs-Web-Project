


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Campanii</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../map/style.css">
    <link rel="stylesheet" href="../../style_element_pagina.css">
    <?php include "navBar.php"; ?>
    <script src="../../map/map_interactions.js" data-file="campanii_data.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
    <style>
        .hidden {
            display: none;
        }
        .table-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .table-nav button {
            padding: 5px 10px;
            cursor: pointer;
        }

    </style>

</head>
<body data-file="campanii_data.json"> <!-- adaug data-file aici pentru a specifica fisierul JSON dorit -->

<?php
require_once "../../RefactoringDataBase/DataBase.php";
 $dbConnection = new Database();

$graphDataQuery1 = "SELECT DISTINCT year  FROM campanii_prevenire ORDER BY year";
$graphDataStmt1 = $dbConnection->prepare($graphDataQuery1);
$graphDataStmt1->execute();
$graphData1 = $graphDataStmt1->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery2 = "SELECT year, COUNT(*) as count FROM campanii_prevenire GROUP BY year ORDER BY year";
$graphDataStmt2 = $dbConnection->prepare($graphDataQuery2);
$graphDataStmt2->execute();
$graphData2 = $graphDataStmt2->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery = "SELECT year, proiecte FROM campanii_prevenire ORDER BY year";
$graphDataStmt = $dbConnection->prepare($graphDataQuery);
$graphDataStmt->execute();
$graphData = $graphDataStmt->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery3 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='Proiect național NECENZURAT-12 activități/proiect' ORDER BY year";
$graphDataStmt3 = $dbConnection->prepare($graphDataQuery3);
$graphDataStmt3->execute();
$graphData3 = $graphDataStmt3->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery4 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='Proiect național MESAJUL MEU ANTIDROG (Nivel gimna' ORDER BY year";
$graphDataStmt4 = $dbConnection->prepare($graphDataQuery4);
$graphDataStmt4->execute();
$graphData4 = $graphDataStmt4->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery5 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='Proiect național EU ŞI COPILUL MEU-9 activități/pr' ORDER BY year";
$graphDataStmt5 = $dbConnection->prepare($graphDataQuery5);
$graphDataStmt5->execute();
$graphData5 = $graphDataStmt5->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery6 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='Proiect național CUM SĂ CREŞTEM SĂNĂTOŞI -7 activi' ORDER BY year";
$graphDataStmt6 = $dbConnection->prepare($graphDataQuery6);
$graphDataStmt6->execute();
$graphData6 = $graphDataStmt6->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery7 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='Proiect național ABC-UL EMOŢIILOR-6 activități/pro' ORDER BY year";
$graphDataStmt7 = $dbConnection->prepare($graphDataQuery7);
$graphDataStmt7->execute();
$graphData7 = $graphDataStmt7->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery8 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='În mediul universitar' ORDER BY year";
$graphDataStmt8 = $dbConnection->prepare($graphDataQuery8);
$graphDataStmt8->execute();
$graphData8 = $graphDataStmt8->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery9 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='În mediul primar, gimnazial şi liceal' ORDER BY year";
$graphDataStmt9 = $dbConnection->prepare($graphDataQuery9);
$graphDataStmt9->execute();
$graphData9 = $graphDataStmt9->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery10 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='În mediul preşcolar' ORDER BY year";
$graphDataStmt10 = $dbConnection->prepare($graphDataQuery10);
$graphDataStmt10->execute();
$graphData10 = $graphDataStmt10->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery11 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='În familie' ORDER BY year";
$graphDataStmt11 = $dbConnection->prepare($graphDataQuery11);
$graphDataStmt11->execute();
$graphData11 = $graphDataStmt11->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery12 = "SELECT nr_activitati FROM campanii_prevenire WHERE proiecte='Campania 19 ZILE DE PREVENIRE A ABUZURILOR ȘI VIOL' ORDER BY year";
$graphDataStmt12 = $dbConnection->prepare($graphDataQuery12);
$graphDataStmt12->execute();
$graphData12 = $graphDataStmt12->fetchAll(PDO::FETCH_ASSOC);


echo "<script>

    var graphData = " . json_encode($graphData) . ";
    var graphData1 = " . json_encode($graphData1) . "; 
    var graphData2 = " . json_encode($graphData2) . ";
    var graphData3 = " . json_encode($graphData3) . ";
    var graphData4 = " . json_encode($graphData4) . ";
    var graphData5 = " . json_encode($graphData5) . ";
    var graphData6 = " . json_encode($graphData6) . ";
    var graphData7 = " . json_encode($graphData7) . ";
    var graphData8 = " . json_encode($graphData8) . ";
    var graphData9 = " . json_encode($graphData9) . ";
    var graphData10 = " . json_encode($graphData10) . ";
    var graphData11 = " . json_encode($graphData11) . ";
    var graphData12 = " . json_encode($graphData12) . ";
       
    </script>";

?>

<div class="container_item">
    <div class="item-image">
        <h2 class="item-name">Campanii</h2>
        <div class="box_image_element">
            <img src="../../imaginiDroguri/campanii.jpg" alt="Urgente Medicale" style="width:100%;max-width:300px">
        </div>
    </div>
    <div class="details">
        <p><strong>Type:</strong> Statisticile pentru Campanii în funcție de an, sex și vârstă</p>
        <p class="item-description"><strong>Description:</strong> Datele statistice despre campaniile înregistrate în diferite categorii</p>
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
    <button class="tablinks" onclick="openTab(event, 'Map')">Map</button>
</div>

<div id="Graph" class="tabcontent">
    <div id="grafic-container" class="grafic-container">
        <canvas id="graficLinie" class="graficLinie"></canvas>
    </div>
</div>

<div id="Table" class="tabcontent table-data">
    <div class="table-nav">
        <button id="prevTable" onclick="switchTable(-1)">&#9664;</button>
        <span id="tableTitle">Table 1</span>
        <button id="nextTable" onclick="switchTable(1)">&#9654;</button>
    </div>
    <div id="dataTableContainer1">
        <table id="dataTable1">
            <thead>
            <tr>
                <th><div class="header-container" onclick="sortTable(0, 'dataTable1')">Year <span class="sort-arrow" id="arrow-0"></span></div></th>
                <th><div class="header-container" onclick="sortTable(1, 'dataTable1')">Numele Campaniei <span class="sort-arrow" id="arrow-1"></span></div></th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div id="dataTableContainer2" class="hidden">
        <table id="dataTable2">
            <thead>
            <tr>
                <th><div class="header-container" onclick="sortTable(0, 'dataTable2')">Year <span class="sort-arrow" id="arrow-0"></span></div></th>
                <th><div class="header-container" onclick="sortTable(1, 'dataTable2')">Proiect național NECENZURAT-12<span class="sort-arrow" id="arrow-1"></span></div></th>
                <th><div class="header-container" onclick="sortTable(2, 'dataTable2')">Proiect național MESAJUL MEU ANTIDROG<span class="sort-arrow" id="arrow-2"></span></div></th>
                <th><div class="header-container" onclick="sortTable(3, 'dataTable2')">Proiect național EU ŞI COPILUL MEU-9<span class="sort-arrow" id="arrow-3"></span></div></th>
                <th><div class="header-container" onclick="sortTable(4, 'dataTable2')">Proiect național CUM SĂ CREŞTEM SĂNĂTOŞI<span class="sort-arrow" id="arrow-4"></span></div></th>
                <th><div class="header-container" onclick="sortTable(5, 'dataTable2')">Proiect național ABC-UL EMOŢIILOR-6<span class="sort-arrow" id="arrow-5"></span></div></th>
                <th><div class="header-container" onclick="sortTable(6, 'dataTable2')">În mediul universitar<span class="sort-arrow" id="arrow-6"></span></div></th>
                <th><div class="header-container" onclick="sortTable(7, 'dataTable2')">În mediul primar, gimnazial şi liceal<span class="sort-arrow" id="arrow-7"></span></div></th>
                <th><div class="header-container" onclick="sortTable(8, 'dataTable2')">În mediul preşcolar<span class="sort-arrow" id="arrow-8"></span></div></th>
                <th><div class="header-container" onclick="sortTable(9, 'dataTable2')">În familieÎn familie<span class="sort-arrow" id="arrow-9"></span></div></th>
                <th><div class="header-container" onclick="sortTable(10, 'dataTable2')">Campania 19 ZILE DE PREVENIRE A ABUZURILOR ȘI VIOL<span class="sort-arrow" id="arrow-10"></span></div></th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="Map" class="tabcontent">

    <div id="map-container">
        <div class="map-image">
            <?php echo file_get_contents('../../map/romania_map.svg'); ?>
        </div>
    </div>

    <div id="tooltip" class="hidden"></div>

    <div class="slider-container-map">
        <input type="range" min="2020" max="2024" value="2020" class="sliderMap" id="startYearSliderMap">
        <div class="year-markers-map">
            <div class="year-marker-map" style="left: 0%;">2020</div>
            <div class="year-marker-map" style="left: 25%;">2021</div>
            <div class="year-marker-map" style="left: 50%;">2022</div>
            <div class="year-marker-map" style="left: 75%;">2023</div>
            <div class="year-marker-map" style="left: 100%;">2024</div>
        </div>
        <div id="selectedYearMap">2020</div>
    </div>
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



    var ctx = document.getElementById('graficLinie').getContext('2d');

    // Process the PHP data
    var years = graphData1.map(function(e) {
        return e.year;
    });

    var counts = graphData2.map(function(e) {
        return e.count;
    });

    var p1 = graphData3.map(function (e){
        return e.nr_activitati;
    });

    var p2 = graphData4.map(function (e){
        return e.nr_activitati;
    });
    var p3 = graphData5.map(function (e){
        return e.nr_activitati;
    });
    var p4 = graphData6.map(function (e){
        return e.nr_activitati;
    });
    var p5 = graphData7.map(function (e){
        return e.nr_activitati;
    });
    var p6 = graphData8.map(function (e){
        return e.nr_activitati;
    });
    var p7 = graphData9.map(function (e){
        return e.nr_activitati;
    });
    var p8 = graphData10.map(function (e){
        return e.nr_activitati;
    });
    var p9 = graphData11.map(function (e){
        return e.nr_activitati;
    });
    var p10 = graphData12.map(function (e){
        return e.nr_activitati;
    });

    const graficLinie = new Chart(ctx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [{
                label: 'Numărul de campanii pe an',
                data: counts,
                fill: false,
                borderColor: 'rgb(55,255,0)',
                tension: 0.1
            },
                {
                    label: 'Proiect național NECENZURAT-12 activități/proiect',
                    data: p1,
                    fill: false,
                    borderColor: 'rgb(0,98,255)',
                    tension: 0.1
                },
                {
                    label: 'Proiect național MESAJUL MEU ANTIDROG',
                    data: p2,
                    fill: false,
                    borderColor: 'rgb(3,151,255)',
                    tension: 0.1
                },
                {
                    label: 'Proiect național EU ŞI COPILUL MEU-9',
                    data: p3,
                    fill: false,
                    borderColor: 'rgb(0,0,0)',
                    tension: 0.1
                },
                {
                    label: 'Proiect național CUM SĂ CREŞTEM SĂNĂTOŞI',
                    data: p4,
                    fill: false,
                    borderColor: 'rgb(241,49,49)',
                    tension: 0.1
                },
                {
                    label: 'Proiect național ABC-UL EMOŢIILOR-6',
                    data: p5,
                    fill: false,
                    borderColor: 'rgb(209,120,21)',
                    tension: 0.1
                },
                {
                    label: 'În mediul universitar',
                    data: p6,
                    fill: false,
                    borderColor: 'rgb(103,15,15)',
                    tension: 0.1
                },
                {
                    label: 'În mediul primar, gimnazial şi liceal',
                    data: p7,
                    fill: false,
                    borderColor: 'rgb(237,8,8)',
                    tension: 0.1
                },
                {
                    label: 'În mediul preşcolar',
                    data: p8,
                    fill: false,
                    borderColor: 'rgb(204,0,201)',
                    tension: 0.1
                },
                {
                    label: 'În familie',
                    data: p9,
                    fill: false,
                    borderColor: 'rgb(22,60,16)',
                    tension: 0.1
                },
                {
                    label: 'Campania 19 ZILE DE PREVENIRE A ABUZURILOR ȘI VIOLCampania naţională media de prevenire a consumului',
                    data: p10,
                    fill: false,
                    borderColor: 'rgb(208,255,0)',
                    tension: 0.1
                }
            ]
        }
    });

    const startYearSlider = document.getElementById('startYearSlider');
    const endYearSlider = document.getElementById('endYearSlider');
    const selectedYear = document.getElementById('selectedYear');

    startYearSlider.addEventListener('input', updateChart);
    endYearSlider.addEventListener('input', updateChart);

    function updateChart() {
        const startYear = parseInt(startYearSlider.value);
        const endYear = parseInt(endYearSlider.value);

        if (startYear > endYear) {
            if (this === startYearSlider) {
                endYearSlider.value = startYear;
            } else {
                startYearSlider.value = endYear;
            }
        }

        const selectedStartYear = Math.min(startYear, endYear);
        const selectedEndYear = Math.max(startYear, endYear);

        const filteredYears = years.filter(year => year >= selectedStartYear && year <= selectedEndYear);
        const filteredCounts = counts.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP1 = p1.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP2 = p2.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP3 = p3.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP4 = p4.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP5 = p5.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP6 = p6.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP7 = p7.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP8 = p8.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP9 = p9.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredP10 = p10.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);



        graficLinie.data.labels = filteredYears;
        graficLinie.data.datasets[0].data = filteredCounts;
        graficLinie.data.datasets[1].data = filteredP1;
        graficLinie.data.datasets[2].data = filteredP2;
        graficLinie.data.datasets[3].data = filteredP3;
        graficLinie.data.datasets[4].data = filteredP4;
        graficLinie.data.datasets[5].data = filteredP5;
        graficLinie.data.datasets[6].data = filteredP6;
        graficLinie.data.datasets[7].data = filteredP7;
        graficLinie.data.datasets[8].data = filteredP8;
        graficLinie.data.datasets[9].data = filteredP9;
        graficLinie.data.datasets[10].data = filteredP10;
        graficLinie.update();

        selectedYear.textContent = `${selectedStartYear} - ${selectedEndYear}`;
    }


    document.addEventListener('DOMContentLoaded', function() {
        loadTableData1();
        loadTableData2();
        document.getElementsByClassName('tablinks')[0].click();
    });


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

        // Hide or show slider container based on the selected tab
        var sliderContainer = document.getElementsByClassName("slider-container")[0];
        if (tabName === 'Table') {
            sliderContainer.classList.add("hidden");
            document.getElementById('grafB').classList.add('hidden');
            document.getElementById('mapB').classList.add('hidden');
            document.getElementById('tableB').classList.remove('hidden');
            document.getElementById('tableB2').classList.add('hidden');
        } else if(tabName === 'Graph') {
            sliderContainer.classList.remove("hidden");
            document.getElementById('grafB').classList.remove('hidden');
            document.getElementById('tableB').classList.add('hidden');
            document.getElementById('tableB2').classList.add('hidden');
            document.getElementById('mapB').classList.add('hidden');

        } else {
            sliderContainer.classList.add("hidden");
            document.getElementById('grafB').classList.add('hidden');
            document.getElementById('tableB').classList.add('hidden');
            document.getElementById('tableB2').classList.add('hidden');
            document.getElementById('mapB').classList.remove('hidden');
        }
    }


    let sortDirections = [true, true, true, true, true, true, true];

    function sortTable(columnIndex) {
        const table = document.getElementById('dataTable1');
        const rows = Array.from(table.rows).slice(1);
        const ascending = sortDirections[columnIndex];
        const isNumericColumn = columnIndex !== 0;

        rows.sort((a, b) => {
            const aText = a.cells[columnIndex].innerText;
            const bText = b.cells[columnIndex].innerText;

            if (isNumericColumn) {
                const aValue = parseFloat(aText);
                const bValue = parseFloat(bText);
                return ascending ? aValue - bValue : bValue - aValue;
            } else {
                return ascending ? aText.localeCompare(bText) : bText.localeCompare(aText);
            }
        });

        sortDirections[columnIndex] = !ascending;

        // Remove existing arrow icons
        document.querySelectorAll('.sort-arrow').forEach(arrow => {
            arrow.classList.remove('asc', 'desc');
        });

        // Add new arrow icon for the current column
        const arrowElement = document.getElementById(`arrow-${columnIndex}`);
        arrowElement.classList.add(ascending ? 'asc' : 'desc');

        for (const row of rows) {
            table.tBodies[0].appendChild(row);
        }
    }

    function exportChart() {
        var format = document.getElementById('exportFormatChart').value;
        if (format === 'png') {
            var link = document.createElement('a');
            link.href = graficLinie.toBase64Image();
            link.download = 'grafic.png';
            link.click();
        } else if (format === 'svg') {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            var img = new Image();

            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);

                var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
                svg.setAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink'); // Add xlink namespace
                svg.setAttribute('width', img.width);
                svg.setAttribute('height', img.height);

                var svgImg = document.createElementNS("http://www.w3.org/2000/svg", "image");
                svgImg.setAttributeNS('http://www.w3.org/1999/xlink', 'href', canvas.toDataURL("image/png"));
                svgImg.setAttribute('width', img.width);
                svgImg.setAttribute('height', img.height);
                svg.appendChild(svgImg);

                var svgBlob = new Blob([svg.outerHTML], { type: 'image/svg+xml;charset=utf-8' });
                var svgUrl = URL.createObjectURL(svgBlob);

                var link = document.createElement('a');
                link.href = svgUrl;
                link.download = 'grafic.svg';
                link.click();
            };

            img.src = graficLinie.toBase64Image();
        }
    }


    function exportTable(data) {

        var format;
        if(data=='dataTable1')
            format = document.getElementById('exportFormatTable1').value;
        else
            format = document.getElementById('exportFormatTable1').value;

        var table = document.getElementById(data);
        if (format === 'png') {
            var canvas = document.createElement('canvas');
            var tableWidth = table.offsetWidth;
            var tableHeight = table.offsetHeight;
            canvas.width = tableWidth;
            canvas.height = tableHeight;
            var ctx = canvas.getContext('2d');
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            var rows = table.rows;
            var yOffset = 0;
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var xOffset = 0;
                for (var j = 0; j < row.cells.length; j++) {
                    var cell = row.cells[j];
                    ctx.fillStyle = '#000000';
                    ctx.font = '14px Arial';
                    ctx.fillText(cell.innerText, xOffset, yOffset + 20);
                    xOffset += cell.offsetWidth;
                }
                yOffset += row.offsetHeight;
            }

            var link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'tabel.png';
            link.click();
        } else if (format === 'svg') {
            var serializer = new XMLSerializer();
            var svgData = `<svg xmlns="http://www.w3.org/2000/svg" width="${table.offsetWidth}" height="${table.offsetHeight}">
            <foreignObject width="100%" height="100%">
                <div xmlns="http://www.w3.org/1999/xhtml">${table.outerHTML}</div>
            </foreignObject>
        </svg>`;
            var svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(svgBlob);
            link.download = 'tabel.svg';
            link.click();
        }
    }

    function exportAll() {
        fetch('../../map/campanii_data.json') // Încărcăm fișierul judete.json
            .then(response => response.json())
            .then(data => {
                var csvContent = "data:text/csv;charset=utf-8,";
                // Selectarea tabelului și antetelor
                var table = document.getElementById('dataTable1');
                var headers = Array.from(table.querySelectorAll('thead th')).map(header => header.innerText.trim());

                var table2 = document.getElementById('dataTable2');
                var headers2 = Array.from(table2.querySelectorAll('thead th')).map(header => header.innerText.trim());

                // Colectarea datelor din fiecare rând al tabelului
                var rows = [];

                csvContent += headers.join(',') + '\n';

                Array.from(table.querySelectorAll('tbody tr')).forEach(row => {
                    var rowData = Array.from(row.querySelectorAll('td')).map(cell => cell.innerText.trim());
                    rows.push(rowData);
                });

                rows.forEach(row => {
                    csvContent += row.join(',') + '\n';
                });

                csvContent += headers2.join(',') + '\n';

                rows = [];

                Array.from(table2.querySelectorAll('tbody tr')).forEach(row => {
                    var rowData = Array.from(row.querySelectorAll('td')).map(cell => cell.innerText.trim());
                    rows.push(rowData);
                });

                rows.forEach(row => {
                    csvContent += row.join(',') + '\n';
                });

                csvContent += 'Map data:\n';

                rows = [];
                Object.keys(data).forEach(judet => {

                    data[judet].ani.forEach(an => {
                            var rowData = [
                                judet,
                                an.campanii_prevenire,
                                an.campanii_combatere,
                                an.an,
                            ];
                            rows.push(rowData);
                    });
                });


                rows.forEach(row => {
                    csvContent += row.join(',') + '\n';
                });

                var encodedUri = encodeURI(csvContent);
                var link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "table_data.csv");
                document.body.appendChild(link); // necesar pentru Firefox
                link.click(); // Simularea clicului pe link pentru descărcare
                document.body.removeChild(link); // eliminarea link-ului din document după descărcare
            })
            .catch(error => console.error('Eroare în încărcarea datelor:', error));
    }


    startYearSliderMap = document.getElementById('startYearSliderMap');
    startYearSliderMap.addEventListener('input', updateYearMap);

    function updateYearMap()
    {
        const yearMapStart = document.getElementById('startYearSliderMap');
        const yearMapSelect = document.getElementById('selectedYearMap');

        yearMapSelect.textContent = yearMapStart.value;
    }

    document.addEventListener("DOMContentLoaded", function() {
        loadTableData1();
        loadTableData2();

        let currentTable = 1;
        function switchTable(direction) {
            currentTable += direction;
            if (currentTable < 1) currentTable = 2;
            if (currentTable > 2) currentTable = 1;
            document.getElementById("dataTableContainer1").classList.add("hidden");
            document.getElementById("dataTableContainer2").classList.add("hidden");
            document.getElementById("tableTitle").innerText = "Table " + currentTable;
            if (currentTable === 1) {
                document.getElementById("dataTableContainer1").classList.remove("hidden");
                document.getElementById('tableB').classList.remove('hidden');
                document.getElementById('tableB2').classList.add('hidden');
            } else {
                document.getElementById("dataTableContainer2").classList.remove("hidden");
                document.getElementById('tableB').classList.add('hidden');
                document.getElementById('tableB2').classList.remove('hidden');
            }
        }
        window.switchTable = switchTable;


    });

    function loadTableData1() {
        const tableBody = document.getElementById('dataTable1').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

        for (const item of graphData) {
            if(item.proiecte) {
                let row = tableBody.insertRow();
                let cell1 = row.insertCell(0);
                let cell2 = row.insertCell(1);

                cell1.innerHTML = item.year;
                cell2.innerHTML = item.proiecte;
            }
        }
    }

    function loadTableData2(){
        const tableBody = document.getElementById('dataTable2').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

            for (let i = 0; i < years.length; i++)
            {
                let row = tableBody.insertRow();
                let cell1 = row.insertCell(0);
                let cell2 = row.insertCell(1);
                let cell3 = row.insertCell(2);
                let cell4 = row.insertCell(3);
                let cell5 = row.insertCell(4);
                let cell6 = row.insertCell(5);
                let cell7 = row.insertCell(6);
                let cell8 = row.insertCell(7);
                let cell9 = row.insertCell(8);
                let cell10 = row.insertCell(9);
                let cell11 = row.insertCell(10);


                cell1.innerHTML = years[i] || 0;
                cell2.innerHTML = p1[i] || 0;
                cell3.innerHTML = p2[i] || 0;
                cell4.innerHTML = p3[i] || 0;
                cell5.innerHTML = p4[i] || 0;
                cell6.innerHTML = p5[i] || 0;
                cell7.innerHTML = p6[i] || 0;
                cell8.innerHTML = p7[i] || 0;
                cell9.innerHTML = p8[i] || 0;
                cell10.innerHTML = p9[i] || 0;
                cell11.innerHTML = p10[i] || 0;

            }
    }

    function sortTable(n, tableId) {
        const table = document.getElementById(tableId);
        let rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir === "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir === "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }


</script>

<div id="grafB" class="center hidden">
    <label>Type of export
        <select id="exportFormatChart" class="export-format">
            <option value="png">PNG</option>
            <option value="svg">SVG</option>
        </select>
    </label>
    <button class="text-button" onclick="exportChart()">Export Graphic</button>
</div>

<div id="tableB" class="center hidden">
    <label>Type of export
        <select id="exportFormatTable1" class="export-format">
            <option value="png">PNG</option>
            <option value="svg">SVG</option>
        </select>
    </label>
    <button class="text-button" onclick="exportTable('dataTable1')">Export Table</button>
</div>

<div id="tableB2" class="center hidden">
    <label>Type of export
        <select id="exportFormatTable2" class="export-format">
            <option value="png">PNG</option>
            <option value="svg">SVG</option>
        </select>
    </label>
    <button class="text-button" onclick="exportTable('dataTable2')">Export Table</button>
</div>

<div id="mapB" class="center hidden">
    <label>Type of export
        <select id="exportFormatMap" class="export-format">
            <option value="png">PNG</option>
            <option value="svg">SVG</option>
        </select>
    </label>
    <button class="text-button" onclick="exportMap()">Export Map</button>
</div>

<div id="allB" class="center">
    <button class="text-button" onclick="exportAll()">Export All</button>
</div>

<?php include "footer.php";?>
</body>
</html>
