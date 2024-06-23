<?php

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

if (empty($name) || empty($email) || empty($message)) {
    echo "Toate câmpurile sunt obligatorii.";
    exit;
}

$to = "owner@mail.com";
$subject = "Mesaj de contact de la $name";
$body = "Ai primit un nou mesaj de la formularul de contact.\n\n" .
    "Nume: $name\n" .
    "Email: $email\n" .
    "Mesaj:\n$message";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Trimite emailul
if (mail($to, $subject, $body, $headers)) {
    echo "Mesajul a fost trimis cu succes.";
} else {
    echo "A apărut o problemă la trimiterea mesajului.";
}

