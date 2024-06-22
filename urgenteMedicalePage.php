<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Urgente Medicale</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="map/style.css">
    <link rel="stylesheet" href="style_element_pagina.css">
    <?php include "NavBar.php"; ?>
    <script src="map/map_interactions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
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


$graphDataQuery1 = "SELECT * FROM urgente_tip_sex WHERE sex='Masculin' ORDER BY year";
$graphDataStmt1 = $dbConnection->prepare($graphDataQuery1);
$graphDataStmt1->execute();
$graphData1 = $graphDataStmt1->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery2 = "SELECT * FROM urgente_tip_sex WHERE sex='Feminin' ORDER BY year";
$graphDataStmt2 = $dbConnection->prepare($graphDataQuery2);
$graphDataStmt2->execute();
$graphData2 = $graphDataStmt2->fetchAll(PDO::FETCH_ASSOC);

echo "<script>
    var graphData1 = " . json_encode($graphData1) . "; 
     
   var graphData2 = " . json_encode($graphData2) . "; 
         
    </script>";

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
            <th><div class="header-container" onclick="sortTable(1)">Masculin <span class="sort-arrow" id="arrow-1"></span></div></th>
            <th><div class="header-container" onclick="sortTable(2)">Feminin <span class="sort-arrow" id="arrow-2"></span></div></th>

        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div id="Map" class="tabcontent">

    <div id="map-container">
        <div class="map-image">
            <?php echo file_get_contents('map/romania_map.svg'); ?>
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

    var male = graphData1.map(function(e) {

        let values = Object.values(e);
        let selectedValues = values.slice(2, -1);
        let sum = 0;

        selectedValues.forEach(function(value) {
            console.log(value);
            sum +=value;
        });

        return sum;
    });

    var female = graphData2.map(function(e) {
        let values = Object.values(e);
        let selectedValues = values.slice(2, -1);
        let sum = 0;

        selectedValues.forEach(function(value) {
            console.log(value);
            sum +=value;
        });

        return sum;
    });



    const graficLinie = new Chart(ctx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [
                {
                    label: 'Masculin',
                    data: male,
                    fill: false,
                    borderColor: 'rgb(0, 0, 204)',
                    tension: 0.1
                },
                {
                    label: 'Feminin',
                    data: female,
                    fill: false,
                    borderColor: 'rgb(255, 0, 255)',
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
        const filteredMale = male.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredFemale = female.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);

        graficLinie.data.labels = filteredYears;
        graficLinie.data.datasets[0].data = filteredMale;
        graficLinie.data.datasets[1].data = filteredFemale;

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

            cell1.innerHTML = years[i];
            cell2.innerHTML = male[i];
            cell3.innerHTML = female[i];

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

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("svg path").forEach(function(path) {
            path.addEventListener("click", function() {
                var regiune = this.getAttribute("id");
                fetch(`get_regiune_info.php?regiune=${regiune}`)
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
    <button class="text-button" onclick="">Export Map</button>
</div>

<?php include "footer.php";?>
</body>
</html>
