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
