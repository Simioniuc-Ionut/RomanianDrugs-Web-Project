<?php
if (isset($_GET['judet'])) {
    $judet = $_GET['judet']; // Modificat aici
    $data = file_get_contents('data/judete.json');
    $judete = json_decode($data, true);

    if (isset($judete[$judet])) {
        echo json_encode($judete[$judet]);
    } else {
        echo json_encode(["error" => "Regiunea nu a fost găsită."]);
    }
} else {
    echo json_encode(["error" => "Nicio cerere de regiune specificată."]);
}
?>
