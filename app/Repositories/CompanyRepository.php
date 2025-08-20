<?php

namespace App\Repositories;

use PDO;

class CompanyRepository implements CompanyRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByCnpj(string $cnpj)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM empresa WHERE cnpj = ?");
        $stmt->execute([$cnpj]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM empresa WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM empresa WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO empresa (nome_loja, cnpj, email, senha) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data["nome_loja"],
            $data["cnpj"],
            $data["email"],
            $data["senha"]
        ]);
    }

    public function update(int $id, array $data)
    {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        
        $values[] = $id;
        $sql = "UPDATE empresa SET " . implode(", ", $fields) . " WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function existsByCnpjOrEmail(string $cnpj, string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM empresa WHERE cnpj = ? OR email = ?");
        $stmt->execute([$cnpj, $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function updateResetToken(int $companyId, string $token, string $expiresAt): bool
    {
        $stmt = $this->pdo->prepare("UPDATE empresa SET reset_token = ?, reset_token_expires_at = ? WHERE id = ?");
        return $stmt->execute([$token, $expiresAt, $companyId]);
    }

    public function findByResetToken(string $token)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM empresa WHERE reset_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword(int $companyId, string $hashedPassword): bool
    {
        $stmt = $this->pdo->prepare("UPDATE empresa SET senha = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE id = ?");
        return $stmt->execute([$hashedPassword, $companyId]);
    }
}

?>
