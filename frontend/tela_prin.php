<?php
require_once('../backend/database/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="/style/tela_prin.css">
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

            <form action="" class="to_do_form">
                <input type="text" name="description" placeholder="Escreva a sua tarefa aqui" required>
                <button type="submit" class="form-button">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </form>

            <div class="tasks">
                <div class="task">
                    <input type="checkbox" name="progress" class="progress">

                    <p class="task-description">
                        Tema de casa
                    </p>

                    <div class="task-actions">
                        <a class="action-button edit-button">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>

                        <a href="" class="action-button delete-button">
                        <i class="fa-regular fa-trash-can"></i>
                        </a>
                    </div>

                    <form action="" class="to_do_form edit-task hidden">
                        <input type="text" name="description" placeholder="Edite a sua tarefa aqui">

                        <button type="submit" class="form-button confirm-button">
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </form>

                </div>
            </div>
    
    </div>
    
    <script src="/js/tela_prin.js"></script>
</body>
</html>