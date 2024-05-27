<?php
require 'db_connect.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $uploadDirectory = './fisiere_date/';
    $uploadFile = $uploadDirectory . basename($file['name']);

    // Verificăm dacă fișierul a fost încărcat cu succes
    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        // Extragem anul și tipul din numele fișierului
        if (preg_match('/(capturi-droguri|infractionalitate|proiecte-si-campanii|urgente_medicale)-(\d{4})\.csv/', $file['name'], $matches)) {
            $fileType = $matches[1];
            $year = $matches[2];
            try {
                switch ($fileType) {
                    case 'capturi-droguri':
                        addCapturiDroguri($year);
                        break;
                    case 'infractionalitate':
                        addInfractionalitati($year);
                        break;
                    case 'proiecte-si-campanii':
                        addProiecteSiCampanii($year);
                        break;
                    case 'urgente_medicale':
                        addUrgenteMedicale($year);
                        break;
                    default:
                        throw new Exception('Tip de fișier necunoscut.');
                }
                echo 'Ai adăugat cu succes în baza de date.';
            } catch (Exception $e) {
                echo 'Eroare la adăugarea în baza de date: ' . $e->getMessage();
            }
        } else {
            echo 'Numele fișierului nu este valid. Trebuie să fie de forma tip-fișier-YYYY.csv';
        }
    } else {
        echo 'Eroare la încărcarea fișierului.';
    }
} else {
    echo 'Vă rugăm să încărcați un fișier CSV.';
}
?>
