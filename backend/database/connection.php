<?php

    $hostname = "aws-1-us-east-1.pooler.supabase.com";
    $dbname = "checklist_rotina";
    $username = "postgres.ldozdavubrsehsxeaofw";
    $password = "6794check2026";

    try {
        $pdo = new PDO("pgsql:host=$hostname;dbname=$dbname, $username,  $password");
    } catch (PDOException $e) {
        echo ("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
