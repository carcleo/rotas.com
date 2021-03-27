<?php

return [
    /*
           | ------------------------------------------------- -------------------------
           | Status do aplicativo
           | ------------------------------------------------- -------------------------
           | development/production
           |
           | Aqui estão as configurações de conexões de banco de dados para seu aplicativo.
           | Assim sera recuperado os dados de acesso ao banco de dados
           | conforme o indice environment.
           |
           */
    'environment' => env('APP_ENV'),
    /*
           | ------------------------------------------------- -------------------------
           | Conexões de banco de dados
           | ------------------------------------------------- -------------------------
           |
           | Aqui estão as configurações de conexões de banco de dados para seu aplicativo.
           |
           | Portanto, verifique se você tem o driver para o banco de dados
           | instalado em sua máquina antes de começar o desenvolvimento.
           |
           */
    'driver' => env('DEVELOPMENT_DB_CONNECTION'),
    'connections' => [
        'development' => [
            /*
                   | ------------------------------------------------- -------------------------
                   | Nome Padrão da Conexão do Banco de Dados
                   | ------------------------------------------------- -------------------------
                   |
                   | Aqui você pode especificar quais das conexões de banco de dados abaixo você deseja
                   | para usar como sua conexão padrão para o trabalho de banco de dados.
                   |
                   */
            'mysql' => [
                'driver' => env('DEVELOPMENT_DB_CONNECTION'),
                'host' => env('DEVELOPMENT_DB_HOST'),
                'port' => env('DEVELOPMENT_DB_PORT'),
                'database' => env('DEVELOPMENT_DB_DATABASE'),
                'username' => env('DEVELOPMENT_DB_USERNAME'),
                'password' => env('DEVELOPMENT_DB_PASSWORD'),
                'unix_socket' => env('DEVELOPMENT_DB_SOCKET'),
                'options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                ],
                'dsn' => 'mysql:dbname='.env('DEVELOPMENT_DB_DATABASE').';host='.env('DEVELOPMENT_DB_HOST'),
                'errmode' => PDO::ERRMODE_EXCEPTION,
                'fetch_mode' => PDO::FETCH_OBJ
            ],

            'sqlite' => [
                'driver' => env('DEVELOPMENT_DB_CONNECTION'),
                'database' => env('DEVELOPMENT_DB_DATABASE'),
                'prefix' => ''
            ],

            'pgsql' => [
                'driver' => env('DEVELOPMENT_DB_CONNECTION'),
                'host' => env('DEVELOPMENT_DB_HOST'),
                'port' => env('DEVELOPMENT_DB_PORT'),
                'database' => env('DEVELOPMENT_DB_DATABASE'),
                'username' => env('DEVELOPMENT_DB_USERNAME'),
                'password' => env('DEVELOPMENT_DB_PASSWORD'),
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ],

            'sqlsrv' => [
                'driver' => env('DEVELOPMENT_DB_CONNECTION'),
                'host' => env('DEVELOPMENT_DB_HOST'),
                'port' => env('DEVELOPMENT_DB_PORT'),
                'database' => env('DEVELOPMENT_DB_DATABASE'),
                'username' => env('DEVELOPMENT_DB_USERNAME'),
                'password' => env('DEVELOPMENT_DB_PASSWORD'),
                'charset' => 'utf8',
                'prefix' => '',
            ],
        ],

        'production' => [
            'mysql' => [
                'driver' => env('PRODUCTION_DB_CONNECTION'),
                'host' => env('PRODUCTION_DB_HOST'),
                'port' => env('PRODUCTION_DB_PORT'),
                'database' => env('PRODUCTION_DB_DATABASE'),
                'username' => env('PRODUCTION_DB_USERNAME'),
                'password' => env('PRODUCTION_DB_PASSWORD'),
                'unix_socket' => env('PRODUCTION_DB_SOCKET'),
                'options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                ],
                'dsn' => 'mysql:dbname='.env('PRODUCTION_DB_DATABASE').';host='.env('PRODUCTION_DB_HOST'),
                'errmode' => PDO::ERRMODE_EXCEPTION,
                'fetch_mode' => PDO::FETCH_OBJ
            ],

            'sqlite' => [
                'driver' => env('DEVELOPMENT_DB_CONNECTION'),
                'database' => env('DEVELOPMENT_DB_DATABASE'),
                'prefix' => ''
            ],

            'pgsql' => [
                'driver' => env('DEVELOPMENT_DB_CONNECTION'),
                'host' => env('DEVELOPMENT_DB_HOST'),
                'port' => env('DEVELOPMENT_DB_PORT'),
                'database' => env('DEVELOPMENT_DB_DATABASE'),
                'username' => env('DEVELOPMENT_DB_USERNAME'),
                'password' => env('DEVELOPMENT_DB_PASSWORD'),
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ],

            'sqlsrv' => [
                'driver' => env('DEVELOPMENT_DB_CONNECTION'),
                'host' => env('DEVELOPMENT_DB_HOST'),
                'port' => env('DEVELOPMENT_DB_PORT'),
                'database' => env('DEVELOPMENT_DB_DATABASE'),
                'username' => env('DEVELOPMENT_DB_USERNAME'),
                'password' => env('DEVELOPMENT_DB_PASSWORD'),
                'charset' => 'utf8',
                'prefix' => '',
            ]
        ]
    ]
];