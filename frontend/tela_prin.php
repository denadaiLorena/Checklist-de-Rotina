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

        <form action="index.php" method="POST" class="to_do_form">
                <input type="hidden" name="acao" value="criar">
                <input type="text" name="description" placeholder="Escreva a sua tarefa aqui" required>
                <button type="submit" class="form-button">
                    <i class="fa-solid fa-plus"></i>
                </button>
        </form>

        <div class="tasks">

           <?php foreach($tasks as $task): ?>
               <div class="task">
                   <input type="checkbox"
                    name="progress"
                    class="progress"
                    <?= $task['completo'] ? 'checked' : ''?>
                    >

                   <p class="task-description">
                       <?= $task['titulo']?>
                   </p>

                   <div class="task-actions">
                       <a class="action-button edit-button">
                           <i class="fa-regular fa-pen-to-square"></i>
                       </a>

                       <form action="index.php" method="POST">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="id" value="<?= $task['id']?>">
                            <button type="submit" class="action-button delete-button">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                       </form>

                   </div>

                   <form action="index.php" method='POST' class="to_do_form edit-task hidden">
                        <input type="hidden" name="acao" value="editar">
                        <input type="hidden" name="id" value="<?= $task['id']?>">
                        <input type="text" name="description" placeholder="Edite a sua tarefa aqui">

                       <button type="submit" class="form-button confirm-button">
                           <i class="fa-solid fa-check"></i>
                       </button>
                   </form>
               </div>
           <?php endforeach ?>
        </div>
    </div>
    
    <script src="/frontend/js/tela_prin.js"></script>
</body>
</html>