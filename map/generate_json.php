<?php
header('Content-Type: application/json');
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "projectdb";

// Crearea conexiunii
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT dj.judete, d.name AS drugname, dj.an, dj.confiscari, dj.total_droguri
        FROM droguri_judete dj
        JOIN drugstable d ON dj.id_drog = d.id";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $judet = $row['judete'];
        $drugname = $row['drugname'];
        $an = $row['an'];
        $confiscari = $row['confiscari'];
        $total_droguri = $row['total_droguri'];

        if (!isset($data[$judet])) {
            $data[$judet] = ['drugs' => []];
        }

        $found = false;
        foreach ($data[$judet]['drugs'] as &$drug) {
            if ($drug['drugname'] == $drugname) {
                $drug['ani'][] = [
                    'an' => $an,
                    'confiscari' => $confiscari,
                    'total_droguri' => $total_droguri
                ];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $data[$judet]['drugs'][] = [
                'drugname' => $drugname,
                'ani' => [
                    [
                        'an' => $an,
                        'confiscari' => $confiscari,
                        'total_droguri' => $total_droguri
                    ]
                ]
            ];
        }
    }
}

$conn->close();

// Convertim datele în JSON
$json_data = json_encode($data, JSON_PRETTY_PRINT);

// Salvăm JSON-ul în fișier
$file_path = 'map/drug_data.json';
file_put_contents($file_path, $json_data);

// Returnăm calea fișierulaui
echo json_encode(['file_path' => $file_path]);
?>
