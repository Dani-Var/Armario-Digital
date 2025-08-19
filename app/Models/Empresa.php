<?php

namespace App\Models;

class Empresa
{
    public ?int $id;
    public string $nomeLoja;
    public string $cnpj;
    public string $email;
    public string $senha;

    public function __construct(?int $id, string $nomeLoja, string $cnpj, string $email, string $senha)
    {
        $this->id = $id;
        $this->nomeLoja = $nomeLoja;
        $this->cnpj = $cnpj;
        $this->email = $email;
        $this->senha = $senha;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data["id"] ?? null,
            $data["nome_loja"],
            $data["cnpj"],
            $data["email"],
            $data["senha"]
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "nome_loja" => $this->nomeLoja,
            "cnpj" => $this->cnpj,
            "email" => $this->email,
            "senha" => $this->senha,
        ];
    }
}

