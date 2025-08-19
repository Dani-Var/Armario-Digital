<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\CompanyRepository;
use App\Core\Database;
use App\Core\Session;
use App\Core\EmailService;

class AuthController extends BaseController
{
    private UserRepository $userRepository;
    private CompanyRepository $companyRepository;

    public function __construct()
    {
        parent::__construct();
        $pdo = Database::getConnection();
        $this->userRepository = new UserRepository($pdo);
        $this->companyRepository = new CompanyRepository($pdo);
    }

    public function showLogin(): void
    {
        $this->render('index.php');
    }

    public function login(): void
    {
        $tipoUsuario = $_POST["tipo_usuario"] ?? "";
        $documento = $_POST["documento"] ?? "";
        $senha = $_POST["senha"] ?? "";

        if ($tipoUsuario === "cliente") {
            $cliente = $this->userRepository->findByCpf($documento);

            if ($cliente && password_verify($senha, $cliente["senha"])) {
                Session::login($cliente["id"], "cliente");
                $this->redirect("/pagina_cliente");
            } else {
                $this->flash("CPF ou senha incorretos");
                $this->redirect("/");
            }

        } elseif ($tipoUsuario === "empresa") {
            $empresa = $this->companyRepository->findByCnpj($documento);

            if ($empresa && password_verify($senha, $empresa["senha"])) {
                Session::login($empresa["id"], "empresa");
                $this->redirect("/pagina_empresa");
            } else {
                $this->flash("CNPJ ou senha incorretos");
                $this->redirect("/");
            }

        } else {
            $this->flash("Tipo de usuário inválido");
            $this->redirect("/");
        }
    }

    public function logout(): void
    {
        Session::logout();
        $this->redirect("/");
    }

    public function showForgotPasswordForm(): void
    {
        $this->render("esqueceu_senha.php");
    }

    public function sendPasswordResetEmail(): void
    {
        $email = $_POST["email"] ?? "";
        $tipoUsuario = $_POST["tipo_usuario"] ?? "";

        $user = null;
        if ($tipoUsuario === "cliente") {
            $user = $this->userRepository->findByEmail($email);
        } elseif ($tipoUsuario === "empresa") {
            $user = $this->companyRepository->findByEmail($email);
        }

        if ($user) {
            $token = bin2hex(random_bytes(50));
            $expires = new \DateTime("now +1 hour");

            if ($tipoUsuario === "cliente") {
                $this->userRepository->updateResetToken($user["id"], $token, $expires->format("Y-m-d H:i:s"));
            } else {
                $this->companyRepository->updateResetToken($user["id"], $token, $expires->format("Y-m-d H:i:s"));
            }

            $resetLink = "http://" . $_SERVER["HTTP_HOST"] . "/reset-password?token=" . $token;
            $emailBody = "Para redefinir sua senha, clique no link a seguir: <a href=\"$resetLink\">$resetLink</a>";

            $emailService = new EmailService();
            if ($emailService->sendEmail($email, "Redefinição de Senha - Closet Fashion", $emailBody)) {
                $this->flash("Um e-mail com instruções para redefinição de senha foi enviado.");
            } else {
                $this->flash("Não foi possível enviar o e-mail de redefinição de senha.");
            }
        } else {
            $this->flash("E-mail não encontrado.");
        }

        $this->redirect("/forgot-password");
    }

    public function showResetPasswordForm(): void
    {
        $token = $_GET["token"] ?? "";
        $this->render("alterar_senha.html", ["token" => $token]);
    }

    public function resetPassword(): void
    {
        $token = $_POST["token"] ?? "";
        $password = $_POST["senha"] ?? "";
        $confirmPassword = $_POST["confirmar_senha"] ?? "";

        if ($password !== $confirmPassword) {
            $this->flash("As senhas não coincidem.");
            $this->redirect("/reset-password?token=" . $token);
            return;
        }

        $user = $this->userRepository->findByResetToken($token) ?? $this->companyRepository->findByResetToken($token);

        if ($user && new \DateTime() < new \DateTime($user["reset_token_expires_at"])) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if (isset($user["cpf"])) { // É cliente
                $this->userRepository->updatePassword($user["id"], $hashedPassword);
            } else {
                $this->companyRepository->updatePassword($user["id"], $hashedPassword);
            }
            $this->flash("Sua senha foi redefinida com sucesso!");
            $this->redirect("/");
        } else {
            $this->flash("Token inválido ou expirado.");
            $this->redirect("/reset-password?token=" . $token);
        }
    }
}


