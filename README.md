# Instruções para Iniciar o Projeto

Este é um projeto web que utiliza PHP para backend e HTML para o frontend. Siga as instruções abaixo para configurar o ambiente de desenvolvimento e rodar o projeto localmente.

## Requisitos

- [XAMPP](https://www.apachefriends.org/index.html) para o servidor PHP
- [Visual Studio Code](https://code.visualstudio.com/) (VS Code) com a extensão [Live Server](https://marketplace.visualstudio.com/items?itemName=ritwickdey.LiveServer) instalada para servir o arquivo HTML

## Passos para Configuração e Execução

### 1. Configuração do XAMPP

1. **Baixe e instale o XAMPP**:
   - Vá até [XAMPP Downloads](https://www.apachefriends.org/index.html) e faça o download do XAMPP para o seu sistema operacional (Windows, macOS ou Linux).
   
2. **Coloque os arquivos do projeto na pasta `htdocs` do XAMPP**:
   - Após a instalação do XAMPP, navegue até a pasta de instalação do XAMPP.
   - Dentro da pasta, encontre a subpasta `htdocs`.
   - Coloque os arquivos do projeto na pasta `htdocs`. Exemplo: 
     - `C:\xampp\htdocs\meu-projeto` (Windows)
     - `/opt/lampp/htdocs/meu-projeto` (Linux/Mac)

3. **Inicie o Apache no XAMPP**:
   - Abra o painel de controle do XAMPP e inicie o servidor Apache.
   - Se tudo estiver configurado corretamente, o Apache começará a rodar na porta 80 (ou na porta configurada no XAMPP).

4. **Verifique se o servidor está funcionando**:
   - Abra o navegador e acesse `http://localhost/meu-projeto`.
   - Você deve ver o seu projeto rodando.

### 2. Configuração do Live Server para o HTML

1. **Instale o Visual Studio Code**:
   - Caso não tenha o Visual Studio Code (VS Code), faça o download e instale a partir do site oficial: [Visual Studio Code](https://code.visualstudio.com/).

2. **Instale a extensão Live Server**:
   - Abra o VS Code e vá até a seção de extensões (ícone de quadrado no painel lateral esquerdo).
   - Pesquise por "Live Server" e instale a extensão chamada **Live Server** por Ritwick Dey.

3. **Abra seu arquivo HTML no VS Code**:
   - Abra o VS Code e navegue até o arquivo HTML do seu projeto.
   - Clique com o botão direito no arquivo HTML e selecione **Open with Live Server**.
   - Isso abrirá o arquivo HTML no navegador e ele será recarregado automaticamente sempre que você fizer alterações.

### 3. Acessando o Projeto

- **Frontend**: O arquivo HTML será servido pelo Live Server, na porta indicada por ele.
  
- **Backend**: O servidor PHP estará funcionando no XAMPP em `http://localhost/cadastro.php` ou `http://localhost/login.php`.
