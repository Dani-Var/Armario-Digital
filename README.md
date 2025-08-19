# Closet Fashion - Guia de Inicialização

Este guia detalha os passos necessários para configurar e executar o projeto Closet Fashion em seu ambiente local.

## 1. Pré-requisitos

Certifique-se de ter os seguintes softwares instalados em seu sistema:

- Servidor Web Apache2
- PHP (versão 7.4 ou superior, com extensões PDO e SQLite3)
- Composer (gerenciador de dependências PHP)
- SQLite3 (ferramenta de linha de comando)

## 2. Configuração do Servidor Web (Apache2)

1.  **Habilitar o módulo `mod_rewrite`:**

    ```bash
    sudo a2enmod rewrite
    ```

2.  **Criar um arquivo de configuração para o Apache (`closet_fashion.conf`):**

    ```bash
    sudo nano /etc/apache2/sites-available/closet_fashion.conf
    ```

    Adicione o seguinte conteúdo ao arquivo, substituindo `/var/www/html/closet_fashion` pelo caminho real do seu projeto:

    ```apache
    <VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/closet_fashion

        <Directory /var/www/html/closet_fashion>
            Options -Indexes +FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
    ```

3.  **Habilitar o site e desabilitar o site padrão (se necessário):**

    ```bash
    sudo a2ensite closet_fashion.conf
    sudo a2dissite 000-default.conf
    ```

4.  **Reiniciar o Apache:**

    ```bash
    sudo systemctl restart apache2
    ```

## 3. Configuração do Projeto

1.  **Navegue até o diretório raiz do projeto:**

    ```bash
    cd /var/www/html/closet_fashion
    ```

2.  **Instale as dependências do Composer:**

    ```bash
    composer install
    ```

3.  **Crie o arquivo `.htaccess` na raiz do projeto:**

    ```bash
    sudo nano .htaccess
    ```

    Adicione o seguinte conteúdo:

    ```apache
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteBase /closet_fashion/
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php/$1 [L]
    </IfModule>
    ```

4.  **Verifique as permissões da pasta `app/Core` e `email_log.txt`:**

    ```bash
    sudo chmod -R 775 /var/www/html/closet_fashion/app/Core
    sudo chmod 666 /var/www/html/closet_fashion/email_log.txt
    ```

## 4. Configuração do Banco de Dados (SQLite)

O projeto utiliza SQLite, e o banco de dados `closet_fashion.db` será criado automaticamente na primeira execução se não existir. As tabelas `cliente` e `empresa` também serão criadas.

Para verificar o conteúdo do banco de dados, você pode usar o comando `sqlite3`:

```bash
sqlite3 /var/www/html/closet_fashion/closet_fashion.db ".tables"
sqlite3 /var/www/html/closet_fashion/closet_fashion.db "SELECT * FROM cliente;"
sqlite3 /var/www/html/closet_fashion/closet_fashion.db "SELECT * FROM empresa;"
```

## 5. Configuração do Serviço de E-mail (Apenas para Teste Local)

O `EmailService.php` foi modificado para logar os e-mails em um arquivo `email_log.txt` dentro do diretório do projeto, em vez de enviá-los via SMTP. Isso é útil para testes locais sem a necessidade de configurar um servidor SMTP real.

Para visualizar os e-mails enviados (logados):

```bash
cat /var/www/html/closet_fashion/email_log.txt
```

Se você deseja configurar o envio de e-mails reais, edite o arquivo `app/Core/EmailService.php` e configure as credenciais do seu servidor SMTP (Host, Username, Password, etc.).

## 6. Acessando o Projeto

Após seguir todos os passos, você pode acessar o projeto em seu navegador através do endereço:

```
http://localhost/closet_fashion
```

Você poderá se cadastrar como cliente ou empresa e testar as funcionalidades de login e redefinição de senha.

