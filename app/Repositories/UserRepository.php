<?php

namespace App\Repositories;

use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByCpf(string $cpf)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cliente WHERE cpf = ?");
        $stmt->execute([$cpf]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cliente WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cliente WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO cliente (nome, cpf, email, senha) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data["nome"],
            $data["cpf"],
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
        $sql = "UPDATE cliente SET " . implode(", ", $fields) . " WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function existsByCpfOrEmail(string $cpf, string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM cliente WHERE cpf = ? OR email = ?");
        $stmt->execute([$cpf, $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function updateResetToken(int $userId, string $token, string $expiresAt): bool
    {
        $stmt = $this->pdo->prepare("UPDATE cliente SET reset_token = ?, reset_token_expires_at = ? WHERE id = ?");
        return $stmt->execute([$token, $expiresAt, $userId]);
    }

    public function findByResetToken(string $token)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cliente WHERE reset_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword(int $userId, string $hashedPassword): bool
    {
        $stmt = $this->pdo->prepare("UPDATE cliente SET senha = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE id = ?");
        return $stmt->execute([$hashedPassword, $userId]);
    }
}


