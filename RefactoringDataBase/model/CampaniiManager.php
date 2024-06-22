<?php
class CampaniiManager extends DataManager{

    public function uploadInDataBase($year,$uploadFile): void
    {
        $f = $this->openCSV($uploadFile);
        $afisareOdata=0;
        $insert_statement = $this->dbConnection->prepare("INSERT INTO campanii_prevenire (proiecte, nr_activitati, year) VALUES (?, ?, ?)");

        while (($row = fgetcsv($f)) !== false) {
            $insert_statement->execute([$row[0], $row[1], $year]);
            if(!$afisareOdata) {
                echo "Datele au fost adăugate cu succes în baza de date.";
                $afisareOdata=1;
            }
        }

        fclose($f);
    }
    public function generateCampaignDataInJudete($year): void {
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
        $file_path = '../map/campanii_data.json';
        $json_data = file_get_contents($file_path);
        $existing_data = json_decode($json_data, true);

        // Generarea și inserarea datelor
        foreach ($judete as $judet) {
            // Verificăm dacă există deja date pentru același an în baza de date
            $sql_check_duplicate = "SELECT COUNT(*) AS cnt FROM campanii_judete WHERE judete = ? AND an = ?";
            $stmt_check_duplicate = $this->dbConnection->prepare($sql_check_duplicate);
            $stmt_check_duplicate->bindParam(1, $judet, PDO::PARAM_STR);
            $stmt_check_duplicate->bindParam(2, $an, PDO::PARAM_INT);
            $stmt_check_duplicate->execute();
            $duplicate_row = $stmt_check_duplicate->fetch(PDO::FETCH_ASSOC);

            if ($duplicate_row['cnt'] > 0) {
                $results[0] = "Datele pentru anul '$an'  există deja în baza de date.";
                continue; // Trecem la următorul județ fără să facem inserare
            }

            $campanii_prevenire = rand(0, 50); // Număr aleatoriu de campanii de prevenire între 0 și 50
            $campanii_combatere = rand(0, 50); // Număr aleatoriu de campanii de combatere între 0 și 50

            // Preparăm declarația SQL pentru inserare în baza de date
            $sql_insert = "INSERT INTO campanii_judete (judete, an, campanii_prevenire, campanii_combatere) 
                       VALUES (?, ?, ?, ?)";
            $stmt_insert = $this->dbConnection->prepare($sql_insert);
            $stmt_insert->bindParam(1, $judet, PDO::PARAM_STR);
            $stmt_insert->bindParam(2, $an, PDO::PARAM_INT);
            $stmt_insert->bindParam(3, $campanii_prevenire, PDO::PARAM_INT);
            $stmt_insert->bindParam(4, $campanii_combatere, PDO::PARAM_INT);

            if ($stmt_insert->execute()) {
                $results[1] = "Datele pentru anul '$an'  au fost inserate cu succes în baza de date.";

                // Adăugăm datele generate în structura JSON
                if (!isset($existing_data[$judet])) {
                    $existing_data[$judet] = ['ani' => []];
                }

                $existing_data[$judet]['ani'][] = [
                    'an' => $an,
                    'campanii_prevenire' => $campanii_prevenire,
                    'campanii_combatere' => $campanii_combatere
                ];
            } else {
                $results[2] = "Eroare la inserarea datelor pentru anul '$an' : " . $stmt_insert->errorInfo()[2];
            }
        }

        // Salvăm JSON-ul actualizat înapoi în fișier
        $updated_json_data = json_encode($existing_data, JSON_PRETTY_PRINT);
        if (file_put_contents($file_path, $updated_json_data) === false) {
            $results[3] = "Eroare la actualizarea fișierului JSON.";
        } else {
            $results[4] = "Fișierul JSON a fost actualizat cu noile date.";
        }

        // Întoarcem răspunsul în format JSON cu rezultatele operațiunilor
        if (empty($results)) {
            echo json_encode(['message' => 'Datele au fost generate cu succes. Datele au fost inserate în JSON cu succes.']);
        } else {
            echo json_encode(['message' => implode(". ", $results) . "."]);
        }
    }


}