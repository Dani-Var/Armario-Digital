## Tarefas para refatoração do projeto PHP

### Fase 2: Analisar estrutura atual e identificar necessidades
- [x] Analisar o arquivo `app.php` para entender a estrutura atual.
- [x] Identificar as responsabilidades de cada parte do código (conexão com DB, criação de tabelas, roteamento, lógica de negócio, inclusão de HTML).
- [x] Definir a estrutura de pastas e arquivos para o padrão MVC com Repository.

### Fase 3: Implementar padrão Repository
- [x] Criar interfaces para os repositórios (ex: `UserRepositoryInterface`, `CompanyRepositoryInterface`).
- [x] Criar implementações dos repositórios (ex: `UserRepository`, `CompanyRepository`) para interagir com o banco de dados.
- [x] Mover as operações de banco de dados de `app.php` para os respectivos repositórios.

### Fase 4: Criar redatores (Writers) seguindo MVC
- [x] Criar classes de Controller para lidar com as requisições (ex: `AuthController`, `ClientController`, `CompanyController`).
- [x] Mover a lógica de negócio de `app.php` para os métodos dos Controllers.
- [x] Criar classes de Model (entidades) para Cliente e Empresa.
- [x] Criar classes de View (redatores) para renderizar as páginas HTML.
- [x] Refatorar as inclusões de HTML para usar o sistema de View.

### Fase 5: Organizar estrutura de pastas e arquivos
- [x] Criar pastas para `app/Controllers`, `app/Models`, `app/Repositories`, `app/Views`, `app/Core` (para conexão DB e utilitários).
- [x] Mover os arquivos para suas respectivas pastas.
- [x] Atualizar os caminhos dos arquivos no `bootstrap.php`.

### Fase 6: Entregar projeto reorganizado ao usuário
- [ ] Compactar o projeto refatorado.
- [ ] Fornecer o arquivo compactado ao usuário.
- [ ] Fornecer um resumo das mudanças e instruções de uso.

