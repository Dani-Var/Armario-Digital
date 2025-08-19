<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Closet Fashion</title>
    <link rel="stylesheet" href="/closet_fashion/css/style.css">
</head>
<body>
    <?php
    if (isset($flash_message) && $flash_message): ?>
        <div class="flash-message">
            <?php echo htmlspecialchars($flash_message); ?>
        </div>
    <?php endif; ?>
    
    <div class="container">
        <div class="logo">
            <img src="images/logo.png" alt="Closet Fashion Logo">
        </div>

        <div class="tabs">
            <div class="tab active" data-tab="client-login">Cliente</div>
            <div class="tab" data-tab="company-login">Empresa</div>
        </div>

        <!-- Login Cliente -->
        <form id="client-login" class="tab-content active" method="POST" action="/login">
            <input type="hidden" name="tipo_usuario" value="cliente">
            <div class="form-group">
                <input type="text" name="documento" placeholder="Insira o CPF" required>
            </div>
            <div class="form-group">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>
            <a href="/esqueceu_senha" class="link">Esqueci minha senha</a>
            <button type="submit" class="btn">Entrar</button>
            <a href="/cadastro-cliente" class="btn-link">Sign Up Cliente</a>
        </form>

        <!-- Login Empresa -->
        <form id="company-login" class="tab-content" method="POST" action="/login">
            <input type="hidden" name="tipo_usuario" value="empresa">
            <div class="form-group">
                <input type="text" name="documento" placeholder="Insira o CNPJ" required>
            </div>
            <div class="form-group">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>
            <a href="/esqueceu_senha" class="link">Esqueci minha senha</a>
            <button type="submit" class="btn">Entrar</button>
            <a href="/cadastro-empresa" class="btn-link">Sign Up Empresa</a>
        </form>
    </div>

    <script src="java_modificado.js"></script>
</body>
</html>
