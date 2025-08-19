<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function findByCpf(string $cpf);
    public function findByEmail(string $email);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function existsByCpfOrEmail(string $cpf, string $email): bool;
    public function updateResetToken(int $userId, string $token, string $expiresAt): bool;
    public function findByResetToken(string $token);
    public function updatePassword(int $userId, string $hashedPassword): bool;
}


