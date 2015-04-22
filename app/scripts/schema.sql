    /*
    |--------------------------------------------------------------------------
    | Script de Criação das Tabelas
    |--------------------------------------------------------------------------
    |
    | Abaixo estão os scripts responsáveis por criarem o esquema 
    | do banco de dados.
    |
    */
    CREATE TABLE `marcacoes` (
        `id` int(11) NOT NULL AUTO_INCREMENT, 
        `username` varchar(50) NOT NULL, 
        `lng` decimal(10,7) NOT NULL, 
        `lat` decimal(10,7) NOT NULL, 
        `datetime_created` DATETIME DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY (`id`) 
    );