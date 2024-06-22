<?php

class InfractionalitatiManager extends DataManager{

    public function uploadInDataBase($year,$uploadFile): void
    {
        $f = $this->openCSV($uploadFile);
        $afisareOdata=0;

        $statements = [
            'persoane_cercetate_judecata_condamnate' => $this->dbConnection->prepare("INSERT INTO persoane_cercetate_judecata_condamnate (categorie, numar, year) VALUES (?, ?, ?)"),
            'persoane_condamnate_incadrarea_juridica' => $this->dbConnection->prepare("INSERT INTO persoane_condamnate_incadrarea_juridica (incadrare_juridica, numar, year) VALUES (?, ?, ?)"),
            'persoane_condamnate_sexe' => $this->dbConnection->prepare("INSERT INTO persoane_condamnate_sexe (sex, majore, minore, year) VALUES (?, ?, ?, ?)"),
            'grupari_infractionale' => $this->dbConnection->prepare("INSERT INTO grupari_infractionale (categorie, numar, year) VALUES (?, ?, ?)"),
            'pedepse_aplicate' => $this->dbConnection->prepare("INSERT INTO pedepse_aplicate (tip_pedeapsa, lege_143_2000, lege_194_2011, year) VALUES (?, ?, ?, ?)")
        ];

        $current_section = '';
        while (($row = fgetcsv($f)) !== false) {
            $row = $this->convertToUTF8($row);

            if (mb_strpos($row[0], 'PERSOANE CERCETATE') !== false) {
                $current_section = 'persoane_cercetate_judecata_condamnate';
                continue;
            } elseif (mb_strpos($row[0], 'PERSOANE CONDAMNATE') !== false && mb_strpos($row[0], 'PE SEXE') === false) {
                $current_section = 'persoane_condamnate_incadrarea_juridica';
                continue;
            } elseif (mb_strpos($row[0], 'PE SEXE') !== false) {
                $current_section = 'persoane_condamnate_sexe';
                continue;
            } elseif (mb_strpos($row[0], 'GRUPARILOR INFRACTIONALE') !== false) {
                $current_section = 'grupari_infractionale';
                continue;
            } elseif (mb_strpos($row[0], 'PEDEPSELOR APLICATE') !== false) {
                $current_section = 'pedepse_aplicate';
                continue;
            }

            if (isset($statements[$current_section])) {
                $params = $current_section === 'persoane_condamnate_sexe' ? array_merge(array_slice($row, 0, 3), [$year]) : array_merge(array_slice($row, 0, 2), [$year]);
                $statements[$current_section]->execute($params);
                if(!$afisareOdata) {
                    echo "Datele au fost adăugate cu succes în baza de date.";
                    $afisareOdata=1;
                }
            }
        }

        fclose($f);
    }
    public function generateDataInInfractiuni($year): void {
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
        $file_path = '../map/condamnari_data.json';
        $json_data = file_get_contents($file_path);
        $existing_data = json_decode($json_data, true);

        // Generarea și inserarea datelor
        foreach ($judete as $judet) {
            // Verificăm dacă există deja date pentru același an în baza de date
            $sql_check_duplicate = "SELECT COUNT(*) AS cnt FROM condamnari_judete WHERE judete = ? AND an = ?";
            $stmt_check_duplicate = $this->dbConnection->prepare($sql_check_duplicate);
            $stmt_check_duplicate->bindParam(1, $judet, PDO::PARAM_STR);
            $stmt_check_duplicate->bindParam(2, $an, PDO::PARAM_INT);
            $stmt_check_duplicate->execute();
            $duplicate_row = $stmt_check_duplicate->fetch(PDO::FETCH_ASSOC);

            if ($duplicate_row['cnt'] > 0) {
                $results[0] = "Datele pentru anul '$an'  există deja în baza de date.";
                continue; // Trecem la următorul județ fără să facem inserare
            }

            $condamnari = rand(0, 100); // Număr aleatoriu de condamnari între 0 și 100
            $alte_infractiuni = rand(0, 100); // Număr aleatoriu de alte infractiuni între 0 și 100

            // Preparăm declarația SQL pentru inserare în baza de date
            $sql_insert = "INSERT INTO condamnari_judete (judete, an, condamnari, alte_infractiuni) 
                       VALUES (?, ?, ?, ?)";
            $stmt_insert = $this->dbConnection->prepare($sql_insert);
            $stmt_insert->bindParam(1, $judet, PDO::PARAM_STR);
            $stmt_insert->bindParam(2, $an, PDO::PARAM_INT);
            $stmt_insert->bindParam(3, $condamnari, PDO::PARAM_INT);
            $stmt_insert->bindParam(4, $alte_infractiuni, PDO::PARAM_INT);

            if ($stmt_insert->execute()) {
                $results[1] = "Datele pentru anul '$an'  au fost inserate cu succes în baza de date.";

                // Adăugăm datele generate în structura JSON
                if (!isset($existing_data[$judet])) {
                    $existing_data[$judet] = ['ani' => []];
                }

                $existing_data[$judet]['ani'][] = [
                    'an' => $an,
                    'condamnari' => $condamnari,
                    'alte_infractiuni' => $alte_infractiuni
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