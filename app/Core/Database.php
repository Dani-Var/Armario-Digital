<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;
    private static string $dbPath = __DIR__ . "/../../closet_fashion.db";

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO("sqlite:" . self::$dbPath);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::createTables();
            } catch (PDOException $e) {
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    private static function createTables(): void
    {
        $sqlCliente = "
            CREATE TABLE IF NOT EXISTS cliente (
                reset_token TEXT,
                reset_token_expires_at TEXT,
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                cpf TEXT UNIQUE NOT NULL,
                email TEXT UNIQUE NOT NULL,
                senha TEXT NOT NULL
            )
        ";

        $sqlEmpresa = "
            CREATE TABLE IF NOT EXISTS empresa (
                reset_token TEXT,
                reset_token_expires_at TEXT,
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome_loja TEXT NOT NULL,
                cnpj TEXT UNIQUE NOT NULL,
                email TEXT UNIQUE NOT NULL,
                senha TEXT NOT NULL
            )
        ";

        self::$pdo->exec($sqlCliente);
        self::$pdo->exec($sqlEmpresa);
    }
}

