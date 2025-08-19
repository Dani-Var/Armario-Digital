<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu sua senha? - Closet Fashion</title>
    <link rel="stylesheet" href="../../css/style.css">
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
        <h2>Esqueceu sua senha?</h2>
        <p>Enviaremos um email com instruções de como redefinir a senha.</p>
        <form method="POST" action="/send-password-reset-email">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="tipo_usuario">Tipo de Usuário:</label>
                <select name="tipo_usuario" id="tipo_usuario" required>
                    <option value="cliente">Cliente</option>
                    <option value="empresa">Empresa</option>
                </select>
            </div>
            <button type="submit" class="btn">Enviar</button>
        </form>
        <a href="/" class="link">Voltar ao Login</a>
    </div>
</body>
</html>


