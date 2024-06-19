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
    public function updateDrugDescription($drogName,$description) : void{
        if(!$this->verifyIfDrogNameExist($drogName)){
            echo json_encode(["error" => "Drug not found."]);
            return;
        }
        try {
            $stmt = $this->dbConnection->prepare("UPDATE drugstable SET description = ? WHERE name = ?");
            $stmt->execute([$description, $drogName]);
            echo json_encode(["message" => "Description updated successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error updating description: " . $e->getMessage()]);
        }

    }
    public function updateDrugName($currentName,$newName) : void{
        if(!$this->verifyIfDrogNameExist($currentName)){
            echo json_encode(["error" => "Drug not found."]);
            return;
        }

        try {
            $stmt = $this->dbConnection->prepare("UPDATE drugstable SET name = ? WHERE name = ?");
            $stmt->execute([$newName, $currentName]);
            echo json_encode(["message" => "Name updated successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error updating name: " . $e->getMessage()]);
        }

    }
    public function updateDrugType($name,$type) : void{
        if(!$this->verifyIfDrogNameExist($name)){
            echo json_encode(["error" => "Drug not found."]);
            return;
        }

        try {
            $stmt = $this->dbConnection->prepare("UPDATE drugstable SET type = ? WHERE name = ?");
            $stmt->execute([$type, $name]);
            echo json_encode(["message" => "Type updated successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error updating type: " . $e->getMessage()]);
        }

    }
    public function updateDrugImage($name,$image) : void{
        if(!$this->verifyIfDrogNameExist($name)){
            echo json_encode(["error" => "Drug not found."]);
            return;
        }

        try {
            $stmt = $this->dbConnection->prepare("UPDATE drugstable SET image = ? WHERE name = ?");
            $stmt->execute([$image, $name]);
            echo json_encode(["message" => "Image updated successfully."]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Error updating image: " . $e->getMessage()]);
        }
    }

    // Alte metode pentru interacțiunea cu tabela de droguri

}