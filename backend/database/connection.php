<?php

class Connection {
    private string $hostname = "aws-1-us-east-1.pooler.supabase.com";
    private string $dbname = "postgres";
    private int $port = 5432;
    private string $username = "postgres.ldozdavubrsehsxeaofw";
    private string $password = "6794check2026";


    public function getConnection() : PDO {
        try {
            $dsn = "pgsql:host={$this->hostname};port={$this->port};dbname={$this->dbname};sslmode=require";
            $pdo = new PDO($dsn, $this->username, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            return $pdo;
        } catch (PDOException $e) {
            echo ("Erro ao conectar ao banco: " . $e->getMessage());
        }
    }
   





}
    