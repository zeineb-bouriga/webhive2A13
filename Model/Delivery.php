<?php

class Delivery {
    private ?int $delivery_id;
    private ?int $order_id; // Foreign Key
    private ?string $delivery_address;
    private ?DateTime $delivery_date;
    private ?string $delivery_status; // Integer status (e.g., 0: Pending, 1: In Transit, 2: Delivered, 3: Canceled)
    private ?int $delivery_agent_id; // Foreign Key

    // Constructor
    public function __construct(
        ?int $delivery_id,
        ?int $order_id,
        ?string $delivery_address,
        ?DateTime $delivery_date,
        ?string $delivery_status,
        ?int $delivery_agent_id
    ) {
        $this->delivery_id = $delivery_id;
        $this->order_id = $order_id;
        $this->delivery_address = $delivery_address;
        $this->delivery_date = $delivery_date;
        $this->delivery_status = $delivery_status;
        $this->delivery_agent_id = $delivery_agent_id;
    }

    // Getters and Setters

    public function getDeliveryId(): ?int {
        return $this->delivery_id;
    }

    public function setDeliveryId(?int $delivery_id): void {
        $this->delivery_id = $delivery_id;
    }

    public function getOrderId(): ?int {
        return $this->order_id;
    }

    public function setOrderId(?int $order_id): void {
        $this->order_id = $order_id;
    }

    public function getDeliveryAddress(): ?string {
        return $this->delivery_address;
    }

    public function setDeliveryAddress(?string $delivery_address): void {
        $this->delivery_address = $delivery_address;
    }

    public function getDeliveryDate(): ?DateTime {
        return $this->delivery_date;
    }

    public function setDeliveryDate(?DateTime $delivery_date): void {
        $this->delivery_date = $delivery_date;
    }

    public function getDeliveryStatus(): ?string {
        return $this->delivery_status;
    }

    public function setDeliveryStatus(?string $delivery_status): void {
        $this->delivery_status = $delivery_status;
    }

    public function getDeliveryAgentId(): ?int {
        return $this->delivery_agent_id;
    }

    public function setDeliveryAgentId(?int $delivery_agent_id): void {
        $this->delivery_agent_id = $delivery_agent_id;
    }
}

?>