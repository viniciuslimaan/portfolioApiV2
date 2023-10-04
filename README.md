# Portfólio API v2

Repositório da API do meu portfólio.

## 🛠️ Tecnologias utilizadas

-   PHP
-   Laravel
-   MySql

## 🚀 Rodando localmente

Para visualizar em seu computador use:

```
git clone https://github.com/viniciuslimaan/portfolioApiV2.git

cd portfolioApiV2

composer i

php artisan make:migrate
--> ou caso queira dados fake execute:
php artisan make:migrate --seed

php artisan jwt:secret

php artisan serve
```

Obs: é necessário a configuração do .env e a criação de uma tabela chamada 'portfolio' antes de executar os comandos php.

## ⚙️ Variáveis de ambiente

Para utilizar essa aplicação, basta apagar o '.example' do arquivo '.env.example' podendo tanto deixar como está, quanto editando de acordo com sua necessidade.

Para as imagens upadas serem exibidas corretamente, altere o **APP_URL** do .env de acordo com a url do projeto.

## 📄 Postman

É possível testar o projeto sem ter o FrontEnd, basta usar o [Postman](https://www.postman.com). Os arquivos para importação (collection e environment) estão localizados na pasta 'libs'.

## 🎲 Banco

É necessário a criação de uma tabela com o nome de 'portfolio' do tipo "utf8_general_ci" no MySql.

Um modelo do banco de dados do projeto, seja em forma de arquivo ou imagem, está armazenado na pasta 'libs'. É importante observar que este modelo foi criado no início do projeto apenas para fins de planejamento e não tem nenhum efeito prático, uma vez que as tabelas são geradas automaticamente pelo Laravel.
