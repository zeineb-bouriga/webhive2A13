<?php

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
            return false ;
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
            return true;
        } catch (Exception $e) {
            die("Exception: " . $e->getMessage());
        }
    }

    public function signIn(string $email, string $password)
    {

        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
        $stmt = $this->db->prepare($sql);

        $hashedPassword = md5($password);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        try {
            $stmt->execute();
            return $stmt->fetch();
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

    public function update(int $id, string $name, string $email, string $password, string $role, string $phone): void
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
}
