## Biblioteca PHP

### Objetivo
Gerenciar um registro de livros contento informações sobre sua editora e autores.

### Inicialização

Esse projeto foi contruido utilizando o framework Laravel, serão necessários seguir os passos abaixo para que se possa iniciar.

> Instalando dependências

O primeiro passo é realizar a instalação utilizando o seguinte comando:

```bash 
composer install
```

> Copiando .env 

O projeto já possui um arquivo de exemplo das variáveis ambiente necessárias para inicialização, basta executar o comando abaixo para criar uma cópia com o nome correto:
```bash 
cp  .env.example  .env
``` 

> Inicializando containers

Esse projeto utiliza o [Laravel Sail](https://laravel.com/docs/12.x/sail#main-content) para instalação e execução, a seguir serão mostrados os comando necessários para executar o projeto localmente:

```bash
sail up -d(opcional)
```
Esse comando erá iniciar os containers do docker já configurado no ambiente

> Criando as tabelas do banco de dados

Todas as migrations necessárias estão presentes no diretório <b>database/migrations</b> para verificação, o comando abaixo irá executa-las e criar as tabelas no banco de dados

```bash 
sail artisan migrate
```

> Gerando a chave do laravel e gerando o config cache

O Laravel utilizada uma chave criptografada para aplicação de encriptação, sessões e validação de tokens CSRF, essa chave está presente no .env com o nome <b>APP_KEY</b>, os comandos abaixo são necessários para gerar essa chave e reaplicar o cache nas configurações 

```bash 
sail artisan key:generate
sail artisan config:cache
```

Nesse ponto o projeto já está funcional no ambiente e é possível executar requisições, foi disponibilizado também na pasta <b>postman</b> um exemplo com as collections e enviroment com as rotas cadastradas, basta importar os arquivos para o seu postman e utilizar.