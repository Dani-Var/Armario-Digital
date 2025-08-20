<?php

namespace App\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        session_destroy();
    }

    public static function flash(string $message): void
    {
        self::set('flash_message', $message);
    }

    public static function getFlash(): ?string
    {
        if (self::has('flash_message')) {
            $message = self::get('flash_message');
            self::remove('flash_message');
            return $message;
        }
        return null;
    }

    public static function isLoggedIn(): bool
    {
        return self::has('user_id');
    }

    public static function getUserId(): ?int
    {
        return self::get('user_id');
    }

    public static function getUserType(): ?string
    {
        return self::get('user_type');
    }

    public static function login(int $userId, string $userType): void
    {
        self::set('user_id', $userId);
        self::set('user_type', $userType);
    }

    public static function logout(): void
    {
        self::destroy();
    }
}

?>