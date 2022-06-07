## Descrição do Projeto

Projeto com gestão de usuários e permissões usando o pacote Spatie.

## Tecnologias

Laravel 6.18.3 <a  href="https://laravel.com/docs/6.x/installation"><img  src="https://img.shields.io/static/v1?label=Laravel&message=framework&color=orange&style=for-the-badge&logo=LARAVEL"/></a><br />

Spatie 3.15 <a  href="https://spatie.be/docs/laravel-permission/v3/installation-laravel"><img  src="https://img.shields.io/static/v1?label=Spatie&message=package&color=orange&style=for-the-badge&logo=LARAVEL"/></a><br />

Bootstrap 4 <a  href="https://getbootstrap.com/"><img  src="https://img.shields.io/static/v1?label=Bootstrap&message=framework&color=orange&style=for-the-badge&logo=BOOTSTRAP"/></a><br />

## Instalação

composer install (Instalação do diretório <b>/vendor</b> e dependências do projeto) <br />

Criar arquivo .env (Copiar do .env.example) <br />

No diretório do projeto execute os comandos:

Criar APP_KEY
<code>
php artisan key:generate
</code>

Criar as tabelas do banco de dados com os <b>migrates</b> e popular de dados com <b>seed</b>

<code>
php artisan migrate --seed
</code>

Iniciar o projeto
<code>
php artisan serve
</code>
