<?php

namespace App\Models;

class Cliente
{
    public ?int $id;
    public string $nome;
    public string $cpf;
    public string $email;
    public string $senha;

    public function __construct(?int $id, string $nome, string $cpf, string $email, string $senha)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->senha = $senha;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data["id"] ?? null,
            $data["nome"],
            $data["cpf"],
            $data["email"],
            $data["senha"]
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "cpf" => $this->cpf,
            "email" => $this->email,
            "senha" => $this->senha,
        ];
    }
}

