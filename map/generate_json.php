<?php
//require 'drug_data.json';
//
//header('Content-Type: application/json');
//$servername = "127.0.0.1:3306";
//$username = "root";
//$password = "";
//$dbname = "projectdb";
//
//// Crearea conexiunii
//$conn = new mysqli($servername, $username, $password, $dbname);
//
//// Verificarea conexiunii
//if ($conn->connect_error) {
//    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
//    exit;
//}
//
//$sql = "SELECT dj.judete, d.name AS drugname, dj.an, dj.confiscari, dj.total_droguri
//        FROM droguri_judete dj
//        JOIN drugstable d ON dj.id_drog = d.id";
//$result = $conn->query($sql);
//
//if (!$result) {
//    echo json_encode(["error" => "Query failed: " . $conn->error]);
//    exit;
//}
//
//$data = [];
//
//if ($result->num_rows > 0) {
//    while($row = $result->fetch_assoc()) {
//        $judet = $row['judete'];
//        $drugname = $row['drugname'];
//        $an = $row['an'];
//        $confiscari = $row['confiscari'];
//        $total_droguri = $row['total_droguri'];
//
//        if (!isset($data[$judet])) {
//            $data[$judet] = ['drugs' => []];
//        }
//
//        $found = false;
//        foreach ($data[$judet]['drugs'] as &$drug) {
//            if ($drug['drugname'] == $drugname) {
//                $drug['ani'][] = [
//                    'an' => $an,
//                    'confiscari' => $confiscari,
//                    'total_droguri' => $total_droguri
//                ];
//                $found = true;
//                break;
//            }
//        }
//
//        if (!$found) {
//            $data[$judet]['drugs'][] = [
//                'drugname' => $drugname,
//                'ani' => [
//                    [
//                        'an' => $an,
//                        'confiscari' => $confiscari,
//                        'total_droguri' => $total_droguri
//                    ]
//                ]
//            ];
//        }
//    }
//} else {
//    echo json_encode(["debug" => "No records found"]);
//    exit;
//}
//
//$conn->close();
//
//// Convertim datele în JSON
//$json_data = json_encode($data, JSON_PRETTY_PRINT);
//
//// Salvăm JSON-ul în fișier
//$file_path = 'drug_data.json';
//if (file_put_contents($file_path, $json_data) === false) {
//    echo json_encode(["error" => "Failed to write JSON file"]);
//} else {
//    echo json_encode(["success" => "JSON file generated successfully"]);
//}
//degeaba
//?>
