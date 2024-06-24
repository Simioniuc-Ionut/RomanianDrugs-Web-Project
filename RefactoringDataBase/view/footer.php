<?php

?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
<link rel="stylesheet" href="../../style.css" />


<section class="footer">
    <div class="footer-row">
        <div class="footer-col">
            <h4>Info</h4>
            <ul class="links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Compressions</a></li>
                <li><a href="#">Customers</a></li>
                <li><a href="#">Service</a></li>
                <li><a href="#">Collection</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Newsletter</h4>
            <p>
                Subscribe to our newsletter for a weekly dose
                of news, updates, helpful tips, and
                exclusive offers.
            </p>
            <form id="newsletterForm">
                <input type="text" name="email" placeholder="Your email" required>
                <button type="submit">SUBSCRIBE</button>
            </form>
            <div id="message"></div>

            <div class="icons">
                <i class="fa-brands fa-facebook-f"></i>
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-linkedin"></i>
                <i class="fa-brands fa-github"></i>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('newsletterForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'subscribe.php', true);

            xhr.onload = function() {
                var messageDiv = document.getElementById('message');
                if (xhr.status >= 200 && xhr.status < 300) {
                    messageDiv.textContent = xhr.responseText;
                    messageDiv.style.color = 'green';
                } else {
                    messageDiv.textContent = 'An error occurred: ' + xhr.responseText;
                    messageDiv.style.color = 'red';
                }
            };

            xhr.send(formData);
        });
    </script>

</section>

