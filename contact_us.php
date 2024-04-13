<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <?php include "NavBar.php"; ?>

</head>
<body>

<div class="container">
    <form action="process.php" method="post" id="contactForm">
        <h1>Contact Us</h1>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <span class="error" id="nameError"></span>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <span class="error" id="emailError"></span>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>
        <span class="error" id="messageError"></span>

        <button type="submit">Submit</button>
    </form>
</div>

<?php include "Footer.php"; ?>
</body>
</html>

