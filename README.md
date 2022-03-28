# PHP SSH

    Gerenciador de conexões SSH em PHP utilizando a lib SSH2

## Utilização

Para user este gerenciador basta seguir o exemplo abaixo:

```php
<?php

require __DIR__.'/vendor/autoload.php';

//Dependências
use Hengui\SecureShell\SSH;

//Instância
$ssh = new SSH;

//Conexão
if(! $ssh->connect('192.168.29.196', 22)) {
    die('Falha na Conexão');
}

//Autenticação
if(! $ssh->authPassword('test', 'test')) {
    die('Usuário ou senha incorretos');
}


//Executa comandos
echo $ssh->exec('ls -la');


//Desconecta
$ssh->disconnect();

```
## Requisitos
- Necessário PHP 7.0 ou superior
- Necessário Extensão php-ssh2