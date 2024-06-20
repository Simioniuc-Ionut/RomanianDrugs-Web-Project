<?php
if (isset($_GET['regiune'])) {
    $regiune = $_GET['regiune'];
    $data = file_get_contents('data/regiuni.json');
    $regiuni = json_decode($data, true);

    if (isset($regiuni[$regiune])) {
        echo json_encode($regiuni[$regiune]);
    } else {
        echo json_encode(["error" => "Regiunea nu a fost găsită."]);
    }
} else {
    echo json_encode(["error" => "Nicio cerere de regiune specificată."]);
}
?>
