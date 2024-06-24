<?php
require_once(realpath(dirname(__FILE__) . '/../model/DataManager.php'));
// Crearea conexiunii
$conn = new Database();

// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validarea emailului
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Verifică dacă e-mailul există deja în baza de date
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM contacts WHERE email = ?");
        $checkStmt->bindParam(1, $email);
        $checkStmt->execute();
        $emailCount = $checkStmt->fetchColumn();

        if ($emailCount > 0) {
            echo "This email is already subscribed.";
        } else {
            // Pregătirea și executarea interogării SQL pentru inserare
            $stmt = $conn->prepare("INSERT INTO contacts (email) VALUES (?)");
            $stmt->bindParam(1, $email);

            if ($stmt->execute()) {
                echo "You have been subscribed successfully!";
            } else {
                echo "Error: " . $stmt->errorCode();
            }

            $stmt->closeCursor();
        }

        $checkStmt->closeCursor();
    } else {
        echo "Invalid email format";
    }
}
?>
