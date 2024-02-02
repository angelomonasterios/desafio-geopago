# Teste GeoVendas

Teste GeoVendas é um aplicativo desenvolvido em PHP para [descreva a finalidade do projeto].

Este projeto utiliza Docker para criar um ambiente MySQL para armazenar e manipular dados.

## Pré-requisitos

- Docker
- PHP 8+

## Estrutura do Projeto

A estrutura do projeto é a seguinte:
. ├───Database ├───Helpers └───Repository

## Como executar

Siga os passos abaixo:

1. Clone este repositório para o seu ambiente local.
2. Navegue até o diretório raiz do projeto e execute o seguinte comando para iniciar a stack Docker (MySQL):
   1. `docker-compose up -d`
3. execute o arquivo php `index.php` para rodar o projeto.
4. tambem pode executar o arquivo `test.php` para rodar os testes. lembrando ter o phpunit instalado.