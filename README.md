<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>



## Clonar repositório

Para clonar o repositório na sua máquina com git, rode o seguinte comando:

```
git clone https://github.com/josebruno2020/developer-api.git
```

## Configuração do docker

Para configurar o ambiente docker na sua máquina rode o comando na pasta do projeto:

```
cp .env.example .env && docker-compose build && docker-compose up -d 
```

Este passo pode demorar um pouquinho até que tudo seja configurado.

OBS: por padrão estou usando a porta `4000` para o php e a `5434` para o banco de dados. Certifique-se que estejam livres ou mude no arquivo `docker-compose.yml`


## Intalando pacotes, rodando migrations e configurando laravel

Para instalar os pacotes e rodar as migrations do projeto, rode o comando:
```
docker exec api composer install && docker exec api php artisan migrate && docker exec api php artisan key:generate && docker exec api chmod 777 -R storage/*
```

#### Pronto, backend está configurado e rodando na porta 4000 (por padrão)!


## Documentação

Para acessar a documentação do backend, acesse a seguinte url:
```
http://localhost:4000/docs/
```

## Testes unitários

Para rodar os testes unitários, rode o seguinte comando:
```
docker exec api php artisan test
```
Os testes, com seus resultados serão impressos no terminal.

### OBS - DOCKER

Neste tutorial coloquei os comandos docker com permissão de root. Caso não tenha, não se esqueça de usar o `sudo` antes de cada comando `docker` ou `docker-compose`
