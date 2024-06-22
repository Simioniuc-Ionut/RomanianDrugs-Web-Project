<?php
if (isset($_GET['judet'])) {
    $judet = $_GET['judet'];
    $data = file_get_contents('judete.json');
    $judete = json_decode($data, true);

    if (isset($judete[$judet])) {
        header('Content-Type: application/json');
        echo json_encode($judete[$judet]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Judetsul nu a fost gasit."]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Nicio cerere de judet specificata."]);
}
?>
<?php
//require_once '../RefactoringDataBase/DataBase.php'; // Ajustează calea către clasa DataBase
//require_once '../RefactoringDataBase/model/DrugManager.php'; // Ajustează calea către clasa DrugManager
//
//// Verifică dacă au fost trimise parametrii GET
//if (isset($_POST['judet'], $_POST['year'], $_POST['drugName'])) {
//    $judet = $_POST['judet'];
//    $year = $_POST['year'];
//    $drugName = $_POST['drugName']; // Numele drogului
//
//    try {
//        // Conectarea la baza de date și crearea unei instanțe a clasei DrugManager
//        $dbConnection = new DataBase(); // Presupunând că acesta este obiectul pentru conexiunea la baza de date
//        $drugManager = new DrugManager($dbConnection);
//
//        // Apelarea funcției pentru a obține datele pentru județul specificat
//        $data = $drugManager->getDataFromJudete($year, $drugName, $judet);
//
//        // Verificarea dacă s-au obținut date și afișarea rezultatului în format JSON
//        if ($data) {
//            header('Content-Type: application/json');
//            echo $data;
//        } else {
//            header('Content-Type: application/json');
//            echo json_encode(["error" => "Nu s-au găsit date pentru județul specificat."]);
//        }
//
//    } catch (PDOException $e) {
//        header('Content-Type: application/json');
//        echo json_encode(["error" => "Eroare de conexiune la bază de date: " . $e->getMessage()]);
//    }
//
//} else {
//    header('Content-Type: application/json');
//    echo json_encode(["error" => "Parametrii insuficienți."]);
//}
//?>