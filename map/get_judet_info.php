<?php
if (isset($_GET['judet']) && isset($_GET['dataFile'])) {
    $judet = $_GET['judet'];
    $dataFile = $_GET['dataFile'];

    // Verificăm dacă fișierul există pentru a preveni erori
    if (file_exists($dataFile)) {
        $data = file_get_contents($dataFile);
        $judete = json_decode($data, true);

        if (isset($judete[$judet])) {
            header('Content-Type: application/json');
            echo json_encode($judete[$judet]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(["error" => "Judetul nu a fost gasit."]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Fișierul de date specificat nu există."]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Parametri insuficienți."]);
}
?>
