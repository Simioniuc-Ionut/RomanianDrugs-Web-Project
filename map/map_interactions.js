document.addEventListener('DOMContentLoaded', function() {
    var judete = document.querySelectorAll('.judet');
    var tooltip = document.getElementById('tooltip');
    var selectedYearMap = document.getElementById('selectedYearMap');
    var startYearSliderMap = document.getElementById('startYearSliderMap');
    var selectedDrug = document.getElementById('drug-name');
    var drugName = selectedDrug ? selectedDrug.textContent.trim() : null; // Verificăm dacă există selectedDrug


    // Verificăm dacă există atributul data-file pe body pentru a decide ce fișier JSON să folosim
    var dataFile = document.body.dataset.file;

    if (!dataFile) {
        console.error('No data-file attribute specified on the body element.');
        return; // Întrerupe execuția în cazul în care nu există data-file specificat
    }

    judete.forEach(function(judet) {
        judet.addEventListener('click', function(event) {
            var regionId = judet.id;
            fetch(`../../map/get_judet_info.php?judet=${regionId}&dataFile=${dataFile}`)
                .then(response => {
                    console.log('Response status:', response.status); // Verifică statusul răspunsului HTTP
                   return response.json();
                })
                .then(data => {
                    // Funcție de debugging pentru a afișa datele primite
                    debugDataReceived(data);

                    if (data.error) {
                        tooltip.innerHTML = "No data found yet.";
                    } else {
                        var selectedYear = selectedYearMap.textContent; // Anul selectat
                        var found = false;

                        // Switch pentru a decide cum să căutăm în funcție de tipul de fișier JSON
                        switch (dataFile) {
                            case 'drug_data.json':
                                if (data.drugs) {
                                    data.drugs.forEach(function(drug) {
                                        drug.ani.forEach(function(anData) {
                                            if (drug.drugname.toLowerCase() === drugName.toLowerCase() && anData.an === selectedYear) {
                                                tooltip.innerHTML = `
                                                    <strong> Drug: ${drug.drugname} </strong><br>
                                                    Confiscări: ${anData.confiscari}<br>
                                                    Total droguri: ${anData.total_droguri}<br>
                                                    An: ${anData.an}
                                                `;
                                                found = true;
                                            }
                                        });
                                    });
                                }
                                break;
                            case 'campanii_data.json':
                                //debug
                                console.log(regionId + ' ' + selectedYear + ' ' + data[regionId]);
                                if (data.ani) {
                                    data.ani.forEach(function(anData) {
                                        if (anData.an === selectedYear) {
                                            console.log('Data found for year:', selectedYear);
                                            tooltip.innerHTML = `
                                                <strong> An: ${anData.an} </strong><br>
                                                Campanii de prevenire: ${anData.campanii_prevenire}<br>
                                                Campanii de combatere: ${anData.campanii_combatere}<br>
                                            `;
                                            found = true;
                                        }

                                    });
                                }
                                break;
                            case 'condamnari_data.json':
                                if (data.ani) {
                                    data.ani.forEach(function(anData) {
                                        if (anData.an === selectedYear) {
                                            tooltip.innerHTML = `
                                                An: ${anData.an}<br>
                                                Condamnări: ${anData.condamnari}<br>
                                                Alte infracțiuni: ${anData.alte_infractiuni}
                                            `;
                                            found = true;
                                        }
                                    });
                                }
                                break;
                            case 'urgente_medicale_data.json':
                                if (data.ani) {
                                    data.ani.forEach(function(anData) {
                                        if (anData.an === selectedYear) {
                                            tooltip.innerHTML = `
                                                An: ${anData.an}<br>
                                                Recuperări: ${anData.recuperari}<br>
                                                Intervenții: ${anData.interventii}<br>
                                                Bolnavi: ${anData.bolnavi}
                                            `;
                                            found = true;
                                        }
                                    });
                                }
                                break;
                            default:
                                tooltip.innerHTML = "Invalid data file specified.";
                        }

                        if (!found) {
                            tooltip.innerHTML = "No data for selected year.";
                        }
                    }

                    tooltip.style.left = `${event.pageX + 10}px`;
                    tooltip.style.top = `${event.pageY + 10}px`;
                    tooltip.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    tooltip.innerHTML = "No data found yet.";
                    tooltip.style.left = `${event.pageX + 10}px`;
                    tooltip.style.top = `${event.pageY + 10}px`;
                    tooltip.classList.remove('hidden');
                });
        });

        judet.addEventListener('mousemove', function(event) {
            tooltip.style.left = `${event.pageX + 10}px`;
            tooltip.style.top = `${event.pageY + 10}px`;
        });

        judet.addEventListener('mouseleave', function() {
            tooltip.classList.add('hidden');
        });
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.judet')) {
            tooltip.classList.add('hidden');
        }
    });

    startYearSliderMap.addEventListener('input', updateYearMap);

    function updateYearMap() {
        var yearMapStart = document.getElementById('startYearSliderMap');
        selectedYearMap.textContent = yearMapStart.value;
    }

    // Funcție de debugging pentru a afișa datele primite în consolă
    function debugDataReceived(data) {
        console.log('Received data:', data);
    }

});

function exportMap() {
    var format = document.getElementById('exportFormatMap').value;
    var mapContainer = document.getElementById('map-container');

    if (format === 'png') {
        var svgElement = document.querySelector('svg');
        var svgData = new XMLSerializer().serializeToString(svgElement);
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var img = new Image();

        img.onload = function() {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);
            var link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'map.png';
            link.click();
        };

        var svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
        var url = URL.createObjectURL(svgBlob);
        img.src = url;
    } else if (format === 'svg') {
        var svgData = new XMLSerializer().serializeToString(document.querySelector('svg'));
        var svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
        var link = document.createElement('a');
        link.href = URL.createObjectURL(svgBlob);
        link.download = 'map.svg';
        link.click();
    }
}
