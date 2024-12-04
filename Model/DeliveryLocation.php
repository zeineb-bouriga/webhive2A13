<?php

class DeliveryLocation {
    private ?int $location_id; // Primary Key
    private ?string $address;
    private ?float $latitude;
    private ?float $longitude;
    private ?DateTime $timestamp; // Timestamp of the location update

    // Constructor
    public function __construct(
        ?int $location_id,
        ?string $address,
        ?float $latitude,
        ?float $longitude,
        ?DateTime $timestamp = null
    ) {
        $this->location_id = $location_id;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timestamp = $timestamp;
    }

    // Getters and Setters
    public function getLocationId(): ?int {
        return $this->location_id;
    }

    public function setLocationId(?int $location_id): void {
        $this->location_id = $location_id;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(?string $address): void {
        $this->address = $address;
    }

    public function getLatitude(): ?float {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): void {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): void {
        $this->longitude = $longitude;
    }

    public function getTimestamp(): ?DateTime {
        return $this->timestamp;
    }

    public function setTimestamp(?DateTime $timestamp): void {
        $this->timestamp = $timestamp;
    }
}

?>
