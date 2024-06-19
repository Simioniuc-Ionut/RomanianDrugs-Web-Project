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

}