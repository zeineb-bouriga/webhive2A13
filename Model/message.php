<?php

class Message {
    private ?int $idmessage; // Primary key
    private ?int $idreclamation; // Foreign key to reclamation
    private ?string $contenu_message; // Content of the message
    private ?string $auteur; // Author of the message

    // Constructor
    public function __construct(?int $idmessage, ?int $idreclamation, ?string $contenu_message, ?string $auteur) {
        $this->idmessage = $idmessage;
        $this->idreclamation = $idreclamation;
        $this->contenu_message = $contenu_message;
        $this->auteur = $auteur;
    }

    // Getters and Setters

    public function getIdMessage(): ?int {
        return $this->idmessage;
    }

    public function setIdMessage(?int $idmessage): void {
        $this->idmessage = $idmessage;
    }

    public function getIdReclamation(): ?int {
        return $this->idreclamation;
    }

    public function setIdReclamation(?int $idreclamation): void {
        $this->idreclamation = $idreclamation;
    }

    public function getContenuMessage(): ?string {
        return $this->contenu_message;
    }

    public function setContenuMessage(?string $contenu_message): void {
        $this->contenu_message = $contenu_message;
    }

    public function getAuteur(): ?string {
        return $this->auteur;
    }

    public function setAuteur(?string $auteur): void {
        $this->auteur = $auteur;
    }
}

?>