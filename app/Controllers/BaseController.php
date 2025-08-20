<?php

namespace App\Controllers;

use App\Views\ViewRenderer;
use App\Core\Session;

abstract class BaseController
{
    protected ViewRenderer $viewRenderer;

    public function __construct()
    {
        $this->viewRenderer = new ViewRenderer();
        Session::start();
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }

    protected function flash(string $message): void
    {
        Session::flash($message);
    }

    protected function getFlash(): ?string
    {
        return Session::getFlash();
    }

    protected function isLoggedIn(): bool
    {
        return Session::isLoggedIn();
    }

    protected function getUserId(): ?int
    {
        return Session::getUserId();
    }

    protected function getUserType(): ?string
    {
        return Session::getUserType();
    }

    protected function requireAuth(string $userType = null): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/');
        }

        if ($userType && $this->getUserType() !== $userType) {
            $this->redirect('/');
        }
    }

    protected function render(string $view, array $data = []): void
    {
        $data['flash_message'] = $this->getFlash();
        $this->viewRenderer->render($view, $data);
    }
}
?>