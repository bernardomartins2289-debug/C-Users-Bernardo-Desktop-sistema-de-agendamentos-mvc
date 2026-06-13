<?php

class StandardAppointment extends Appointment
{
    public function getType(): string { return 'Standard'; }

    public function validate(): array
    {
        if (empty(trim($this->title))) {
            return ['valid' => false, 'error' => 'O título não pode estar vazio.'];
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date)) {
            return ['valid' => false, 'error' => 'A data está em formato inválido.'];
        }
        if (!preg_match('/^\d{2}:\d{2}$/', $this->time)) {
            return ['valid' => false, 'error' => 'O horário está em formato inválido.'];
        }
        return ['valid' => true];
    }

    public function summary(): string
    {
        return "[Padrão] {$this->title} — {$this->date} às {$this->time}";
    }
}
