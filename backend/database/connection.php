<?php

    $hostname = "aws-1-us-east-1.pooler.supabase.com";
    $dbname = "postgres";
    $port = 5432;
    $username = "postgres.ldozdavubrsehsxeaofw";
    $password = "6794check2026";

    try {
        $dsn = "pgsql:host=$hostname;port=$port;dbname=$dbname;sslmode=require";
        $pdo = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo ("Erro ao conectar ao banco: " . $e->getMessage());
    }
