<?php
class UrgenteMedicaleManager extends DataManager{

    public function uploadInDataBase($year,$uploadFile): void
    {
        $f = $this->openCSV($uploadFile);
        $afisareOdata=0;

        $statements = [
            'sex' => $this->dbConnection->prepare("INSERT INTO urgente_tip_sex (sex, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)"),
            'varsta' => $this->dbConnection->prepare("INSERT INTO urgente_tip_varsta (varsta, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)"),
            'cale' => $this->dbConnection->prepare("INSERT INTO urgente_tip_cale (cale, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)"),
            'model' => $this->dbConnection->prepare("INSERT INTO urgente_tip_model (model, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)"),
            'diagnostic' => $this->dbConnection->prepare("INSERT INTO urgente_tip_diagnostic (diagnostic, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)")
        ];

        $current_section = '';
        while (($row = fgetcsv($f)) !== false) {
            $row = $this->convertToUTF8($row);

            if (stripos($row[0], 'sex') !== false) {
                $current_section = 'sex';
                continue;
            } elseif (stripos($row[0], 'vârstă') !== false) {
                $current_section = 'varsta';
                continue;
            } elseif (stripos($row[0], 'calea de administrare') !== false) {
                $current_section = 'cale';
                continue;
            } elseif (stripos($row[0], 'modelul de consum') !== false) {
                $current_section = 'model';
                continue;
            } elseif (stripos($row[0], 'diagnosticul de urgență') !== false) {
                $current_section = 'diagnostic';
                continue;
            }

            if (isset($statements[$current_section])) {
                $params = array_merge(array_slice($row, 0, 5), [$year]);
                $statements[$current_section]->execute($params);
                if(!$afisareOdata) {
                    echo "Datele au fost adăugate cu succes în baza de date.";
                    $afisareOdata=1;
                }
            }
        }

        fclose($f);
    }

    public function generateDataInUrgenteMedicale($year): void {
        // Anul pentru care se generează datele
        $an = $year;

        // Lista de județe din România fără diacritice
        $judete = [
            "Alba", "Arad", "Arges", "Bacau", "Bihor", "Bistrita-Nasaud", "Botosani", "Braila", "Brasov", "Bucuresti",
            "Buzau", "Calarasi", "Caras-Severin", "Cluj", "Constanta", "Covasna", "Dambovita", "Dolj", "Galati", "Giurgiu",
            "Gorj", "Harghita", "Hunedoara", "Ialomita", "Iasi", "Ilfov", "Maramures", "Mehedinti", "Mures", "Neamt", "Olt",
            "Prahova", "Satu Mare", "Salaj", "Sibiu", "Suceava", "Teleorman", "Timis", "Tulcea", "Valcea", "Vaslui", "Vrancea"
        ];

        $results = [];

        // Încărcăm datele din fișierul JSON existent
        $file_path = '../map/urgente_medicale_data.json';
        $json_data = file_get_contents($file_path);
        $existing_data = json_decode($json_data, true);

        // Generarea și inserarea datelor
        foreach ($judete as $judet) {
            // Verificăm dacă există deja date pentru același an în baza de date
            $sql_check_duplicate = "SELECT COUNT(*) AS cnt FROM urgente_medicale_judete WHERE judete = ? AND an = ?";
            $stmt_check_duplicate = $this->dbConnection->prepare($sql_check_duplicate);
            $stmt_check_duplicate->bindParam(1, $judet, PDO::PARAM_STR);
            $stmt_check_duplicate->bindParam(2, $an, PDO::PARAM_INT);
            $stmt_check_duplicate->execute();
            $duplicate_row = $stmt_check_duplicate->fetch(PDO::FETCH_ASSOC);

            if ($duplicate_row['cnt'] > 0) {
                $results[1] = "Datele pentru anul '$an'  există deja în baza de date.";
                continue; // Trecem la următorul județ fără să facem inserare
            }

            $recuperari = rand(10, 200); // Număr aleatoriu de recuperari între 0 și 100
            $interventii = rand(10, 250); // Număr aleatoriu de interventii între 0 și 100
            $bolnavi = rand(0, 50); // Număr aleatoriu de bolnavi între 0 și 100

            // Preparăm declarația SQL pentru inserare în baza de date
            $sql_insert = "INSERT INTO urgente_medicale_judete (judete, an, recuperari, interventii, bolnavi) 
                       VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $this->dbConnection->prepare($sql_insert);
            $stmt_insert->bindParam(1, $judet, PDO::PARAM_STR);
            $stmt_insert->bindParam(2, $an, PDO::PARAM_INT);
            $stmt_insert->bindParam(3, $recuperari, PDO::PARAM_INT);
            $stmt_insert->bindParam(4, $interventii, PDO::PARAM_INT);
            $stmt_insert->bindParam(5, $bolnavi, PDO::PARAM_INT);

            if ($stmt_insert->execute()) {
                $results[2] = "Datele pentru anul '$an'  au fost inserate cu succes în baza de date.";

                // Adăugăm datele generate în structura JSON
                if (!isset($existing_data[$judet])) {
                    $existing_data[$judet] = ['ani' => []];
                }

                $existing_data[$judet]['ani'][] = [
                    'an' => $an,
                    'recuperari' => $recuperari,
                    'interventii' => $interventii,
                    'bolnavi' => $bolnavi
                ];
            } else {
                $results[3] = "Eroare la inserarea datelor pentru anul '$an' : " . $stmt_insert->errorInfo()[2];
            }
        }

        // Salvăm JSON-ul actualizat înapoi în fișier
        $updated_json_data = json_encode($existing_data, JSON_PRETTY_PRINT);
        if (file_put_contents($file_path, $updated_json_data) === false) {
            $results[4] = "Eroare la actualizarea fișierului JSON.";
        } else {
            $results[5] = "Fișierul JSON a fost actualizat cu noile date.";
        }

        // Întoarcem răspunsul în format JSON cu rezultatele operațiunilor
        if (empty($results)) {
            echo json_encode(['message' => 'Datele au fost generate cu succes. Datele au fost inserate în JSON cu succes.']);
        } else {
            echo json_encode(['message' => implode(". ", $results) . "."]);
        }
    }

}