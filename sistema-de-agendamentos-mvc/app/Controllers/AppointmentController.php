<?php

class AppointmentController extends Controller
{
    private AppointmentRepository $repo;

    public function __construct()
    {
        $this->repo = new AppointmentRepository();
    }

    public function index(): void
    {
        $this->requireAuth();
        $userId       = (int) Session::get('user_id');
        $appointments = $this->repo->findAllByUserId($userId);
        $success      = Session::flash('success');
        $error        = Session::flash('error');
        $this->view('appointments/index', compact('appointments', 'success', 'error'));
    }

    public function create(): void
    {
        $this->requireAuth();
        $error = Session::flash('error');
        $this->view('appointments/create', compact('error'));
    }

    public function store(): void
    {
        $this->requireAuth();
        $userId = (int) Session::get('user_id');

        $data = [
            'user_id'        => $userId,
            'title'          => trim($_POST['title'] ?? ''),
            'description'    => trim($_POST['description'] ?? ''),
            'date'           => $_POST['date'] ?? '',
            'time'           => $_POST['time'] ?? '',
            'priority_level' => $_POST['priority_level'] ?? null,
            'client_name'    => trim($_POST['client_name'] ?? '') ?: null,
        ];

        $type        = $_POST['type'] ?? 'Standard';
        $appointment = AppointmentFactory::create($type, $data);
        $validation  = $appointment->validate();

        if (!$validation['valid']) {
            Session::flash('error', $validation['error']);
            $this->redirect('/appointments/create');
            return;
        }

        $this->repo->insert($appointment);
        Session::flash('success', 'Agendamento cadastrado com sucesso!');
        $this->redirect('/dashboard');
    }

    public function edit(string $id): void
    {
        $this->requireAuth();
        $userId = (int) Session::get('user_id');
        $record = $this->repo->findById((int) $id);

        if (!$record || (int) $record['user_id'] !== $userId) {
            Session::flash('error', 'Agendamento não encontrado.');
            $this->redirect('/dashboard');
            return;
        }

        $error = Session::flash('error');
        $this->view('appointments/edit', compact('record', 'error'));
    }

    public function update(string $id): void
    {
        $this->requireAuth();
        $userId = (int) Session::get('user_id');
        $record = $this->repo->findById((int) $id);

        if (!$record || (int) $record['user_id'] !== $userId) {
            Session::flash('error', 'Agendamento não encontrado.');
            $this->redirect('/dashboard');
            return;
        }

        $data = [
            'user_id'        => $userId,
            'title'          => trim($_POST['title'] ?? $record['title']),
            'description'    => trim($_POST['description'] ?? $record['description']),
            'date'           => $_POST['date'] ?? $record['date'],
            'time'           => $_POST['time'] ?? $record['time'],
            'priority_level' => $_POST['priority_level'] ?? $record['priority_level'],
            'client_name'    => trim($_POST['client_name'] ?? '') ?: $record['client_name'],
        ];

        $type        = $_POST['type'] ?? $record['type'];
        $appointment = AppointmentFactory::create($type, $data);
        $validation  = $appointment->validate();

        if (!$validation['valid']) {
            Session::flash('error', $validation['error']);
            $this->redirect("/appointments/{$id}/edit");
            return;
        }

        $this->repo->update((int) $id, $appointment);
        Session::flash('success', 'Agendamento atualizado com sucesso!');
        $this->redirect('/dashboard');
    }

    public function destroy(string $id): void
    {
        $this->requireAuth();
        $userId = (int) Session::get('user_id');
        $record = $this->repo->findById((int) $id);

        if (!$record || (int) $record['user_id'] !== $userId) {
            Session::flash('error', 'Agendamento não encontrado.');
            $this->redirect('/dashboard');
            return;
        }

        $this->repo->delete((int) $id);
        Session::flash('success', 'Agendamento removido com sucesso!');
        $this->redirect('/dashboard');
    }
}
