document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll("svg path").forEach(function(path) {
        path.addEventListener("click", function() {
            var judet = this.getAttribute("id");
            fetch(`get_judet_info.php?judet=${judet}`)
                .then(response => response.json())
                .then(data => {
                    var infoContainer = document.getElementById("info-container");
                    infoContainer.innerHTML = `
                        <h2>${judet}</h2>
                        <p>Populație: ${data.populatie}</p>
                        <p>Suprafață: ${data.suprafata}</p>
                        <p>Densitate: ${data.densitate}</p>
                    `;
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
