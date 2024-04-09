<?php

require_once 'db_connect.php';
global $dbConnection;

$max_id_query = $dbConnection->query("SELECT MAX(id) AS max_id FROM drugstable");
$max_id_row = $max_id_query->fetch(PDO::FETCH_ASSOC);
$new_drug_id = $max_id_row['max_id'] + 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['type']) && !empty($_POST['image']) && !empty($_POST['description'])) {
        $types = implode(',', $_POST['type']);

        $insert_statement = $dbConnection->prepare("INSERT INTO drugstable (id, name, type, image, description) VALUES (?, ?, ?, ?, ?)");
        $insert_statement->execute(array($new_drug_id, $_POST['name'], $types, $_POST['image'], $_POST['description']));

        echo "<p>Medicamentul a fost adăugat cu succes!</p>";

        header("refresh:3;url=add_drugs.php");
        exit();
    } else {
        echo "Toate câmpurile sunt obligatorii.";
    }
}
?>