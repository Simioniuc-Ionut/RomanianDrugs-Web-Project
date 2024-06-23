<?php
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//
//require '../../vendor/autoload.php';

class ContactManager
{
    private $dbConnection;

    public function __construct($db)
    {
        $this->dbConnection = $db;
    }

    public function sendContactEmail($name, $email, $message): bool
    {

        // Debugging - Verifică dacă datele sunt primite corect
        error_log("Name: $name, Email: $email, Message: $message");
        if (!$this->validateEmail($email)) {
            error_log("Invalid email format");
            echo json_encode(['error' => 'Invalid email format']);
            return false;
        }

        if ($this->insertContactData($name, $email, $message)) {
            return $this->sendConfirmationEmail($name, $email);
        }

        return false;

    }

    private function validateEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function insertContactData($name, $email, $message): bool
    {
        if ($this->emailExists($email)) {
            $existingName = $this->getNameByEmail($email);
            if ($existingName !== $name) {
                return $this->updateNameByEmail($name, $email);
            }
            return true;
        }

        $sql = "INSERT INTO contacts (name, email, message, reg_date) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt) {
            $createdAt = date('Y-m-d H:i:s');
            $stmt->bindParam(1, $name, PDO::PARAM_STR);
            $stmt->bindParam(2, $email, PDO::PARAM_STR);
            $stmt->bindParam(3, $message, PDO::PARAM_STR);
            $stmt->bindParam(4, $createdAt, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true;
            } else {
                header('Content-Type: application/json');
               error_log("Database insert error: " . $stmt->errorInfo()[2]);
                echo json_encode(['error' =>'error inserting data']);
            }
            $stmt->closeCursor();
        } else {
            header('Content-Type: application/json');
           error_log("Database prepare error: " . $this->dbConnection->error);
            echo json_encode(['error' => 'error preparing statement']);
        }
        return false;
    }

    private function emailExists($email): bool
    {
        $sql = "SELECT COUNT(*) FROM contacts WHERE email = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $count > 0;
    }

    private function getNameByEmail($email): ?string
    {
        $sql = "SELECT name FROM contacts WHERE email = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        $name = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $name ?: null;
    }

    private function updateNameByEmail($name, $email): bool
    {
        $sql = "UPDATE contacts SET name = ? WHERE email = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $stmt->closeCursor();
            return true;
        } else {
            header('Content-Type: application/json');
           error_log("Database update error: " . $stmt->error);
            echo json_encode(['error' => 'error updating name']);
        }
        $stmt->closeCursor();
        return false;
    }

    public function sendConfirmationEmail($name, $email): bool {
//        $mail = new PHPMailer(true);
//        try {
//            //Server settings
//            $mail->isSMTP();
//            $mail->Host       = 'smtp.gmail.com';
//            $mail->SMTPAuth   = true;
//            $mail->Username   = 'simioniucionut1@gmail.com';
//            $mail->Password   = 'yamjnvwrmtiiuvt';
//            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//            $mail->Port       = 587;
//
//            //Recipients
//            $mail->setFrom('simioniucionut1@gmail.com', 'Mailer');
//            $mail->addAddress($email, $name);
//
//            //Content
//            $mail->isHTML(true);
//            $mail->Subject = 'Thank you for your feedback';
//            $mail->Body    = "Dear $name,<br><br>Thank you for your feedback. We will get back to you with more information soon.<br><br>Best regards,<br>Romanian Drugs";
//
//            $mail->send();
//            echo json_encode(['message' => 'Email sent successfully']);
//            error_log("Email sent successfully");
//            return true;
//        } catch (Exception $e) {
//            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
//            return false;
//        }
        $to = $email;
        $subject = "Thank you for your feedback";
        $body = "Dear $name,\n\nThank you for your feedback. We will get back to you with more information soon.\n\nBest regards,\nRomanian Drugs";
        $headers = 'From: simioniucionut1@gmail.com' . "\r\n" .
            'Reply-To: simioniucionut1@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if (!mail($to, $subject, $body, $headers)) {
            error_log("Email failed to send");
            return false;
        } else {
            error_log("Email sent successfully");
            return true;
        }
    }
}
?>
