document.addEventListener('DOMContentLoaded', function() {
    // Selectează toate elementele <path> din SVG
    var judete = document.querySelectorAll('.judet');

    // Adaugă event listener pentru fiecare județ
    judete.forEach(function(judet) {
        judet.addEventListener('click', function() {
            var regionId = judet.id; // ID-ul județului
            fetch(`get_judet_info.php?judet=${regionId}`)
                .then(response => response.json())
                .then(data => {
                    // Actualizează conținutul containerului de informații
                    document.getElementById('region-title').textContent = data.nume;
                    document.getElementById('region-population').textContent = "Populație: " + data.populatie;
                    document.getElementById('region-area').textContent = "Suprafață: " + data.suprafata;
                    document.getElementById('region-density').textContent = "Densitate: " + data.densitate;
                    document.getElementById('region-description').textContent = data.descriere;
                })
                .catch(error => console.error('Error:', error));
        });
    });
});