<?php

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        require ROOT . '/app/Views/' . $view . '.php';
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit();
    }

    protected function isAuthenticated(): bool
    {
        return Session::has('user_id');
    }

    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }
}
