<?php
/*O index.php manda nas demais classes, reutilizando e facilitando a manutenção do código*/
require_once __DIR__ . ('/backend/database/connection.php');
$pdo = (new Connection())->getConnection();

require_once __DIR__ . ('/backend/src/tasksController.php');
require_once __DIR__ . ('/backend/src/tasksRepository.php');
$repo = new TasksRepository($pdo);
$tasksController = new TasksController($repo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    switch ($acao) {

        case 'deletar_ajax':
            $tasksController->deletarTask_ajax();
            break;
        case 'editar_ajax':
            $tasksController->editarTask_ajax();
            break;
        case 'marcar_feita':
            /*$tasksController->marcarFeita();*/
            break;
        case 'criar_ajax':
            $tasksController->criar_ajax();
            break;
        default:
            header('Location: tela_prin.php?erro=acao_invalida');
            exit;
    }
}

require __DIR__ . '/frontend/tela_prin.php';