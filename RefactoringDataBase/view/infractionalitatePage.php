<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Infractionalitate</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../map/style.css">
    <link rel="stylesheet" href="../../style_element_pagina.css">
    <?php include "navBar.php"; ?>
    <script src="../../map/map_interactions.js" data-file="condamnari_data.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body data-file="condamnari_data.json">




<?php
require_once "../../RefactoringDataBase/DataBase.php";
 $dbConnection = new Database();

$graphDataQuery1 = "SELECT year, numar FROM grupari_infractionale WHERE categorie = 'numar_persoane' ORDER BY year";
$graphDataStmt1 = $dbConnection->prepare($graphDataQuery1);
$graphDataStmt1->execute();
$graphData1 = $graphDataStmt1->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery2 = "SELECT numar FROM grupari_infractionale WHERE categorie = 'numar_grupari' ORDER BY year";
$graphDataStmt2 = $dbConnection->prepare($graphDataQuery2);
$graphDataStmt2->execute();
$graphData2 = $graphDataStmt2->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery3 = "SELECT numar FROM persoane_cercetate_judecata_condamnate WHERE categorie = 'Persoane cercetate' ORDER BY year";
$graphDataStmt3 = $dbConnection->prepare($graphDataQuery3);
$graphDataStmt3->execute();
$graphData3 = $graphDataStmt3->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery4 = "SELECT numar FROM persoane_cercetate_judecata_condamnate WHERE categorie = 'Persoane trimise în judecată' ORDER BY year";
$graphDataStmt4 = $dbConnection->prepare($graphDataQuery4);
$graphDataStmt4->execute();
$graphData4 = $graphDataStmt4->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery5 = "SELECT numar FROM persoane_cercetate_judecata_condamnate WHERE categorie = 'Persoane condamnate' ORDER BY year";
$graphDataStmt5 = $dbConnection->prepare($graphDataQuery5);
$graphDataStmt5->execute();
$graphData5 = $graphDataStmt5->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery6 = "SELECT numar FROM persoane_condamnate_incadrarea_juridica WHERE incadrare_juridica = 'Art.2 din Legea nr. 143/2000' ORDER BY year";
$graphDataStmt6 = $dbConnection->prepare($graphDataQuery6);
$graphDataStmt6->execute();
$graphData6 = $graphDataStmt6->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery7 = "SELECT numar FROM persoane_condamnate_incadrarea_juridica WHERE incadrare_juridica = 'Art.3 din Legea nr. 143/2000' ORDER BY year";
$graphDataStmt7 = $dbConnection->prepare($graphDataQuery7);
$graphDataStmt7->execute();
$graphData7 = $graphDataStmt7->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery8 = "SELECT numar FROM persoane_condamnate_incadrarea_juridica WHERE incadrare_juridica = 'Art.4 din Legea nr. 143/2000' ORDER BY year";
$graphDataStmt8 = $dbConnection->prepare($graphDataQuery8);
$graphDataStmt8->execute();
$graphData8 = $graphDataStmt8->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery9 = "SELECT numar FROM persoane_condamnate_incadrarea_juridica WHERE incadrare_juridica = 'Legea nr. 194/2011' ORDER BY year";
$graphDataStmt9 = $dbConnection->prepare($graphDataQuery9);
$graphDataStmt9->execute();
$graphData9 = $graphDataStmt9->fetchAll(PDO::FETCH_ASSOC);




echo "<script>
     var graphData1 = " . json_encode($graphData1) . ";    
     var graphData2 = " . json_encode($graphData2) . ";   
     var graphData3 = " . json_encode($graphData3) . ";     
     var graphData4 = " . json_encode($graphData4) . ";   
     var graphData5 = " . json_encode($graphData5) . ";
     var graphData6 = " . json_encode($graphData6) . ";
     var graphData7 = " . json_encode($graphData7) . "; 
     var graphData8 = " . json_encode($graphData8) . "; 
     var graphData9 = " . json_encode($graphData9) . "; 
         
    </script>";

?>

<div class="container_item">
    <div class="item-image">
    <h2 class="item-name">Infractionalitate</h2>
    <div class="box_image_element">
        <img src="../../imaginiDroguri/infractionalitate.jpg" alt="Urgente Medicale" style="width:100%;max-width:300px">
    </div>
    </div>
    <div class="details">
        <p><strong>Type:</strong> Statisticile pentru Infractionalitate în funcție de an, sex și vârstă</p>
        <p class="item-description"><strong>Description:</strong> Datele statistice despre infracțiunile înregistrate în diferite categorii</p>
    </div>
</div>

<div class="container_item">
    <div class="campaign">
        <h1 class="campaign-title">Infracțiunile Legate de Droguri în România</h1>
        <p class="campaign-description">Problema infracțiunilor legate de droguri reprezintă o preocupare majoră în societatea românească contemporană, având un impact semnificativ asupra securității și sănătății publice. Este crucial să identificăm și să gestionăm corect aceste infracțiuni pentru a asigura un mediu sigur și sănătos pentru toți cetățenii.</p>

        <h2 class="campaign-section-title">Aspecte Critice ale Infracțiunilor Legate de Droguri</h2>
        <p class="campaign-section-description">Infracțiunile legate de droguri în România includ:</p>
        <ul class="campaign-list">
            <li>Producția ilegală și traficul de substanțe interzise</li>
            <li>Consumul și posesia ilegală de droguri</li>
            <li>Spălarea banilor proveniți din traficul de droguri</li>
            <li>Implicarea în rețele de distribuție și trafic internațional</li>
            <li>Criza opioidelor și alte forme emergente de infracțiuni legate de droguri</li>
        </ul>

        <h2 class="campaign-section-title">Rolul Comunității în Combaterea Infracțiunilor</h2>
        <p class="campaign-section-description">Comunitățile joacă un rol esențial în lupta împotriva infracțiunilor legate de droguri prin colaborare strânsă cu autoritățile, educație preventivă și promovarea unui mediu de informare și responsabilitate. Este vital să continuăm să dezvoltăm strategii eficiente pentru reducerea acestor infracțiuni și pentru protejarea cetățenilor împotriva efectelor nocive ale consumului și traficului de droguri.</p>
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
    <table id="dataTable">
        <thead>
        <tr>
            <th><div class="header-container" onclick="sortTable(0)">Year <span class="sort-arrow" id="arrow-0"></span></div></th>
            <th><div class="header-container" onclick="sortTable(1)">Numar Persoane Infractionale<span class="sort-arrow" id="arrow-1"></span></div></th>
            <th><div class="header-container" onclick="sortTable(2)">Numar Grupari Infractionale <span class="sort-arrow" id="arrow-2"></span></div></th>
            <th><div class="header-container" onclick="sortTable(3)">Persoane cercetate<span class="sort-arrow" id="arrow-3"></span></div></th>
            <th><div class="header-container" onclick="sortTable(4)">Persoane trimise în judecată <span class="sort-arrow" id="arrow-4"></span></div></th>
            <th><div class="header-container" onclick="sortTable(5)">Persoane condamnate<span class="sort-arrow" id="arrow-5"></span></div></th>
            <th><div class="header-container" onclick="sortTable(6)">Art.2 din Legea nr. 143/2000<span class="sort-arrow" id="arrow-6"></span></div></th>
            <th><div class="header-container" onclick="sortTable(7)">Art.3 din Legea nr. 143/2000<span class="sort-arrow" id="arrow-7"></span></div></th>
            <th><div class="header-container" onclick="sortTable(8)">Art.4 din Legea nr. 143/2000<span class="sort-arrow" id="arrow-8"></span></div></th>
            <th><div class="header-container" onclick="sortTable(9)">Legea nr. 194/2011<span class="sort-arrow" id="arrow-9"></span></div></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div id="Map" class="tabcontent">

    <div id="map-container">
        <div class="map-image">
            <?php echo file_get_contents('../../map/romania_map.svg'); ?>
        </div>
    </div>

    <div id="info-container">
        <h2 id="region-title"></h2>
        <p id="region-population"></p>
        <p id="region-area"></p>
        <p id="region-density"></p>
        <p id="region-description"></p>
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

    var years = graphData1.map(function(e) {
        return e.year;
    });

    var nr_p = graphData1.map(function(e) {
        let values = Object.values(e);
        return values;
    });

    var nr_g = graphData2.map(function(e) {
        let values = e.numar;
        return values;
    });

    var nr_1 = graphData3.map(function(e) {
        let values = e.numar;
        return values;
    });

    var nr_2 = graphData4.map(function(e) {
        let values = e.numar;

        return values;
    });

    var nr_3 = graphData5.map(function(e) {
        let values = e.numar;

        return values;
    });

    var lg_1 = graphData6.map(function(e) {
        let values = e.numar;

        return values;
    });
    var lg_2 = graphData7.map(function(e) {
        let values = e.numar;

        return values;
    });
    var lg_3 = graphData8.map(function(e) {
        let values = e.numar;

        return values;
    });
    var lg_4 = graphData9.map(function(e) {
        let values = e.numar;

        return values;
    });

    const graficLinie = new Chart(ctx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [{
                label: 'Numar Persoane Infractionale',
                data: nr_p,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            },
                {
                    label: 'Numar Grupari Infractionale',
                    data: nr_g,
                    fill: false,
                    borderColor: 'rgb(0, 0, 204)',
                    tension: 0.1
                },
                {
                    label: 'Persoane cercetate',
                    data: nr_1,
                    fill: false,
                    borderColor: 'rgb(168,5,5)',
                    tension: 0.1
                },
                {
                    label: 'Persoane trimise în judecată',
                    data: nr_2,
                    fill: false,
                    borderColor: 'rgb(208,255,0)',
                    tension: 0.1
                },
                {
                    label: 'Persoane condamnate',
                    data: nr_3,
                    fill: false,
                    borderColor: 'rgb(204,0,201)',
                    tension: 0.1
                },
                {
                    label: 'Art.2 din Legea nr. 143/2000',
                    data: lg_1,
                    fill: false,
                    borderColor: 'rgb(209,120,21)',
                    tension: 0.1
                },
                {
                    label: 'Art.3 din Legea nr. 143/2000',
                    data: lg_2,
                    fill: false,
                    borderColor: 'rgb(241,49,49)',
                    tension: 0.1
                },
                {
                    label: 'Art.4 din Legea nr. 143/2000',
                    data: lg_3,
                    fill: false,
                    borderColor: 'rgb(0,0,0)',
                    tension: 0.1
                },
                {
                    label: 'Legea nr. 194/2011',
                    data: lg_4,
                    fill: false,
                    borderColor: 'rgb(3,151,255)',
                    tension: 0.1
                },
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
        const filteredPersoane = nr_p.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredGrupari = nr_g.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filtered1 = nr_1.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filtered2 = nr_2.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filtered3 = nr_3.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredLg1 = lg_1.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredLg2 = lg_2.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredLg3 = lg_3.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredLg4 = lg_4.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);

        graficLinie.data.labels = filteredYears;
        graficLinie.data.datasets[0].data = filteredPersoane;
        graficLinie.data.datasets[1].data = filteredGrupari;
        graficLinie.data.datasets[2].data = filtered1;
        graficLinie.data.datasets[3].data = filtered2;
        graficLinie.data.datasets[4].data = filtered3;
        graficLinie.data.datasets[4].data = filteredLg1;
        graficLinie.data.datasets[4].data = filteredLg2;
        graficLinie.data.datasets[4].data = filteredLg3;
        graficLinie.data.datasets[4].data = filteredLg4;
        graficLinie.update();

        selectedYear.textContent = `${selectedStartYear} - ${selectedEndYear}`;
    }

    function populateTable() {
        const tableBody = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

        for (let i = 0; i < years.length; i++) {
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


            cell1.innerHTML = years[i] || 0;
            cell2.innerHTML = nr_p[i][1] || 0;
            cell3.innerHTML = nr_g[i] || 0;
            cell4.innerHTML = nr_1[i] || 0;
            cell5.innerHTML = nr_2[i] || 0;
            cell6.innerHTML = nr_3[i] || 0;
            cell7.innerHTML = lg_1[i] || 0;
            cell8.innerHTML = lg_2[i] || 0;
            cell9.innerHTML = lg_3[i] || 0;
            cell10.innerHTML = lg_4[i] || 0;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        populateTable();
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
        } else if(tabName === 'Graph') {
            sliderContainer.classList.remove("hidden");
            document.getElementById('grafB').classList.remove('hidden');
            document.getElementById('tableB').classList.add('hidden');
            document.getElementById('mapB').classList.add('hidden');
        } else {
            sliderContainer.classList.add("hidden");
            document.getElementById('grafB').classList.add('hidden');
            document.getElementById('tableB').classList.add('hidden');
            document.getElementById('mapB').classList.remove('hidden');
        }
    }

    // Sort table function
    let sortDirections = [true, true, true, true, true, true, true]; // Default sort directions

    function sortTable(columnIndex) {
        const table = document.getElementById('dataTable');
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


    function exportTable() {
        var format = document.getElementById('exportFormatTable').value;
        var table = document.getElementById('dataTable');
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
        fetch('../../map/condamnari_data.json') // Încărcăm fișierul judete.json
            .then(response => response.json())
            .then(data => {
                // Selectarea tabelului și antetelor
                var table = document.getElementById('dataTable');
                var headers = Array.from(table.querySelectorAll('thead th')).map(header => header.innerText.trim());

                // Colectarea datelor din fiecare rând al tabelului
                var rows = [];

                Array.from(table.querySelectorAll('tbody tr')).forEach(row => {
                    var rowData = Array.from(row.querySelectorAll('td')).map(cell => cell.innerText.trim());
                    rows.push(rowData);
                });


                Object.keys(data).forEach(judet => {

                    data[judet].ani.forEach(an => {
                            var rowData = [
                                judet,
                                an.condamnari,
                                an.alte_infractiuni
                                an.an,
                            ];
                            rows.push(rowData);
                    });
                });

                // Construim șirul CSV
                var csvContent = "data:text/csv;charset=utf-8,";

                // Adăugăm antetul la șirul CSV
                csvContent += headers.join(',') + '\n';

                // Adăugăm datele din fiecare rând la șirul CSV
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

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("svg path").forEach(function(path) {
            path.addEventListener("click", function() {
                var regiune = this.getAttribute("id");
                fetch(`get_judet_info.php?regiune=${regiune}`)
                    .then(response => response.json())
                    .then(data => {
                        var infoContainer = document.getElementById("info-container");
                        infoContainer.innerHTML = `
                            <h2>${regiune}</h2>
                            <p>Populație: ${data.populatie}</p>
                            <p>Suprafață: ${data.suprafata}</p>
                            <p>Densitate: ${data.densitate}</p>
                        `;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });

    startYearSliderMap = document.getElementById('startYearSliderMap');
    startYearSliderMap.addEventListener('input', updateYearMap);

    function updateYearMap()
    {
        const yearMapStart = document.getElementById('startYearSliderMap');
        const yearMapSelect = document.getElementById('selectedYearMap');

        yearMapSelect.textContent = yearMapStart.value;
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
        <select id="exportFormatTable" class="export-format">
            <option value="png">PNG</option>
            <option value="svg">SVG</option>
        </select>
    </label>
    <button class="text-button" onclick="exportTable()">Export Table</button>
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
