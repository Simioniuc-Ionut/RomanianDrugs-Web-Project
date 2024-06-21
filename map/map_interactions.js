document.addEventListener('DOMContentLoaded', function() {
    // Selectează toate elementele <path> din SVG
    var judete = document.querySelectorAll('.judet');
    var tooltip = document.getElementById('tooltip');

    // Adaugă event listener pentru fiecare județ
    judete.forEach(function(judet) {
        judet.addEventListener('click', function(event) {
            var regionId = judet.id; // ID-ul județului
            fetch(`map/get_judet_info.php?judet=${regionId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        tooltip.innerHTML = "No data found yet.";
                    } else {
                        // Actualizează tooltip-ul
                        tooltip.innerHTML = `
                            <strong>${data.nume}</strong><br>
                            Populatie: ${data.populatie}<br>
                            Suprafata: ${data.suprafata}<br>
                            Densitate: ${data.densitate}
                        `;
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
});
