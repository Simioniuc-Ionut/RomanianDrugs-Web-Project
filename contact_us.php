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

<div class="container-form">
    <form action="process.php" method="post" id="contactForm">
        <h1 class="form-title">Contact Us</h1>

        <div class="form-group">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name" class="form-input" required>
            <span class="error" id="nameError"></span>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-input" required>
            <span class="error" id="emailError"></span>
        </div>

        <div class="form-group">
            <label for="message" class="form-label">Message:</label>
            <textarea id="message" name="message" class="form-textarea" required></textarea>
            <span class="error" id="messageError"></span>
        </div>

        <button type="submit" class="form-button">Submit</button>
    </form>
</div>


<?php include "Footer.php"; ?>
</body>
</html>

