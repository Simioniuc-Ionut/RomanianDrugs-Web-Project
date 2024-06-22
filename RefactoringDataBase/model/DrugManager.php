<?php

// DrugManager.php
class DrugManager extends DataManager {
    //upload in db
    public function uploadInDataBase($year,$uploadFile): void
    {
        $f = $this->openCSV($uploadFile);

        $insert_statement = $this->dbConnection->prepare("INSERT INTO droguri_confiscate (id_drog_tip, name, grame, comprimate, doze_pe_buc, mililitri, capturi, year) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_statement2 = $this->dbConnection->prepare("INSERT INTO drugstable (name, type, image, description) VALUES (?, ?, ?, ?)");

        $lineCounter = 0;

        while (($row = fgetcsv($f)) !== false) {
            $row = $this->convertToUTF8($row);
            $lineCounter++;
            if ($lineCounter >= 6) {
                $atribut1 = $row[0];
                $atribut2 = $row[1];
                $atribut3 = $row[2];
                $atribut4 = $row[3];
                $atribut5 = $row[4];
                $atribut6 = $row[5];

                if (!$this->verifyIfDrogNameExist($atribut1)) {
                    $insert_statement2->execute([$atribut1, '', '', '']);
                }

                $drug_id = $this->getIdDrog($atribut1);
                $insert_statement->execute([$drug_id, $atribut1,$atribut2, $atribut3, $atribut4, $atribut5, $atribut6, $year]);

            }
        }

        fclose($f);
    }
    private function verifyIfDrogNameExist($drogName): bool
    {
        $statement = $this->dbConnection->prepare("SELECT COUNT(*) FROM drugstable WHERE name = ?");
        $statement->execute([$drogName]);
        $count = $statement->fetchColumn();
        return $count > 0;
    }
    private function getIdDrog($drogName) {
        $statement = $this->dbConnection->prepare("SELECT id FROM drugstable WHERE name = ?");
        $statement->execute([$drogName]);
        $result = $statement->fetch();
        return $result['id'] ?? null;
    }

    //update in admin
    public function updateDrugDescription($drugName, $description): void {
        try {
            $stmt = $this->dbConnection->prepare("UPDATE drugstable SET description = ? WHERE name = ?");
            $stmt->execute([$description, $drugName]);
            echo json_encode(["message" => "Description updated successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error updating description: " . $e->getMessage()]);
        }
    }

    public function updateDrugName($currentName, $newName): void {
        try {
            $stmt = $this->dbConnection->prepare("UPDATE drugstable SET name = ? WHERE name = ?");
            $stmt->execute([$newName, $currentName]);
            echo json_encode(["message" => "Name updated successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error updating name: " . $e->getMessage()]);
        }
    }

    public function updateDrugType($name, $type): void {
        try {
            $types = implode(',', $type);
            $stmt = $this->dbConnection->prepare("UPDATE drugstable SET type = ? WHERE name = ?");
            $stmt->execute([$types, $name]);
            echo json_encode(["message" => "Type updated successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error updating type: " . $e->getMessage()]);
        }
    }

    public function updateDrugImage($name, $image): void {
        try {
            $stmt = $this->dbConnection->prepare("UPDATE drugstable SET image = ? WHERE name = ?");
            $stmt->execute([$image, $name]);
            echo json_encode(["message" => "Image updated successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error updating image: " . $e->getMessage()]);
        }
    }
    public function getDrugsName(): void {
        try {
            $stmt = $this->dbConnection->prepare("SELECT name FROM drugstable");
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($drugs);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error fetching drugs: " . $e->getMessage()]);
        }
    }
    public function addDrug($name, $type, $image, $description): void {
        try {
            $max_id_query = $this->dbConnection->prepare("SELECT MAX(id) AS max_id FROM drugstable");
            $max_id_query->execute();
            $max_id_row = $max_id_query->fetch(PDO::FETCH_ASSOC);

            $new_drug_id = 1; // Default value if table is empty
            if ($max_id_row !== false && isset($max_id_row['max_id'])) {
                $new_drug_id = $max_id_row['max_id'] + 1;
            }

            $types = implode(',', $type);

            $insert_statement = $this->dbConnection->prepare("INSERT INTO drugstable (id, name, type, image, description) VALUES (?, ?, ?, ?, ?)");
            $insert_statement->execute([$new_drug_id, $name, $types, $image, $description]);

            echo json_encode(["message" => "Drug added successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error adding drug: " . $e->getMessage()]);
        }
    }
    public function deleteDrug($drogName): void {

        try {
            $stmt = $this->dbConnection->prepare("DELETE FROM drugstable WHERE name = ?");
            $stmt->execute([$drogName]);
            echo json_encode(["message" => "Drug deleted successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error deleting drug: " . $e->getMessage()]);
        }
    }
    public function getDrugDetails(int $id): array {
        $sql = "SELECT * FROM drugstable WHERE id = :id";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllDrugs(): array {
        $sql = "SELECT id, name, image FROM drugstable";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getGraphData(string $drugName, string $table): array {
        $graphDataQuery = "SELECT year, $drugName FROM $table ORDER BY year";
        $graphDataStmt = $this->dbConnection->prepare($graphDataQuery);
        $graphDataStmt->execute();
        return $graphDataStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Alte metode pentru interacțiunea cu tabela de droguri
//    public function generateDataInJudete($year, $drug_name): void
//    {
//        // Anul pentru care se generează datele
//        $an = $year;
//
//        // Verificăm dacă numele drogului este valid
//        $sql_check_drug = "SELECT id FROM drugstable WHERE name = ?";
//        $stmt_check_drug = $this->dbConnection->prepare($sql_check_drug);
//        $stmt_check_drug->bindParam(1, $drug_name, PDO::PARAM_STR);
//        $stmt_check_drug->execute();
//        $id_drog_row = $stmt_check_drug->fetch(PDO::FETCH_ASSOC);
//
//        if (!$id_drog_row) {
//            echo json_encode(['error' => 'Numele drogului nu este valid.']);
//            return;
//        }
//
//        $id_drog = $id_drog_row['id'];
//
//        // Lista de județe din România (poți adăuga orice județe lipsă)
//        $judete = [
//            "Alba", "Arad", "Argeș", "Bacău", "Bihor", "Bistrița-Năsăud", "Botoșani", "Brăila", "Brașov", "București",
//            "Buzău", "Călărași", "Caraș-Severin", "Cluj", "Constanța", "Covasna", "Dâmbovița", "Dolj", "Galați", "Giurgiu",
//            "Gorj", "Harghita", "Hunedoara", "Ialomița", "Iași", "Ilfov", "Maramureș", "Mehedinți", "Mureș", "Neamț", "Olt",
//            "Prahova", "Satu Mare", "Sălaj", "Sibiu", "Suceava", "Teleorman", "Timiș", "Tulcea", "Vâlcea", "Vaslui", "Vrancea"
//        ];
//
//        // Prepararea declarației SQL pentru inserare
//        $sql = "INSERT INTO droguri_judete (id_drog, confiscari, total_droguri, judete, an)
//            VALUES (?, ?, ?, ?, ?)";
//        $stmt = $this->dbConnection->prepare($sql);
//        if (!$stmt) {
//            $results[] = "Eroare la pregătirea declarației SQL: " . $this->dbConnection->error;
//            echo json_encode(['error' => $results]);
//            return;
//        }
//
//        // Generarea și inserarea datelor
//        foreach ($judete as $judet) {
//            $confiscari = rand(0, 100); // Număr aleatoriu de confiscări între 0 și 100
//            $total_droguri = rand(0, 500); // Număr aleatoriu de total de droguri între 0 și 500
//
//            // Legăm parametrii și executăm declarația
//            $stmt->bindParam(1, $id_drog, PDO::PARAM_INT);
//            $stmt->bindParam(2, $confiscari, PDO::PARAM_INT);
//            $stmt->bindParam(3, $total_droguri, PDO::PARAM_INT);
//            $stmt->bindParam(4, $judet, PDO::PARAM_STR);
//            $stmt->bindParam(5, $an, PDO::PARAM_INT);
//
//            if ($stmt->execute()) {
//                // Adăugăm mesajul de succes în array-ul de rezultate
//                $results = "Datele au fost inserate cu succes";
//            } else {
//                // Adăugăm mesajul de eroare în array-ul de rezultate
//                $results = "Eroare la inserarea datelor pentru $drug_name în județul $judet: " . $stmt->errorInfo()[2];
//            }
//        }
//
//        // În final, trimitem răspunsul în format JSON
//        echo json_encode(['message' => $results]);
//    }
    public function generateDataInJudete($year, $drug_name): void {
        // Anul pentru care se generează datele
        $an = $year;

        // Verificăm dacă numele drogului este valid
        $sql_check_drug = "SELECT id FROM drugstable WHERE name = ?";
        $stmt_check_drug = $this->dbConnection->prepare($sql_check_drug);
        $stmt_check_drug->bindParam(1, $drug_name, PDO::PARAM_STR);
        $stmt_check_drug->execute();
        $id_drog_row = $stmt_check_drug->fetch(PDO::FETCH_ASSOC);

        if (!$id_drog_row) {
            echo json_encode(['error' => 'Numele drogului nu este valid.']);
            return;
        }

        $id_drog = $id_drog_row['id'];

        // Lista de județe din România (poți adăuga orice județe lipsă)
        $judete = [
            "Alba", "Arad", "Arges", "Bacau", "Bihor", "Bistrita-Nasaud", "Botosani", "Braila", "Brasov", "Bucuresti",
            "Buzau", "Calarasi", "Caras-Severin", "Cluj", "Constanta", "Covasna", "Dambovita", "Dolj", "Galati", "Giurgiu",
            "Gorj", "Harghita", "Hunedoara", "Ialomita", "Iasi", "Ilfov", "Maramures", "Mehedinti", "Mures", "Neamt", "Olt",
            "Prahova", "Satu Mare", "Salaj", "Sibiu", "Suceava", "Teleorman", "Timis", "Tulcea", "Valcea", "Vaslui", "Vrancea"
        ];

        $results = [];

        // Verificăm dacă există deja date pentru același drog și an în baza de date și în fișierul JSON
        foreach ($judete as $judet) {
            // Verificăm în baza de date
            $sql_check_duplicate = "SELECT COUNT(*) AS cnt FROM droguri_judete WHERE id_drog = ? AND judete = ? AND an = ?";
            $stmt_check_duplicate = $this->dbConnection->prepare($sql_check_duplicate);
            $stmt_check_duplicate->bindParam(1, $id_drog, PDO::PARAM_INT);
            $stmt_check_duplicate->bindParam(2, $judet, PDO::PARAM_STR);
            $stmt_check_duplicate->bindParam(3, $an, PDO::PARAM_INT);
            $stmt_check_duplicate->execute();
            $duplicate_row = $stmt_check_duplicate->fetch(PDO::FETCH_ASSOC);

            if ($duplicate_row['cnt'] > 0) {
                $results[0] = "Datele  există deja în baza de date.";
                continue; // Trecem la următorul județ fără să facem inserare
            }

            // Verificăm în fișierul JSON
            $file_path = '../map/drug_data.json';
            $json_data = file_get_contents($file_path);
            $existing_data = json_decode($json_data, true);

            $found = false;
            if (isset($existing_data[$judet])) {
                foreach ($existing_data[$judet]['drugs'] as $drug) {
                    if ($drug['drugname'] == $drug_name) {
                        foreach ($drug['ani'] as $ani) {
                            if ($ani['an'] == $an) {
                                $found = true;
                                break 3; // Ieșim din toate buclele
                            }
                        }
                    }
                }
            }

            if ($found) {
                $results[1] = "Datele există deja în fișierul JSON.";
                continue; // Trecem la următorul județ fără să facem inserare
            }

            // Dacă nu am găsit duplicat, inserăm în baza de date
            $confiscari = rand(0, 100); // Număr aleatoriu de confiscări între 0 și 100
            $total_droguri = rand(0, 500); // Număr aleatoriu de total de droguri între 0 și 500

            $sql_insert = "INSERT INTO droguri_judete (id_drog, confiscari, total_droguri, judete, an) 
                       VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $this->dbConnection->prepare($sql_insert);
            $stmt_insert->bindParam(1, $id_drog, PDO::PARAM_INT);
            $stmt_insert->bindParam(2, $confiscari, PDO::PARAM_INT);
            $stmt_insert->bindParam(3, $total_droguri, PDO::PARAM_INT);
            $stmt_insert->bindParam(4, $judet, PDO::PARAM_STR);
            $stmt_insert->bindParam(5, $an, PDO::PARAM_INT);

            if ($stmt_insert->execute()) {
                $results[3] = "Datele au fost inserate cu succes în baza de date.";
            } else {
                $results[4] = "Eroare la inserarea datelor pentru drogul '$drug_name' și anul '$an' în județul '$judet': " . $stmt_insert->errorInfo()[2];
            }

            // Inserăm în fișierul JSON doar dacă nu am găsit duplicat
            if (!$found) {
                if (!isset($existing_data[$judet])) {
                    $existing_data[$judet] = ['drugs' => []];
                }

                $existing_data[$judet]['drugs'][] = [
                    'drugname' => $drug_name,
                    'ani' => [
                        [
                            'an' => $an,
                            'confiscari' => $confiscari,
                            'total_droguri' => $total_droguri
                        ]
                    ]
                ];

                // Salvăm JSON-ul actualizat înapoi în fișier
                $updated_json_data = json_encode($existing_data, JSON_PRETTY_PRINT);
                if (file_put_contents($file_path, $updated_json_data) === false) {
                    $results[5] = "Eroare la actualizarea fișierului JSON.";
                } else {
                    $results[6] = "Fișierul JSON a fost actualizat cu noile date.";
                }
            }
        }

        // Întoarcem răspunsul în format JSON cu rezultatele operațiunilor
        echo json_encode(['message' => implode(". ", $results) . "."]);
    }



    public function getDataFromJudete($year, $drugName, $judet): bool|string
    {
        try {
            // Interogarea bazei de date pentru a obține datele necesare
            $sql = "SELECT judete, confiscari, total_droguri, an
                FROM droguri_judete
                WHERE an = :year
                AND judete = :judet
                AND id_drog = (SELECT id FROM drugstable WHERE name = :drugName)";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':judet', $judet, PDO::PARAM_STR);
            $stmt->bindParam(':drugName', $drugName, PDO::PARAM_STR);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$data) {
                return json_encode(["error" => "Nu s-au găsit date pentru județul specificat."]);
            }

            // Returnăm un singur obiect, nu un obiect imbricat
            $result = [];
            foreach ($data as $row) {
                $result = [
                    'name' => $drugName,
                    'judete' => $row['judete'],
                    'confiscari' => $row['confiscari'],
                    'total_droguri' => $row['total_droguri'],
                    'an' => $row['an']
                ];
            }

            return json_encode($result);

        } catch (PDOException $e) {
            return json_encode(["error" => "Eroare de conexiune la bază de date: " . $e->getMessage()]);
        }
    }



    public function exportInCsvDataJudete($an,$numeDrog) : void
    {
        $sql = "SELECT judete, confiscari, total_droguri
        FROM droguri_judete
        WHERE an = $an
        AND id_drog = (SELECT id FROM drugstable WHERE name = '$numeDrog')";
        $result = $this->dbConnection->prepare($sql);


// Verificare dacă s-au găsit rezultate
        if ($result->num_rows > 0) {
            // Numele fișierului CSV
            $csv_filename = "date_$numeDrog._$an.csv";

            // Deschiderea unui stream pentru fișierul CSV
            $output = fopen('php://output', 'w');

            // Scrierea capului de tabel (header)
            $header = ['Judet', 'Confiscari', 'Total Droguri'];
            fputcsv($output, $header);

            // Scrierea datelor
            while ($row = $result->fetch_assoc()) {
                $csv_data = [
                    $row['judete'],
                    $row['confiscari'],
                    $row['total_droguri']
                ];
                fputcsv($output, $csv_data);
            }

            // Închiderea stream-ului
            fclose($output);

            // Setarea header-ului pentru descărcare
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $csv_filename . '"');

            // Output-ul fișierului CSV către browser
            readfile($csv_filename);

            // Ștergerea fișierului CSV de pe server (opțional)
            unlink($csv_filename);

            exit;
        } else {
            echo "Nu s-au găsit date pentru $numeDrog în anul $an";
        }
    }

}
?>