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
}