<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\ClientController;
use App\Controllers\CompanyController;

// Inicializar o roteador
$router = new Router();

// Definir as rotas
$router->get('/', function() {
    $controller = new AuthController();
    $controller->showLogin();
});

$router->get('/index.php', function() {
    $controller = new AuthController();
    $controller->showLogin();
});

$router->post('/login', function() {
    $controller = new AuthController();
    $controller->login();
});

$router->get('/logout', function() {
    $controller = new AuthController();
    $controller->logout();
});

// Rotas de redefinição de senha
$router->get('/forgot-password', function() {
    $controller = new AuthController();
    $controller->showForgotPasswordForm();
});

$router->post('/send-password-reset-email', function() {
    $controller = new AuthController();
    $controller->sendPasswordResetEmail();
});

$router->get('/reset-password', function() {
    $controller = new AuthController();
    $controller->showResetPasswordForm();
});

$router->post('/reset-password', function() {
    $controller = new AuthController();
    $controller->resetPassword();
});

// Rotas de cliente
$router->get('/cadastro-cliente', function() {
    $controller = new ClientController();
    $controller->showRegisterForm();
});

$router->post('/cadastro-cliente', function() {
    $controller = new ClientController();
    $controller->register();
});

$router->get('/pagina_cliente', function() {
    $controller = new ClientController();
    $controller->showClientPage();
});

// Rotas de empresa
$router->get('/cadastro-empresa', function() {
    $controller = new CompanyController();
    $controller->showRegisterForm();
});

$router->post('/cadastro-empresa', function() {
    $controller = new CompanyController();
    $controller->register();
});

$router->get('/pagina_empresa', function() {
    $controller = new CompanyController();
    $controller->showCompanyPage();
});

// Executar o roteador
$router->dispatch();


