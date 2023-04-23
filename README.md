### Objetivo
O objetivo deste projeto é desenvolver um sistema de Chamados/Demandas e conhecer melhor as suas habilidades técnicas e o conhecimento adquirido nos cursos.

### Critérios
Para o desenvolvimento desta aplicação deverá ser utilizado todos os conceitos repassados nos cursos enviados (HTML, CSS, JS, PHP, SQL, VUEJS, LARAVEL...), basedo nessas tecnologias, orientamos seguir os seguintes critérios:

- Utilizar Github para versionar e enviar o projeto.
- Backend PHP
- Frontend (desejável VueJS).
- Banco de dados MySQL/PostgresSQL
- Utilizar CSS/Html/JS.
- Alterar a cor da listagem das demandas/chamados de acordo com o status (Ex. Pendente na cor amarela, em andamento na cor azul, concluído na cor verde e cancelada na cor vermelha).

### Requisitos
- Login
- Cadastros
	- Usuário
		- Nome
		- E-mail
		- Senha
	- Demandas/Chamados
		- Número (*Poderá utilizar a chave primária da base de dados)
		- Título
		- Descrição
		- Data e Hora de Abertura
		- Data e Hora de Fechamento
		- Usuário que abriu a demanda/chamado
		- Usuário atendeu a demanda/chamado
		- Status (Aberto, Andamento, Finalizado)
	- Interação de Demandas/Chamados
		- Número da Demanda
		- Usuário que fez a interação
		- Descrição
		- Data e Hora da interação

### Importante
Caso não tenha concluído todos os cursos, poderá fazer este projeto em etapas. Por exemplo, se concluiu o curso de HTML, CSS, e JS, mas não fez concluiu o de PHP e Banco de dados. Crie o projeto da tela, com dados fictícios aplicando os conceitos estudados.



### Versões
Laravel Framework 8.83.27 |
PHP 7.4.33 |
PostgreSQL 15.1

### Processos para rodar o sistema
- git clone https://github.com/gustavomews/app_demandas_chamados_vue.git
- cd app_demandas_chamados_vue
- composer update
- 
- Criar base de dados no postgres com o nome demandas_chamados
- Verificar se conexão com o banco ficou igual a do .env disponibilizado no git hub
- 
- php artisan migrate
- php artisan db:seed --class=StatusDemandSeeder

- Registrar-se no sistema
- Criar e controlar demandas