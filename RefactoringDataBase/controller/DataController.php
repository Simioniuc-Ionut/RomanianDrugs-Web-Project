<?php

require_once(realpath(dirname(__FILE__) . '/../model/DataManager.php'));
require_once(realpath(dirname(__FILE__) . '/../model/DrugManager.php'));
require_once(realpath(dirname(__FILE__) . '/../model/InfractionalitatiManager.php'));
require_once(realpath(dirname(__FILE__) . '/../model/CampaniiManager.php'));
require_once(realpath(dirname(__FILE__) . '/../model/UrgenteMedicaleManager.php'));

class DataController {
private Database $dbConnection;
private DataManager $dataManager;
    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function processRequest($action): void {
        switch ($action) {
            case 'upload':
                if (isset($_FILES['file'])) {
                    $this->processFileUpload();
                } else {
                    $this->methodNotAllowed();
                }
                break;
            case 'update/description':
                if (isset($_POST['name']) && isset($_POST['description'])) {
                    $this->dataManager = new DrugManager($this->dbConnection);
                    $this->dataManager->updateDrugDescription($_POST['name'], $_POST['description']);
                } else {
                    $this->methodNotAllowed();
                }
                break;
            case 'update/name' :
                if(isset($_POST['current_name']) && isset($_POST['new_name']))
                {
                    $this->dataManager = new DrugManager($this->dbConnection);
                    $this->dataManager->updateDrugName($_POST['current_name'], $_POST['new_name']);
                }
                else
                {
                    $this->methodNotAllowed();
                }
                break;
            case 'update/image':
                if(isset($_POST['name']) && isset($_FILES['image']))
                {
                    $file = $_FILES['image'];
                    $uploadDirectory = '..//';
                    $uploadFile = $uploadDirectory . basename($file['name']);

                    // verificam daca exista deja un fisier cu acelasi nume
                    if ($this->fileExists($uploadFile)) {
                        echo json_encode(["error" => "Un fisier cu acelasi nume exista deja."]);
                        return;
                    }
                    $this->dataManager = new DrugManager($this->dbConnection);
                    $this->dataManager->updateDrugImage($_POST['name'], $_FILES['image']);
                }
                else
                {
                    $this->methodNotAllowed();
                }
                break;
            case 'update/type':
                if(isset($_POST['name']) && isset($_POST['type']))
                {
                    $this->dataManager = new DrugManager($this->dbConnection);
                    $this->dataManager->updateDrugType($_POST['name'], $_POST['type']);
                }
                else
                {
                    $this->methodNotAllowed();
                }
                break;

            // Adăugați aici alte acțiuni...
            default:
                http_response_code(405);
                header("Allow: " . strtoupper($action));
        }
    }

    private function processFileUpload(): void {
        $file = $_FILES['file'];
        $uploadDirectory = '../fisiere_date/';
        $uploadFile = $uploadDirectory . basename($file['name']);

        // verificam daca exista deja un fisier cu acelasi nume
        if ($this->fileExists($uploadFile)) {
            echo json_encode(["error" => "Un fisier cu acelasi nume exista deja."]);
            return;
        }

        // mutam fisierul incarcat in directorul dorit
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            if (preg_match('/(capturi-droguri|infractionalitate|proiecte-si-campanii|urgente-medicale)-(\d{4})\.csv/', $file['name'], $matches)) {
                $fileType = $matches[1];
                $year = $matches[2];

                try {
                    switch ($fileType) {
                        case 'capturi-droguri':
                            $this->dataManager = new DrugManager($this->dbConnection);
                            $this->dataManager->uploadInDataBase($year,$uploadFile);
                            break;
                        case 'infractionalitate':
                            $this->dataManager = new InfractionalitatiManager($this->dbConnection);
                            $this->dataManager->uploadInDataBase($year,$uploadFile);
                            break;
                        case 'proiecte-si-campanii':
                            $this->dataManager = new CampaniiManager($this->dbConnection);
                            $this->dataManager->uploadInDataBase($year,$uploadFile);
                            break;
                        case 'urgente-medicale':
                            $this->dataManager= new UrgenteMedicaleManager($this->dbConnection);
                            $this->dataManager->uploadInDataBase($year,$uploadFile);
                            break;
                        default:
                            throw new Exception('Tip de fișier necunoscut.');
                    }
                    echo json_encode(["message" => "Datele pentru anul $year au fost adaugate cu succes."]);
                } catch (Exception $e) {
                    echo json_encode(["error" => "Eroare la adaugarea în baza de date: " . $e->getMessage()]);
                }
            } else {
                echo json_encode(["error" => "Numele fisierului nu este valid. Trebuie sa fie de forma tip-fisier-YYYY.csv"]);
            }
        } else {
            echo json_encode(["error" => "Eroare la incarcarea fisierului."]);
        }
    }
    private function fileExists($filename): bool {
        return file_exists($filename);
    }
    private function methodNotAllowed() {
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
    }
}

?>
