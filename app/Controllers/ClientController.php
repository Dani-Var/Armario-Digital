<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Core\Database;

class ClientController extends BaseController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $pdo = Database::getConnection();
        $this->userRepository = new UserRepository($pdo);
    }

    public function showRegisterForm(): void
    {
        $this->render("cadastro_cliente.php");
    }

    public function register(): void
    {
        $nome = $_POST['nome'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirmar = $_POST['confirmar_senha'] ?? '';

        if ($senha !== $confirmar) {
            $this->flash('As senhas não coincidem');
            $this->render("cadastro_cliente.php");
            return;
        }

        if ($this->userRepository->existsByCpfOrEmail($cpf, $email)) {
            $this->flash('CPF ou email já cadastrados');
            $this->render("cadastro_cliente.php");
            return;
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $data = [
            'nome' => $nome,
            'cpf' => $cpf,
            'email' => $email,
            'senha' => $hash
        ];

        if ($this->userRepository->create($data)) {
            $this->flash('Cadastro de cliente realizado com sucesso!');
            $this->redirect('/');
        } else {
            $this->flash('Erro ao cadastrar cliente');
            $this->render("cadastro_cliente.php");
        }
    }

    public function dashboard(): void
    {
        $this->requireAuth('cliente');
        
        $cliente = $this->userRepository->findById($this->getUserId());
        $this->render('pagina_cliente.php', ['cliente' => $cliente]);
    }
}

?>