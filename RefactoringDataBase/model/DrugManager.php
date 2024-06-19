<?php
require_once(realpath(dirname(__FILE__) . '/../DataBase.php'));

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
    public function getDrugs(): void {
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

    // Alte metode pentru interacțiunea cu tabela de droguri

}