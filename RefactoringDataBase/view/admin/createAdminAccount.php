<?php
header('Content-Type: application/json');

// Verificăm dacă sunt primite datele prin POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_username']) && isset($_POST['new_password'])) {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];

    // Conectare la baza de date și efectuarea operațiunilor necesare
    require_once "../../../RefactoringDataBase/DataBase.php";
    $conn = new Database();

    // Verificăm dacă username-ul există deja
    $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
    $stmt->bindParam(1, $new_username, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $response = array('error' => 'Username already exists. Please choose a different username.');
    } else {
        // Dacă username-ul este unic, adăugăm noul cont de admin
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO admins (username, password_hash) VALUES (?, ?)");
        $stmt->bindParam(1, $new_username, PDO::PARAM_STR);
        $stmt->bindParam(2, $hashed_password, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $response = array('message' => 'Admin account created successfully.');
        } else {
            $response = array('error' => 'Error creating admin account.');
        }
    }

    $stmt->closeCursor();
} else {
    $response = array('error' => 'Invalid request.');
}

echo json_encode($response);
?>
