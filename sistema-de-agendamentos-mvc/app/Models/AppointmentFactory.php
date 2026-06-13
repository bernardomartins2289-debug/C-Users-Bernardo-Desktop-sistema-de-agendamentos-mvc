<?php

class AppointmentFactory
{
    public static function create(string $type, array $data): Appointment
    {
        return match ($type) {
            'Urgent'       => new UrgentAppointment($data),
            'Professional' => new ProfessionalAppointment($data),
            default        => new StandardAppointment($data),
        };
    }
}
