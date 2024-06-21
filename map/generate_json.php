<?php
require './RefactoringDataBase/DataBase.php';
function generateJsonFile($year, $drugName): void
{
    try {
        $dbConnection = new DataBase();

        $sql = "SELECT judete, confiscari, total_droguri, an
                FROM droguri_judete
                JOIN drugstable ON droguri_judete.id_drog = drugstable.id
                WHERE an = :year AND drugstable.name = :drugName";

        $stmt = $dbConnection->prepare($sql);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':drugName', $drugName, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$data) {
            echo json_encode(["error" => "Nu s-au găsit date în baza de date."]);
            exit;
        }

        $jsonData = [];
        foreach ($data as $row) {
            $judet = $row['judete'];
            $jsonData[$judet] = [
                'name' => $drugName,
                'confiscari' => $row['confiscari'],
                'total_droguri' => $row['total_droguri'],
                'an' => $row['an']
            ];
        }
        $jsonFilePath = 'map/judete_data.json';
        file_put_contents($jsonFilePath, json_encode($jsonData, JSON_PRETTY_PRINT));
        echo json_encode(["success" => "Fișierul JSON a fost generat cu succes."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Eroare de conexiune la baza de date: " . $e->getMessage()]);
    }
}

// Asumăm că aceste date sunt trimise prin POST
//$year = $_POST['year'];
//$drugName = $_POST['drugName'];
//
//generateJsonFile($year, $drugName);
?>
