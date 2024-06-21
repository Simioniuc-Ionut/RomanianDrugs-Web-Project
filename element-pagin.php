<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Romanina Drug Explorer</title>
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

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM drugstable WHERE id = :id";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row) {
        $drugName = $row["name"];
        echo '<div class="container_item">';
        echo '<div class="item-image">';
        echo '<h2 class="item-name">' . $row["name"] . '</h2>';
        echo '<div class="box_image_element">';
        echo '<img src="imaginiDroguri/' . $row["image"] . '" alt="' . $row["name"] . '">';
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

    // Fetch data for the graph
    $graphDataQuery1 = "SELECT year, $drugName FROM urgente_tip_cale ORDER BY year";
    $graphDataStmt1 = $dbConnection->prepare($graphDataQuery1);
    $graphDataStmt1->execute();
    $graphData1 = $graphDataStmt1->fetchAll(PDO::FETCH_ASSOC);

    $graphDataQuery2 = "SELECT year, $drugName FROM urgente_tip_sex WHERE sex='Masculin' ORDER BY year";
    $graphDataStmt2 = $dbConnection->prepare($graphDataQuery2);
    $graphDataStmt2->execute();
    $graphData2 = $graphDataStmt2->fetchAll(PDO::FETCH_ASSOC);

    $graphDataQuery3 = "SELECT year, $drugName FROM urgente_tip_sex WHERE sex='Feminin' ORDER BY year";
    $graphDataStmt3 = $dbConnection->prepare($graphDataQuery3);
    $graphDataStmt3->execute();
    $graphData3 = $graphDataStmt3->fetchAll(PDO::FETCH_ASSOC);

    $graphDataQuery4 = "SELECT year, $drugName FROM urgente_tip_varsta WHERE varsta='<25' ORDER BY year";
    $graphDataStmt4 = $dbConnection->prepare($graphDataQuery4);
    $graphDataStmt4->execute();
    $graphData4 = $graphDataStmt4->fetchAll(PDO::FETCH_ASSOC);

    $graphDataQuery5 = "SELECT year, $drugName FROM urgente_tip_varsta WHERE varsta='25-34' ORDER BY year";
    $graphDataStmt5 = $dbConnection->prepare($graphDataQuery5);
    $graphDataStmt5->execute();
    $graphData5 = $graphDataStmt5->fetchAll(PDO::FETCH_ASSOC);

    $graphDataQuery6 = "SELECT year, $drugName FROM urgente_tip_varsta WHERE varsta='>35' ORDER BY year";
    $graphDataStmt6 = $dbConnection->prepare($graphDataQuery6);
    $graphDataStmt6->execute();
    $graphData6 = $graphDataStmt6->fetchAll(PDO::FETCH_ASSOC);

    echo "<script>
    var graphData1 = " . json_encode($graphData1) . "; 
    var drugName = " . json_encode($drugName) . ";
    
    var graphData2 = " . json_encode($graphData2) . "; 
    
    var graphData3 = " . json_encode($graphData3) . "; 
    
    var graphData4 = " . json_encode($graphData4) . "; 
    
    var graphData5 = " . json_encode($graphData5) . ";
    
    var graphData6 = " . json_encode($graphData6) . ";
    
      
    </script>";
} else {
    echo "Nu s-a specificat niciun id.";
}
?>

<div class="tab-buttons">
    <button class="tablinks" onclick="openTab(event, 'Graph')">Graph</button>
    <button class="tablinks" onclick="openTab(event, 'Table')">Table</button>
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
            <th><div class="header-container" onclick="sortTable(1)">TotalConsumption <span class="sort-arrow" id="arrow-1"></span></div></th>
            <th><div class="header-container" onclick="sortTable(2)">Masculin <span class="sort-arrow" id="arrow-2"></span></div></th>
            <th><div class="header-container" onclick="sortTable(3)">Feminin <span class="sort-arrow" id="arrow-3"></span></div></th>
            <th><div class="header-container" onclick="sortTable(4)">&lt;25 <span class="sort-arrow" id="arrow-4"></span></div></th>
            <th><div class="header-container" onclick="sortTable(5)">25-34 <span class="sort-arrow" id="arrow-5"></span></div></th>
            <th><div class="header-container" onclick="sortTable(6)">&gt;35 <span class="sort-arrow" id="arrow-6"></span></div></th>
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
    var ctx = document.getElementById('graficLinie').getContext('2d');

    // Process the PHP data
    var years = graphData1.map(function(e) {
        return e.year;
    });

    var consumption = graphData1.map(function(e) {
        let values = Object.values(e);
        return values;
    });

    var consumption_ma = graphData2.map(function(e) {
        let values = Object.values(e);
        return values;
    });

    var consumption_f = graphData3.map(function(e) {
        let values = Object.values(e);
        return values;
    });

    var consumption_y = graphData4.map(function(e) {
        let values = Object.values(e);
        return values;
    });

    var consumption_mi = graphData5.map(function(e) {
        let values = Object.values(e);
        return values;
    });

    var consumption_o = graphData6.map(function(e) {
        let values = Object.values(e);
        return values;
    });

    const graficLinie = new Chart(ctx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [{
                label: 'Consum in anul respectiv',
                data: consumption,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            },
                {
                    label: 'Masculin',
                    data: consumption_ma,
                    fill: false,
                    borderColor: 'rgb(0, 0, 204)',
                    tension: 0.1
                },
                {
                    label: 'Feminin',
                    data: consumption_f,
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
        const filteredConsumption = consumption.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionMa = consumption_ma.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionF = consumption_f.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionY = consumption_y.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionMi = consumption_mi.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);
        const filteredConsumptionO = consumption_o.filter((_, index) => years[index] >= selectedStartYear && years[index] <= selectedEndYear);

        graficLinie.data.labels = filteredYears;
        graficLinie.data.datasets[0].data = filteredConsumption;
        graficLinie.data.datasets[1].data = filteredConsumptionMa;
        graficLinie.data.datasets[2].data = filteredConsumptionF;
        graficLinie.data.datasets[3].data = filteredConsumptionY;
        graficLinie.data.datasets[4].data = filteredConsumptionMi;
        graficLinie.data.datasets[5].data = filteredConsumptionO;
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

            cell1.innerHTML = years[i];
            cell2.innerHTML = consumption[i][1];
            cell3.innerHTML = consumption_ma[i][1];
            cell4.innerHTML = consumption_f[i][1];
            cell5.innerHTML = consumption_y[i][1];
            cell6.innerHTML = consumption_mi[i][1];
            cell7.innerHTML = consumption_o[i][1];
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
        } else {
            sliderContainer.classList.remove("hidden");
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
</script>

<div class="center">
    <button class="text-button">Generate</button>
</div>

<?php include "footer.php";?>
</body>
</html>
