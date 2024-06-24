<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Urgente Medicale</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../map/style.css">
    <link rel="stylesheet" href="../../style_element_pagina.css">
    <?php include "navBar.php"; ?>
    <script src="../../map/map_interactions.js" data-file="urgente_medicale_data.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body data-file="urgente_medicale_data.json">

<?php
require_once "../../RefactoringDataBase/DataBase.php";
 $dbConnection= new Database();

$graphDataQuery1 = "SELECT * FROM urgente_tip_sex WHERE sex='Masculin' ORDER BY year";
$graphDataStmt1 = $dbConnection->prepare($graphDataQuery1);
$graphDataStmt1->execute();
$graphData1 = $graphDataStmt1->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery2 = "SELECT * FROM urgente_tip_sex WHERE sex='Feminin' ORDER BY year";
$graphDataStmt2 = $dbConnection->prepare($graphDataQuery2);
$graphDataStmt2->execute();
$graphData2 = $graphDataStmt2->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery4 = "SELECT * FROM urgente_tip_varsta WHERE varsta='<25' ORDER BY year";
$graphDataStmt4 = $dbConnection->prepare($graphDataQuery4);
$graphDataStmt4->execute();
$graphData4 = $graphDataStmt4->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery5 = "SELECT * FROM urgente_tip_varsta WHERE varsta='25-34' ORDER BY year";
$graphDataStmt5 = $dbConnection->prepare($graphDataQuery5);
$graphDataStmt5->execute();
$graphData5 = $graphDataStmt5->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery6 = "SELECT * FROM urgente_tip_varsta WHERE varsta='>35' ORDER BY year";
$graphDataStmt6 = $dbConnection->prepare($graphDataQuery6);
$graphDataStmt6->execute();
$graphData6 = $graphDataStmt6->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery7 = "SELECT * FROM urgente_tip_cale WHERE cale ='Oral/fumat/prizat' ORDER BY year";
$graphDataStmt7 = $dbConnection->prepare($graphDataQuery7);
$graphDataStmt7->execute();
$graphData7 = $graphDataStmt7->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery8 = "SELECT * FROM urgente_tip_cale WHERE cale ='Injectabil' ORDER BY year";
$graphDataStmt8 = $dbConnection->prepare($graphDataQuery8);
$graphDataStmt8->execute();
$graphData8 = $graphDataStmt8->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery9 = "SELECT * FROM urgente_tip_model WHERE model ='Consum singular' ORDER BY year";
$graphDataStmt9 = $dbConnection->prepare($graphDataQuery9);
$graphDataStmt9->execute();
$graphData9 = $graphDataStmt9->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery10 = "SELECT * FROM urgente_tip_model WHERE model ='Consum combinat' ORDER BY year";
$graphDataStmt10 = $dbConnection->prepare($graphDataQuery10);
$graphDataStmt10->execute();
$graphData10 = $graphDataStmt10->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery11 = "SELECT * FROM urgente_tip_diagnostic WHERE diagnostic ='Supradoză' ORDER BY year";
$graphDataStmt11 = $dbConnection->prepare($graphDataQuery11);
$graphDataStmt11->execute();
$graphData11 = $graphDataStmt11->fetchAll(PDO::FETCH_ASSOC);

$graphDataQuery12 = "SELECT * FROM urgente_tip_diagnostic WHERE diagnostic ='Sevraj' ORDER BY year";
$graphDataStmt12 = $dbConnection->prepare($graphDataQuery12);
$graphDataStmt12->execute();
$graphData12 = $graphDataStmt12->fetchAll(PDO::FETCH_ASSOC);

echo "<script>
    var graphData1 = " . json_encode($graphData1) . ";    
    var graphData2 = " . json_encode($graphData2) . "; 
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
    <h2 class="item-name">Urgente Medicale</h2>
    <div class="box_image_element">
    <img src="../../imaginiDroguri/urgenteMedicale.jpg" alt="Urgente Medicale" style="width:100%;max-width:300px">
    </div>
    </div>
    <div class="details">
        <p><strong>Type:</strong> Statisticile pentru Urgente Medicale în funcție de an, sex și vârstă</p>
        <p class="item-description"><strong>Description:</strong> Datele statistice despre urgențele medicale înregistrate în diferite categorii. Aceste date sunt esențiale pentru a înțelege tendințele și modelele de urgențe medicale și pentru a informa strategiile de prevenire și intervenție.</p>
    </div>
</div>

<div class="container_item">
    <div class="campaign">
        <h1 class="campaign-title">Urgențele Medicale în Consumul de Droguri</h1>
        <p class="campaign-description">Consumul de droguri provoacă urgente medicale semnificative și este o problemă critică în societatea contemporană, afectând grav sănătatea și bunăstarea indivizilor. Este vital să înțelegem și să gestionăm corect aceste situații pentru a minimiza impactul lor asupra indivizilor și comunităților.</p>
        <h2 class="campaign-section-title">Aspecte Critice ale Urgențelor Medicale</h2>
        <p class="campaign-section-description">Urgențele medicale asociate consumului de droguri implică:</p>
        <ul class="campaign-list">
            <li>Intervenții de urgență pentru supradoze și complicații medicale severe</li>
            <li>Acces la tratamente de salvare și terapii de dezintoxicare</li>
            <li>Educație despre primul ajutor în caz de supradoză</li>
            <li>Sensibilizare cu privire la riscurile imediate și pe termen lung ale drogurilor</li>
            <li>Colaborare cu unitățile de urgență și serviciile de intervenție rapidă</li>
        </ul>

        <h2 class="campaign-section-title">Rolul Comunității în Gestionarea Urgențelor</h2>
        <p class="campaign-section-description">Comunitățile joacă un rol crucial în abordarea urgencelor medicale legate de consumul de droguri. Prin educație continuă și suport reciproc, putem reduce numărul de cazuri de urgențe și contribui la îmbunătățirea accesului la îngrijiri adecvate și prevenție.</p>
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
            <th><div class="header-container" onclick="sortTable(3)">&lt;25 <span class="sort-arrow" id="arrow-3"></span></div></th>
            <th><div class="header-container" onclick="sortTable(4)">25-34 <span class="sort-arrow" id="arrow-4"></span></div></th>
            <th><div class="header-container" onclick="sortTable(5)">&gt;35 <span class="sort-arrow" id="arrow-5"></span></div></th>
            <th><div class="header-container" onclick="sortTable(6)">Oral/fumat/prizat <span class="sort-arrow" id="arrow-6"></span></div></th>
            <th><div class="header-container" onclick="sortTable(7)">Injectabil <span class="sort-arrow" id="arrow-7"></span></div></th>
            <th><div class="header-container" onclick="sortTable(8)">Consum singular<span class="sort-arrow" id="arrow-8"></span></div></th>
            <th><div class="header-container" onclick="sortTable(9)">Consum combinat<span class="sort-arrow" id="arrow-9"></span></div></th>
            <th><div class="header-container" onclick="sortTable(10)">Supradoză<span class="sort-arrow" id="arrow-10"></span></div></th>
            <th><div class="header-container" onclick="sortTable(11)">Sevraj<span class="sort-arrow" id="arrow-11"></span></div></th>
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

    function getSumOfSelectedValues(graphData) {
        return graphData.map(function(e) {
            let values = Object.values(e);
            let selectedValues = values.slice(2, -1);
            let sum = 0;

            selectedValues.forEach(function(value) {
                console.log(value);
                sum += value;
            });

            return sum;
        });
    }

    var male = getSumOfSelectedValues(graphData1);
    var female = getSumOfSelectedValues(graphData2);
    var consumption_y = getSumOfSelectedValues(graphData4);
    var consumption_mi = getSumOfSelectedValues(graphData5);
    var consumption_o = getSumOfSelectedValues(graphData6);
    var consumption_OFP = getSumOfSelectedValues(graphData7);
    var consumption_inj = getSumOfSelectedValues(graphData8);
    var consumption_sing = getSumOfSelectedValues(graphData9);
    var consumption_comb = getSumOfSelectedValues(graphData10);
    var consumption_sup = getSumOfSelectedValues(graphData11);
    var consumption_sev = getSumOfSelectedValues(graphData12);

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
                },
                {
                    label: '<25',
                    data: consumption_y,
                    fill: false,
                    borderColor: 'rgb(208,255,0)',
                    tension: 0.1
                },
                {
                    label: '25-34',
                    data: consumption_mi,
                    fill: false,
                    borderColor: 'rgb(55,255,0)',
                    tension: 0.1
                },
                {
                    label: '>35',
                    data: consumption_o,
                    fill: false,
                    borderColor: 'rgb(168,5,5)',
                    tension: 0.1
                },
                {
                    label: 'Oral/Fumat/Prizat',
                    data: consumption_OFP,
                    fill: false,
                    borderColor: 'rgb(22,60,16)',
                    tension: 0.1
                },
                {
                    label: 'Injectabil',
                    data: consumption_inj,
                    fill: false,
                    borderColor: 'rgb(0,0,0)',
                    tension: 0.1
                },
                {
                    label: 'Consum singular',
                    data: consumption_sing,
                    fill: false,
                    borderColor: 'rgb(162,255,0)',
                    tension: 0.1
                },
                {
                    label: 'Consum combinat',
                    data: consumption_comb,
                    fill: false,
                    borderColor: 'rgb(209,120,21)',
                    tension: 0.1
                },
                {
                    label: 'Supradoză',
                    data: consumption_sup,
                    fill: false,
                    borderColor: 'rgb(237,8,8)',
                    tension: 0.1
                },
                {
                    label: 'Sevraj',
                    data: consumption_sev,
                    fill: false,
                    borderColor: 'rgb(103,15,15)',
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
        const filteredMale = male.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredFemale = female.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionY = consumption_y.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionMi = consumption_mi.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionO = consumption_o.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionOFP = consumption_OFP.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionInj = consumption_inj.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionSing = consumption_sing.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionComb = consumption_comb.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionSup = consumption_sup.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionSev = consumption_sev.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);

        graficLinie.data.labels = filteredYears;
        graficLinie.data.datasets[0].data = filteredMale;
        graficLinie.data.datasets[1].data = filteredFemale;
        graficLinie.data.datasets[2].data = filteredConsumptionY;
        graficLinie.data.datasets[3].data = filteredConsumptionMi;
        graficLinie.data.datasets[4].data = filteredConsumptionO;
        graficLinie.data.datasets[5].data = filteredConsumptionOFP;
        graficLinie.data.datasets[6].data = filteredConsumptionInj;
        graficLinie.data.datasets[7].data = filteredConsumptionSing;
        graficLinie.data.datasets[8].data = filteredConsumptionComb;
        graficLinie.data.datasets[9].data = filteredConsumptionSup;
        graficLinie.data.datasets[10].data = filteredConsumptionSev;


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
            let cell11 = row.insertCell(10);
            let cell12 = row.insertCell(11);

            cell1.innerHTML = years[i] || 0;
            cell2.innerHTML = male[i] || 0;
            cell3.innerHTML = female[i] || 0;
            cell4.innerHTML = consumption_y[i] || 0;
            cell5.innerHTML = consumption_mi[i] || 0;
            cell6.innerHTML = consumption_o[i] || 0;
            cell7.innerHTML = consumption_OFP[i] || 0;
            cell8.innerHTML = consumption_inj[i] || 0;
            cell9.innerHTML = consumption_sing[i] || 0;
            cell10.innerHTML = consumption_comb[i] || 0;
            cell11.innerHTML = consumption_sup[i] || 0;
            cell12.innerHTML = consumption_sev[i] || 0;

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
        fetch('../../map/urgente_medicale_data.json') // Încărcăm fișierul judete.json
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
                            judet,  // Accessing judet (county name) directly
                            an.an,
                            an.interventii,
                            an.bolnavi
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
