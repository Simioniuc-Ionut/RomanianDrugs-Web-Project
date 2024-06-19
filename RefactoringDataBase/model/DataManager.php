<?php
//Clasa DataManager este responsabilă pentru gestionarea datelor și interacțiunea cu baza de date:
require_once(realpath(dirname(__FILE__) . '/../DataBase.php'));

abstract class DataManager {
    protected Database $dbConnection;

    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
        mb_internal_encoding("UTF-8");
    }

    protected function openCSV($filename) {
        if (!file_exists($filename)) {
            die('Fisierul nu exista: ' . $filename);
        }

        $f = fopen($filename, 'r');
        if ($f === false) {
            die('Eroare la deschiderea fisierului ' . $filename);
        }
        return $f;
    }

    protected function convertToUTF8($row): array
    {
        return array_map(function($field) {
            return mb_convert_encoding($field, "UTF-8", "auto");
        }, $row);
    }

    public  abstract function uploadInDataBase($year,$uploadFile) : void;

}

?>
