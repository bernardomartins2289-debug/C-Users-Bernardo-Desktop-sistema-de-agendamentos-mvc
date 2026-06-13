<?php

class ProfessionalAppointment extends Appointment
{
    public function getType(): string { return 'Professional'; }

    public function validate(): array
    {
        if (empty(trim($this->title))) {
            return ['valid' => false, 'error' => 'O título do agendamento comercial não pode estar vazio.'];
        }
        if (empty(trim($this->clientName ?? ''))) {
            return ['valid' => false, 'error' => 'O nome do cliente/paciente é obrigatório para agendamentos comerciais.'];
        }
        if (empty($this->date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date)) {
            return ['valid' => false, 'error' => 'A data está em formato inválido.'];
        }
        return ['valid' => true];
    }

    public function summary(): string
    {
        return "[Profissional] {$this->title} — Cliente: {$this->clientName}";
    }
}
