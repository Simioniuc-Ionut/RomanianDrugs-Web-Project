<?php
session_start();
require_once "../../../RefactoringDataBase/DataBase.php"; // Asigură-te că acest fișier există și este corect inclus

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Conectare la baza de date și verificare credențiale
        $conn = new Database(); // Aici presupunem că Database este o clasă care gestionează conexiunea la baza de date

        // Selectăm parola hashed pentru username-ul introdus
        $stmt = $conn->prepare("SELECT password_hash FROM admins WHERE username = ?");
        $stmt->execute([$username]); // Executăm interogarea, pasând username-ul ca parametru

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && password_verify($password, $result['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin.php');
            exit;
        } else {
            $error = 'Nume de utilizator sau parolă incorectă.';
        }

        $stmt->closeCursor();
    } catch (PDOException $e) {
        // Gestionează erorile de conectare la baza de date sau de execuție a interogării
        $error = 'Eroare la conectarea la baza de date: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../../../style_login.scss">
</head>
<body>
<div class="login-container">
    <h1>Admin Login</h1>
    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" action="adminLogin.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="loginButton">Login</button>
    </form>
</div>

</body>
<div>
    <form action="../../view/homePage.php" method="get" id="backForm">
        <button type="submit" class="fixed-back-button">Back</button>
    </form>
</div>
</html>
