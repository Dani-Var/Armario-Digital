<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa - Closet Fashion</title>
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
        <h2>Cadastro de Empresa</h2>
        <div class="tabs">
            <div class="tab active" data-tab="client-register">Cliente</div>
            <div class="tab" data-tab="company-register">Empresa</div>
        </div>
        <form id="company-register" class="tab-content active" method="POST" action="/cadastro-empresa">
            <div class="form-group">
                <input type="text" name="nome_loja" placeholder="Nome da Loja" required>
            </div>
            <div class="form-group">
                <input type="text" name="cnpj" placeholder="Insira o CNPJ" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Insira o Email contato" required>
            </div>
            <div class="form-group">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirmar_senha" placeholder="Confirme sua senha" required>
            </div>
            <button type="submit" class="btn">Cadastrar</button>
             <a href="/" class="link">Voltar ao Login</a>
        </form>
    </div>
     <script src="java_modificado.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.dataset.tab;

                    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));

                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                });
            });
        });
    </script>
</body>
</html>

