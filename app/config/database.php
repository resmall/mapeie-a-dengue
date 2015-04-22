<?php


return [

    'default' => 'mysql',
    /*
    |--------------------------------------------------------------------------
    | Conexão do Banco de Dados
    |--------------------------------------------------------------------------
    |
    | Abaixo estão as conexões possíveis para a aplicação. 
    | Se for necessário no futuro adicionar outro driver de conexão, é só
    | adicionar um novo item no array, informando o nome.
    |
    */
    'connections' => [
        'mysql' => [
            'host'      => 'localhost',
            'database'  => 'dengue',
            'username'  => 'homestead',
            'password'  => 'secret'
        ]
    ]
];
