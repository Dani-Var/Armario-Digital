<?php

namespace App\Controllers;

use App\Repositories\CompanyRepository;
use App\Core\Database;

class CompanyController extends BaseController
{
    private CompanyRepository $companyRepository;

    public function __construct()
    {
        parent::__construct();
        $pdo = Database::getConnection();
        $this->companyRepository = new CompanyRepository($pdo);
    }

    public function showRegisterForm(): void
    {
        $this->render('cadastro_empresa.php');
    }

    public function register(): void
    {
        $nomeLoja = $_POST['nome_loja'] ?? '';
        $cnpj = $_POST['cnpj'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirmar = $_POST['confirmar_senha'] ?? '';

        if ($senha !== $confirmar) {
            $this->flash('As senhas não coincidem');
            $this->render('cadastro_empresa.php');
            return;
        }

        if ($this->companyRepository->existsByCnpjOrEmail($cnpj, $email)) {
            $this->flash('CNPJ ou email já cadastrados');
            $this->render('cadastro_empresa.php');
            return;
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $data = [
            'nome_loja' => $nomeLoja,
            'cnpj' => $cnpj,
            'email' => $email,
            'senha' => $hash
        ];

        if ($this->companyRepository->create($data)) {
            $this->flash('Cadastro de empresa realizado com sucesso!');
            $this->redirect('/');
        } else {
            $this->flash('Erro ao cadastrar empresa');
            $this->render('cadastro_empresa.php');
        }
    }

    public function dashboard(): void
    {
        $this->requireAuth('empresa');
        
        $empresa = $this->companyRepository->findById($this->getUserId());
        $this->render('pagina_empresa.html', ['empresa' => $empresa]);
    }
}

