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

}