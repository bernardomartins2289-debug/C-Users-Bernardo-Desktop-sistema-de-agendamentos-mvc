<?php

abstract class Appointment
{
    protected ?int    $id;
    protected int     $userId;
    protected string  $title;
    protected string  $description;
    protected string  $date;
    protected string  $time;
    protected ?string $priorityLevel;
    protected ?string $clientName;
    protected ?string $createdAt;
    protected ?string $updatedAt;

    public function __construct(array $data)
    {
        $this->id            = isset($data['id']) ? (int) $data['id'] : null;
        $this->userId        = (int) $data['user_id'];
        $this->title         = $data['title'] ?? '';
        $this->description   = $data['description'] ?? '';
        $this->date          = $data['date'] ?? '';
        $this->time          = $data['time'] ?? '';
        $this->priorityLevel = $data['priority_level'] ?? null;
        $this->clientName    = $data['client_name'] ?? null;
        $this->createdAt     = $data['created_at'] ?? null;
        $this->updatedAt     = $data['updated_at'] ?? null;
    }

    abstract public function getType(): string;

    abstract public function validate(): array;

    abstract public function summary(): string;

    public function toArray(): array
    {
        return [
            'id'             => $this->id,
            'user_id'        => $this->userId,
            'title'          => $this->title,
            'description'    => $this->description,
            'date'           => $this->date,
            'time'           => $this->time,
            'type'           => $this->getType(),
            'priority_level' => $this->priorityLevel,
            'client_name'    => $this->clientName,
            'created_at'     => $this->createdAt,
            'updated_at'     => $this->updatedAt,
        ];
    }

    public function getId(): ?int        { return $this->id; }
    public function getTitle(): string   { return $this->title; }
    public function getDate(): string    { return $this->date; }
    public function getTime(): string    { return $this->time; }
    public function getPriorityLevel(): ?string { return $this->priorityLevel; }
    public function getClientName(): ?string    { return $this->clientName; }
}
