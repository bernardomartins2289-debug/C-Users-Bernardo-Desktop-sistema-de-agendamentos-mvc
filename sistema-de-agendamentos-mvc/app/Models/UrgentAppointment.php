<?php

class UrgentAppointment extends Appointment
{
    public function getType(): string { return 'Urgent'; }

    public function validate(): array
    {
        if (empty(trim($this->title))) {
            return ['valid' => false, 'error' => 'O título do agendamento urgente não pode estar vazio.'];
        }
        if (empty($this->date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date)) {
            return ['valid' => false, 'error' => 'Defina a data do agendamento urgente.'];
        }
        if (!in_array($this->priorityLevel, ['Alta', 'Altíssima'], true)) {
            return ['valid' => false, 'error' => "O nível de prioridade deve ser 'Alta' ou 'Altíssima'."];
        }
        return ['valid' => true];
    }

    public function summary(): string
    {
        return "[URGENTE – {$this->priorityLevel}] {$this->title}";
    }
}
