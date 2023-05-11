# api_demandas_chamados

## Utilizar API junto do sistema FrontEnd desenvolvido em VueJS disponível no repositório: [Sistema](https://github.com/gustavomews/demandas_chamados_npm_vue)
```
git clone https://github.com/gustavomews/api_demandas_chamados.git
cd api_demandas_chamados
composer update
```
- Criar base de dados no postgres com o nome demandas_chamados
- Verificar se conexão com o banco ficou igual a do .env disponibilizado no git hub

```
- php artisan migrate
- php artisan db:seed --class=StatusDemandSeeder
```

### Versões
Laravel Framework 8.83.27 |
PHP 7.4.33 |
PostgreSQL 15.1
