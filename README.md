🎬 CineTech  

Com o crescimento do mercado audiovisual, a CineTech Solutions surge para modernizar o gerenciamento e a exibição de filmes. O sistema permite o cadastro completo de filmes, incluindo capa e trailer, e oferece uma experiência interativa para busca e filtro por gênero.

Desenvolvido com PHP (API robusta), MySQL e um front-end moderno em HTML, CSS e JavaScript (Bootstrap/TailwindCSS), o projeto otimiza a administração de conteúdos audiovisuais, tornando a navegação mais intuitiva e eficiente.

Dividido em área administrativa (gestão de filmes e gêneros) e usuário final (exploração e pesquisa de filmes), a plataforma proporciona uma experiência envolvente e acessível. 🚀🎥

#CineTechSolutions #DesenvolvimentoWeb #PHP #MySQL #Frontend #UX #Filmes



![pagina inicial cine_tech](https://github.com/user-attachments/assets/42341b51-6c33-442b-a6d5-cad7ae23bd70)













![pagina admistrativa](https://github.com/user-attachments/assets/bb5a124c-b5d7-4aa9-86f8-a920c9fa86fa)



Como rodar em sua maquina!

🔹 Passo a Passo para Rodar o Projeto PHP no XAMPP
1️⃣ Instalar o XAMPP
Baixe e instale o XAMPP no site oficial: https://www.apachefriends.org

Abra o XAMPP e inicie os serviços Apache e MySQL.

2️⃣ Configurar o Projeto
Baixe o projeto e copie para a pasta:

makefile
Copiar
Editar
C:\xampp\htdocs\cine_tech
Se o projeto tiver um arquivo de configuração do banco (db.php), edite com os dados:

php
Copiar
Editar
$host = "localhost";
$dbname = "cine_tech";
$user = "root";
$password = "";
3️⃣ Importar o Banco de Dados
Abra o navegador e vá para:

arduino
Copiar
Editar
http://localhost/phpmyadmin
Clique em Novo → Digite o nome do banco (mesmo nome do db.php) → Clique em Criar.

Vá na aba Importar, selecione o arquivo .sql do banco e clique em Executar.

4️⃣ Rodar o Projeto
No navegador, acesse:

arduino
http://localhost/cine_tech/index.php
Se tudo estiver certo, a página inicial do sistema deve aparecer! 🎉

