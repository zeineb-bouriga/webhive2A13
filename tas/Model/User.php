<?php

require_once "../Config/database.php";

class User
{

    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $role;
    private string $phone;
    private bool $isBanned;
    private DateTime $banDate;
    private string $profilePicture;


    public function __construct(int $id, string $name, string $email, string $password, string $role, string $phone, bool $isBanned, DateTime $banDate, string $profilePicture)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->phone = $phone;
        $this->isBanned = $isBanned;
        $this->banDate = $banDate;
        $this->profilePicture = $profilePicture;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getIsBanned(): bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): void
    {
        $this->isBanned = $isBanned;
    }

    
    public function getBanDate(): DateTime
    {
        return $this->banDate;
    }

    public function setBanDate(DateTime $banDate): void
    {
        $this->banDate = $banDate;
    }
    public function setProfilePicture($profilePicture) {
        $this->profilePicture = $profilePicture;
    }
    
    public function getProfilePicture() {
        return $this->profilePicture;
    }

}