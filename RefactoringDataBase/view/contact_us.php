<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../../style.css">
    <?php include "navBar.php"; ?>
<!--    <script>-->
<!---->
<!--        //afisarea mesajului din dreapta jos-->
<!--        document.addEventListener("DOMContentLoaded", function() {-->
<!--            const form = document.getElementById('contactForm');-->
<!--            form.addEventListener('submit', function(event) {-->
<!--                event.preventDefault();-->
<!--                console.log('Form submitted');-->
<!--                const formData = new FormData(this);-->
<!--                console.log('Form data:', formData);-->
<!---->
<!--                fetch('../index.php/contact', {-->
<!--                    method: 'POST',-->
<!--                    body: formData-->
<!--                })-->
<!---->
<!--                    .then(response => {-->
<!---->
<!--                        console.log('Response status:', response.status);-->
<!--                        return response.json();-->
<!--                    })-->
<!--                    .then(data => {-->
<!--                        console.log('Success:', data);-->
<!--                        const messageDiv = document.getElementById('messages');-->
<!--                        if (data.message) {-->
<!--                            messageDiv.textContent = data.message;-->
<!--                            messageDiv.style.backgroundColor = '#d4edda';-->
<!--                            messageDiv.style.borderColor = '#c3e6cb';-->
<!--                        } else if (data.error) {-->
<!--                            messageDiv.textContent = data.error;-->
<!--                            messageDiv.style.backgroundColor = '#f8d7da';-->
<!--                            messageDiv.style.borderColor = '#f5c6cb';-->
<!--                        }-->
<!--                        messageDiv.style.display = 'block';-->
<!--                        setTimeout(() => {-->
<!--                            messageDiv.style.display = 'none';-->
<!--                        }, 5000);-->
<!--                    })-->
<!--                    .catch(error => {-->
<!---->
<!--                        console.error('Error:', error);-->
<!--                    });-->
<!--            });-->
<!--        });-->
<!--    </script>-->
    <style>
        #message {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background-color: #f0f0f0;
            padding: 10px;
            border: 1px solid #ccc;
            display: none;
        }
        #message.success {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        #message.error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

    </style>
</head>

<body>


<div class="container-form-contact">
    <div id="message"></div>
    <form action="../index.php/contact" method="post" id="contactForm">
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
            <textarea id= "messages" name="message" placeholder="Message" class="form-textarea-contact" required></textarea>
            <span class="error-contact" id="messageError"></span>
        </div>
        <button type="submit" class="form-button-contact">Submit</button>
    </form>

    <a href="admin/adminLogin.php" class="admin-login-button">Admin Login</a>
</div>


<?php include "footer.php"; ?>

</body>
</html>


