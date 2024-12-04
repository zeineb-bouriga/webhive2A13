<?php

class DeliveryAgent {
    private ?int $agent_id; // Unique Identifier (Primary Key)
    private ?string $full_name; // Full Name of the Delivery Agent
    private ?int $contact_number; // Contact Number of the Agent
    private ?bool $agent_status; // Availability Status

    // Constructor
    public function __construct(
        ?int $agent_id,
        ?string $full_name,
        ?string $contact_number,
        ?bool $agent_status
    ) {
        $this->agent_id = $agent_id;
        $this->full_name = $full_name;
        $this->contact_number = $contact_number;
        $this->agent_status = $agent_status;
    }

    // Getters and Setters

    public function getAgentId(): ?int {
        return $this->agent_id;
    }

    public function setAgentId(?int $agent_id): void {
        $this->id = $agent_id;
    }

    public function getFullName(): ?string {
        return $this->full_name;
    }

    public function setFullName(?string $full_name): void {
        $this->full_name = $full_name;
    }

    public function getContactNumber(): ?int {
        return $this->contact_number;
    }

    public function setContactNumber(?int $contact_number): void {
        $this->contact_number = $contact_number;
    }
    public function getAgentStatus(): ?bool {
        return $this->agent_status;
    }

    public function setAgentStatus(?bool $agent_status): void {
        $this->agent_status = $agent_status;
    }
}

?>
