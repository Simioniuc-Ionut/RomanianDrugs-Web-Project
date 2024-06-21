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

<div class="container-form-contact">
    <form action="sendContactEmail.php" method="post" id="contactForm">
        <h1 class="form-title-contact">Contact Us</h1>

        <div class="form-group-contact">
            <label for="name" class="form-label-contact">Name:</label>
            <input type="text" id="name" name="name" class="form-input-contact" required>
            <span class="error-contact" id="nameError"></span>
        </div>

        <div class="form-group-contact">
            <label for="email" class="form-label-contact">Email:</label>
            <input type="email" id="email" name="email" class="form-input-contact" required>
            <span class="error-contact" id="emailError"></span>
        </div>

        <div class="form-group-contact">
            <label for="message" class="form-label-contact">Message:</label>
            <textarea id="message" name="message" class="form-textarea-contact" required></textarea>
            <span class="error-contact" id="messageError"></span>
        </div>

        <button type="submit" class="form-button-contact">Submit</button>
    </form>
</div>


<?php include "Footer.php"; ?>
</body>
</html>


