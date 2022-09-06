# filas-rabbitmq-exemplo
Exemplo simples de fila com RabbitMQ no envio de dados para pagamento

Por ser um pequeno exemplo nao se utiliza banco de dados

## Setup ##

## No producer ##

```bash
$ composer install
```
Configurar variaveis do rabbitmq em queue.php (principalmente a exchange que vai ser utilizada)

```bash
$ php artisan serve
```

## No consumer ##

```bash
$ composer install
```

Configurar variaveis do rabbitmq em index.php (principalmente a exchange, queue e consumerTag)

```bash
$ php index.php
```
