document.addEventListener('DOMContentLoaded', function() {

    var judete = document.querySelectorAll('.judet');
    var tooltip = document.getElementById('tooltip');
    var selectedYearMap = document.getElementById('selectedYearMap');
    var startYearSliderMap = document.getElementById('startYearSliderMap');

    var selectedDrug = document.getElementById('drug-name');
    var drugName = selectedDrug.textContent.trim();

    // Adaugăm o variabilă globală pentru calea către fișierul JSON specific fiecărei pagini
    var dataFile = 'drug_data.json'; // Default

    // Verificăm dacă există un atribut data-file specificat pe body pentru a decide ce fișier JSON să folosim
    if (document.body.dataset.file) {
        dataFile = document.body.dataset.file;
    }
    console.log(drugName);

    judete.forEach(function(judet) {
        judet.addEventListener('click', function(event) {
            var regionId = judet.id;
            fetch(`../../map/get_judet_info.php?judet=${regionId}&dataFile=${dataFile}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        tooltip.innerHTML = "No data found yet.";
                    } else {
                        var selectedYear = selectedYearMap.textContent; // Anul selectat
                        var found = false;

                        data.drugs.forEach(function(drug) {
                            drug.ani.forEach(function(anData) {
                                if ( drug.drugname.toLowerCase() === drugName.toLowerCase() && anData.an === selectedYear) {
                                    tooltip.innerHTML = `
                                        <strong> Drug: ${drug.drugname} </strong><br>
                                        Confiscari: ${anData.confiscari}<br>
                                        Total droguri: ${anData.total_droguri}<br>
                                        An: ${anData.an}
                                    `;
                                    found = true;
                                }
                            });
                        });

                        if (!found) {
                            tooltip.innerHTML = "No data for selected year and drug.";
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
});
