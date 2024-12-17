<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Autoload PHPMailer using Composer

require_once __DIR__ . "/../config/database.php";

class UserController
{
    protected ?PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        try {
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    public function signUp(string $name, string $email, string $password, string $role, string $phone): bool
    {
        $user = $this->findByEmail($email);

        if ($user) {
            header('location: auth-register.php?error=Already Exist');
            return false;
        }

        $sql = "INSERT INTO users (name, email, password, role, phone) VALUES (:name, :email, :password, :role, :phone)";
        $stmt = $this->db->prepare($sql);

        $hashedPassword = md5($password);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':phone', $phone);

        try {
            $stmt->execute();
            $this->sendEmail($email, $name);
            return true;
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    private function sendEmail(string $recipientEmail, string $recipientName)
    {
        $mail = new PHPMailer(true);


        try {
            // SMTP server configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'samoud.tasnim@esprit.tn'; // Your SMTP username
            $mail->Password = '231JFT4454'; // Your SMTP password or app-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email sender and recipient
            $mail->setFrom('sammoud.tasnim@esprit.tn', 'WebHive');
            $mail->addAddress($recipientEmail, $recipientName);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Our Platform!';
            $mail->Body = "<h1>Hello, $recipientName!</h1><p>Thank you for signing up. We're excited to have you with us.</p>";

            // Send the email
            $mail->send();
            echo 'Email has been sent successfully.';
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }



    public function signIn(string $email, string $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':email', $email);

        try {
            $stmt->execute();
            $user = $stmt->fetch();

            if (!$user) {
                return ['success' => false, 'message' => 'User not found.'];
            }

            // Check if the user is banned
            if ($user['isBanned']) {
                $banDate = new DateTime($user['banDate']);
                $currentDate = new DateTime();

                if ($currentDate < $banDate) {
                    $interval = $currentDate->diff($banDate);
                    return [
                        'success' => false,
                        'message' => 'User is banned.',
                        'timeLeft' => $interval->format('%d days, %h hours, %i minutes')
                    ];
                } else {
                    // If the ban period is over, update isBanned to false
                    $updateSql = "UPDATE users SET isBanned = 0 WHERE id = :id";
                    $updateStmt = $this->db->prepare($updateSql);
                    $updateStmt->bindParam(':id', $user['id']);
                    $updateStmt->execute();
                }
            }

            // Verify the password
            $hashedPassword = md5($password);
            if ($user['password'] === $hashedPassword) {
                return ['success' => true, 'message' => 'Login successful.', 'user' => $user];
            } else {
                return ['success' => false, 'message' => 'Invalid password.'];
            }
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }


    public function findAll()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        try {
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    public function update(int $id, string $name, string $email, string $password, string $role, string $phone)
    {
        $sql = "UPDATE users SET name = :name, email = :email, password = :password, role = :role, phone = :phone WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $hashedPassword = md5($password);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    public function updateProfile(int $id, string $name, string $email, string $role, string $phone): void
    {
        $sql = "UPDATE users SET name = :name, email = :email, role = :role, phone = :phone WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    public function updateProfilePicture(int $id, string $profilePicturePath): void
    {
        $sql = "UPDATE users SET profilePicture = :profilePicture WHERE id = :id";
        $stmt = $this->db->prepare($sql);
    
        $stmt->bindParam(':profilePicture', $profilePicturePath);
        $stmt->bindParam(':id', $id);
    
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }
    


    public function updatePassword(int $id, string $password)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $hashedPassword = md5($password);

        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(param: ':id', var: $id);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    public function delete($id): void
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    public function banUser(int $id, string $banDuration): bool
    {
        $banEndDate = new DateTime();
        $banEndDate->modify($banDuration);

        $sql = "UPDATE users SET isBanned = 1, banDate = :banDate WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $formattedBanDate = $banEndDate->format('Y-m-d H:i:s');

        $stmt->bindParam(':banDate', $formattedBanDate);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    public function unbanUser(int $id): bool
    {
        $sql = "UPDATE users SET isBanned = 0, banDate = NULL WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }
}
