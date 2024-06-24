<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Romanina Drug Explorer</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../map/style.css">
    <link rel="stylesheet" href="../../style_element_pagina.css">
    <?php include "navBar.php"; ?>
    <script src="../../map/map_interactions.js" data-file="drug_data.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body data-file="drug_data.json">

<?php
require_once "../../RefactoringDataBase/DataBase.php";
$dbConnection = new Database();

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM drugstable WHERE id = :id";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $drugName = $row["name"];
    echo '<div class="container_item">';
    echo '<div class="item-image">';
    echo '<h2 id="drug-name" class="item-name">' . $row["name"] . '</h2>';
    echo '<div class="box_image_element">';
    echo '<img src="../../imaginiDroguri/' . $row["image"] . '" alt="' . $row["name"] . '">';
    echo '</div>';
    echo '</div>';
    echo '<div class="details">';
    echo '<p><strong>Type:</strong> ' . $row["type"] . '</p>';
    echo '<p class="item-description"><strong>Description:</strong> ' . $row["description"] . '</p>';
    echo '</div>';
    echo '</div>';
    echo '<div class="center"></div>';
} else {
    echo "Elementul nu a fost găsit.";
}

    //$drugName = strtolower($drugName);

    $graphDataQuery1 = "SELECT year, capturi,mililitri,doze_pe_buc,comprimate,grame FROM droguri_confiscate WHERE name = :drugName ORDER BY year";
    $graphDataStmt1 = $dbConnection->prepare($graphDataQuery1);
    $graphDataStmt1->bindParam(':drugName', $drugName, PDO::PARAM_STR);
    $graphDataStmt1->execute();
    $graphData1 = $graphDataStmt1->fetchAll(PDO::FETCH_ASSOC);


    echo "<script>
    var graphData1 = " . json_encode($graphData1) . "; 
    var drugName = " . json_encode($drugName) . ";
    
    
    </script>";
} else {
    echo "Nu s-a specificat niciun id.";
}
?>

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
            <th><div class="header-container" onclick="sortTable(1)">Confiscări<span class="sort-arrow" id="arrow-1"></span></div></th>
            <th><div class="header-container" onclick="sortTable(2)">Mililitri<span class="sort-arrow" id="arrow-2"></span></div></th>
            <th><div class="header-container" onclick="sortTable(3)">Doze pe Buc<span class="sort-arrow" id="arrow-3"></span></div></th>
            <th><div class="header-container" onclick="sortTable(4)">Comprimate<span class="sort-arrow" id="arrow-4"></span></div></th>
            <th><div class="header-container" onclick="sortTable(5)">Kg<span class="sort-arrow" id="arrow-5"></span></div></th>
        </tr>
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

    var confiscari = graphData1.map(function(e) {
        if(e.capturi)
        return e.capturi;

        return 0;
    });

    var mililitri = graphData1.map(function(e) {
        if(e.mililitri)
            return e.mililitri;

        return 0;
    });

    var doze_pe_buc = graphData1.map(function (e){
        if(e.doze_pe_buc)
            return e.doze_pe_buc;

        return 0;
    });

    var comprimate = graphData1.map(function (e){
        if(e.comprimate)
            return e.comprimate;

        return 0;
    });

    var grame = graphData1.map(function (e){
        if(e.grame)
            return parseInt(e.grame / 1000);

        return 0;
    });

    const graficLinie = new Chart(ctx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [{
                label: 'Confiscari',
                data: confiscari,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            },
                {
                    label: 'Mililitri',
                    data: mililitri,
                    fill: false,
                    borderColor: 'rgb(0,98,255)',
                    tension: 0.1
                },
                {
                    label: 'Doze pe Bucati',
                    data: doze_pe_buc,
                    fill: false,
                    borderColor: 'rgb(208,255,0)',
                    tension: 0.1
                },
                {
                    label: 'Comprimate',
                    data: comprimate,
                    fill: false,
                    borderColor: 'rgb(194,6,6)',
                    tension: 0.1
                },
                {
                    label: 'Kg',
                    data: grame,
                    fill: false,
                    borderColor: 'rgb(0,0,0)',
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

        const selectedStartYear = Math.min(startYear, endYear);
        const selectedEndYear = Math.max(startYear, endYear);

        const filteredYears = years.filter(year => year >= selectedStartYear && year <= selectedEndYear);
        const filteredConfiscari = confiscari.slice(startYear - 2020, endYear - 2020 + 1);
        const filteredMililitri = mililitri.slice(startYear - 2020, endYear - 2020 + 1);
        const filteredDoze_pe_buc = doze_pe_buc.slice(startYear - 2020, endYear - 2020 + 1);
        const filteredComprimate = comprimate.slice(startYear - 2020, endYear - 2020 + 1);
        const filteredGrame = grame.slice(startYear - 2020, endYear - 2020 + 1);

        graficLinie.data.labels = filteredYears;
        graficLinie.data.datasets[0].data = filteredConfiscari;
        graficLinie.data.datasets[1].data = filteredMililitri;
        graficLinie.data.datasets[2].data = filteredDoze_pe_buc;
        graficLinie.data.datasets[3].data = filteredComprimate;
        graficLinie.data.datasets[4].data = filteredGrame;
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

            cell1.innerHTML = years[i];
            cell2.innerHTML = confiscari[i];
            cell3.innerHTML = mililitri[i];
            cell4.innerHTML = doze_pe_buc[i];
            cell5.innerHTML = comprimate[i];
            cell6.innerHTML = grame[i];

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

    startYearSliderMap = document.getElementById('startYearSliderMap');
    startYearSliderMap.addEventListener('input', updateYearMap);

    function exportAll() {
        fetch('../../map/judete.json') // Încărcăm fișierul judete.json
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

                        data[judet].drugs.forEach(drug => {
                            drug.ani.forEach(an => {
                                var rowData = [
                                    judet, // Numele județului
                                    drug.drugname, // Numele substanței drog
                                    an.an, // Anul
                                    an.confiscari, // Numărul de confiscări
                                    an.total_droguri // Totalul de droguri
                                ];
                                rows.push(rowData);
                            });
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
