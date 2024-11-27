<?php

class Reclamation {
    private ?int $idreclamation; // Primary key
    private ?string $nom; // First name
    private ?string $prenom; // Last name
    private ?string $email; // Email address

    // Constructor
    public function __construct(?int $idreclamation, ?string $nom, ?string $prenom, ?string $email) {
        $this->idreclamation = $idreclamation;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
    }

    // Getters and Setters

    public function getIdReclamation(): ?int {
        return $this->idreclamation;
    }

    public function setIdReclamation(?int $idreclamation): void {
        $this->idreclamation = $idreclamation;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(?string $nom): void {
        $this->nom = $nom;
    }

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): void {
        $this->prenom = $prenom;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }
}

