<?php


class Database
{
    public PDO $pdo;

    public function __construct(
        public readonly string $host     = 'localhost',
        public readonly string $dbname   = 'characters',
        public readonly string $user     = 'slave',
        public readonly string $password = ''
    ){
        $dsn = "pgsql:host=$host;dbname=$dbname";
        
        $this->pdo= new PDO($dsn, $user, $password);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}