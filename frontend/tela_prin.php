<?php
require_once __DIR__ . ('/../backend/database/connection.php');

$tasks = [];
$pdo = (new Connection())->getConnection();
$sql = $pdo->query("SELECT * FROM tasks");

try{
    if ($sql->rowCount() > 0) {
    $tasks = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e){
    echo "Erro ao buscar tarefas: " . $e->getMessage();
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="frontend/style/tela_prin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       
    <title> Seu Checklist</title>
</head>
<body>

    <div id="loadingOvelay" class="loading-overlay hidden">
        <div class="loading-spinner"></div>
        <p>Salvando...</p>
    </div>
    
    <div class="slides">
        <div class="slide"></div>
        <div class="slide"></div>
        <div class="slide"></div>
        <div class="slide"></div>
        <div class="slide"></div>
        <div class="slide"></div>
        <div class="slide"></div>
    </div>

    <div id="to_do">
        <h1>Seu Checklist</h1>

        <form action="index.php" method="POST" class="to_do_form" id="createTaskForm">
                <input type="hidden" name="acao" value="criar_ajax">
                <input type="text" name="description" placeholder="Escreva a sua tarefa aqui" required>
                <button type="submit" class="form-button">
                    <i class="fa-solid fa-plus"></i>
                </button>
        </form>

        <div class="tasks" id="tasksList">

           <?php foreach($tasks as $task): ?>
               <?php include __DIR__ . ('/task_item.php') ?> <!--O include se difere do require, pois o primeiro mesmo com algumas falhas continua processando código, enquanto o segundo para a aplicação-->
           <?php endforeach ?>
        </div>
    </div>
    
    <script src="/frontend/js/tela_prin.js"></script>
</body>
</html>