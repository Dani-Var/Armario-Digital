<?php

namespace App\Repositories;

interface CompanyRepositoryInterface
{
    public function findByCnpj(string $cnpj);
    public function findByEmail(string $email);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function existsByCnpjOrEmail(string $cnpj, string $email): bool;
    public function updateResetToken(int $companyId, string $token, string $expiresAt): bool;
    public function findByResetToken(string $token);
    public function updatePassword(int $companyId, string $hashedPassword): bool;
}


?>