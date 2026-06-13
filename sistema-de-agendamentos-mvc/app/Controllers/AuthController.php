<?php

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showLogin(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        $error   = Session::flash('error');
        $success = Session::flash('success');
        $this->view('auth/login', compact('error', 'success'));
    }

    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            Session::flash('error', 'E-mail e senha são obrigatórios.');
            $this->redirect('/login');
            return;
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            Session::flash('error', 'Credenciais inválidas.');
            $this->redirect('/login');
            return;
        }

        Session::set('user_id',    $user['id']);
        Session::set('user_name',  $user['name']);
        Session::set('user_email', $user['email']);
        $this->redirect('/dashboard');
    }

    public function showRegister(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        $error = Session::flash('error');
        $this->view('auth/register', compact('error'));
    }

    public function register(): void
    {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($name)) {
            Session::flash('error', 'O nome é obrigatório.');
            $this->redirect('/register');
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'E-mail inválido.');
            $this->redirect('/register');
            return;
        }
        if (strlen($password) < 6) {
            Session::flash('error', 'A senha deve ter pelo menos 6 caracteres.');
            $this->redirect('/register');
            return;
        }
        if ($this->userModel->emailExists($email)) {
            Session::flash('error', 'Este e-mail já está sendo utilizado.');
            $this->redirect('/register');
            return;
        }

        $id = $this->userModel->create($name, $email, $password);
        Session::set('user_id',    $id);
        Session::set('user_name',  $name);
        Session::set('user_email', strtolower($email));
        Session::flash('success', "Bem-vindo, {$name}! Cadastro realizado com sucesso.");
        $this->redirect('/dashboard');
    }

    public function logout(): void
    {
        Session::destroy();
        Session::start();
        Session::flash('success', 'Sessão encerrada com sucesso.');
        $this->redirect('/login');
    }
}
