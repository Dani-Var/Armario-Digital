document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll(".tab");
            const tabContents = document.querySelectorAll(".tab-content");

            // Função para ativar uma aba e seu conteúdo
            function activateTab(tabId) {
                tabs.forEach(t => t.classList.remove("active"));
                tabContents.forEach(tc => tc.classList.remove("active"));

                document.querySelector(`.tab[data-tab="${tabId}"]`).classList.add("active");
                document.getElementById(tabId).classList.add("active");
            }

            // Adicionar event listeners para as abas
            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    activateTab(this.dataset.tab);
                });
            });

            // Ativar a primeira aba por padrão ao carregar a página
            activateTab("client-login");
        });


// Lógica para cadastro de empresa
const btnCadastrarEmpresa = document.getElementById('btnCadastrarEmpresa');
if (btnCadastrarEmpresa) {
    btnCadastrarEmpresa.addEventListener('click', function() {
        const nomeLoja = document.getElementById('nomeLoja').value;
        const cnpjEmpresa = document.getElementById('cnpjEmpresa').value;
        const emailEmpresa = document.getElementById('emailEmpresa').value;
        const senhaEmpresa = document.getElementById('senhaEmpresa').value;
        const confirmarSenhaEmpresa = document.getElementById('confirmarSenhaEmpresa').value;

        if (senhaEmpresa !== confirmarSenhaEmpresa) {
            alert('As senhas não coincidem!');
            return;
        }

        // Armazenar dados (exemplo simples com localStorage)
        localStorage.setItem('empresaNomeLoja', nomeLoja);
        localStorage.setItem('empresaCnpj', cnpjEmpresa);
        localStorage.setItem('empresaEmail', emailEmpresa);
        localStorage.setItem('empresaSenha', senhaEmpresa);

        alert('Empresa cadastrada com sucesso!');
        window.location.href = 'pagina_empresa.html';
    });
}

const voltarLoginEmpresa = document.getElementById('voltarLoginEmpresa');
if (voltarLoginEmpresa) {
    voltarLoginEmpresa.addEventListener('click', function() {
        window.location.href = 'index.html';
    });
}




// Lógica para cadastro de cliente
const btnCadastrarCliente = document.getElementById('btnCadastrarCliente');
if (btnCadastrarCliente) {
    btnCadastrarCliente.addEventListener('click', function() {
        const nomeCliente = document.getElementById('nomeCliente').value;
        const cpfCliente = document.getElementById('cpfCliente').value;
        const emailCliente = document.getElementById('emailCliente').value;
        const senhaCliente = document.getElementById('senhaCliente').value;
        const confirmarSenhaCliente = document.getElementById('confirmarSenhaCliente').value;

        if (senhaCliente !== confirmarSenhaCliente) {
            alert('As senhas não coincidem!');
            return;
        }

        // Armazenar dados (exemplo simples com localStorage)
        localStorage.setItem('clienteNome', nomeCliente);
        localStorage.setItem('clienteCpf', cpfCliente);
        localStorage.setItem('clienteEmail', emailCliente);
        localStorage.setItem('clienteSenha', senhaCliente);

        alert('Cliente cadastrado com sucesso!');
        window.location.href = 'index.html';
    });
}

const voltarLoginCliente = document.getElementById('voltarLoginCliente');
if (voltarLoginCliente) {
    voltarLoginCliente.addEventListener('click', function() {
        window.location.href = 'index.html';
    });
}




// Lógica de login
document.addEventListener("DOMContentLoaded", function () {
    const botoesEntrar = document.querySelectorAll(".btn");

    botoesEntrar.forEach(botao => {
        botao.addEventListener("click", function () {
            const abaCliente = document.getElementById("client-login");
            const abaEmpresa = document.getElementById("company-login");

            if (abaCliente && abaCliente.classList.contains("active")) {
                const cpfCnpj = abaCliente.querySelector("input[type='text']").value;
                const senha = abaCliente.querySelector("input[type='password']").value;

                const clienteCpf = localStorage.getItem("clienteCpf");
                const clienteSenha = localStorage.getItem("clienteSenha");

                if (cpfCnpj === clienteCpf && senha === clienteSenha) {
                    window.location.href = "pagina_cliente.html";
                } else {
                    alert("CPF ou senha inválidos para cliente.");
                }
            }

            if (abaEmpresa && abaEmpresa.classList.contains("active")) {
                const cnpj = abaEmpresa.querySelector("input[type='text']").value;
                const senha = abaEmpresa.querySelector("input[type='password']").value;

                const empresaCnpj = localStorage.getItem("empresaCnpj");
                const empresaSenha = localStorage.getItem("empresaSenha");

                if (cnpj === empresaCnpj && senha === empresaSenha) {
                    window.location.href = "pagina_empresa.html";
                } else {
                    alert("CNPJ ou senha inválidos para empresa.");
                }
            }
        });
    });
});
