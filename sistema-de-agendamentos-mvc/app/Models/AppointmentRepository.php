<?php

class AppointmentRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAllByUserId(int $userId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM appointments WHERE user_id = ? ORDER BY date ASC, time ASC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM appointments WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function insert(Appointment $appointment): int
    {
        $d = $appointment->toArray();
        $stmt = $this->db->prepare('
            INSERT INTO appointments
                (user_id, title, description, date, time, type, priority_level, client_name)
            VALUES
                (:user_id, :title, :description, :date, :time, :type, :priority_level, :client_name)
        ');
        $stmt->execute([
            ':user_id'        => $d['user_id'],
            ':title'          => $d['title'],
            ':description'    => $d['description'],
            ':date'           => $d['date'],
            ':time'           => $d['time'],
            ':type'           => $d['type'],
            ':priority_level' => $d['priority_level'],
            ':client_name'    => $d['client_name'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, Appointment $appointment): bool
    {
        $d = $appointment->toArray();
        $stmt = $this->db->prepare('
            UPDATE appointments
            SET title          = :title,
                description    = :description,
                date           = :date,
                time           = :time,
                type           = :type,
                priority_level = :priority_level,
                client_name    = :client_name,
                updated_at     = NOW()
            WHERE id = :id
        ');
        return $stmt->execute([
            ':title'          => $d['title'],
            ':description'    => $d['description'],
            ':date'           => $d['date'],
            ':time'           => $d['time'],
            ':type'           => $d['type'],
            ':priority_level' => $d['priority_level'],
            ':client_name'    => $d['client_name'],
            ':id'             => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM appointments WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
